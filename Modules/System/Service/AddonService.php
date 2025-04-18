<?php


namespace Modules\System\Service;

use App\Models\Addon as model;
use Expand\Addon\Addon;
use Expand\Addon\Repository\AddonFileRepository;
use Illuminate\Container\Container;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Nwidart\Modules\Laravel\LaravelFileRepository;

class AddonService
{

    protected $fileRepository;
    protected $moduleRepository;

    protected $app;

    public function __construct(AddonFileRepository $fileRepository, LaravelFileRepository $moduleRepository, Container $app)
    {
        $this->fileRepository = $fileRepository;
        $this->moduleRepository = $moduleRepository;
        $this->app = $app;
    }


    /**
     * 未安装操作
     */
    public function getInstallHtml(string $ident): string
    {
        $prefix = system_config('admin_prefix') ?: 'admin';
        return '<button class="mx-1 btn btn-sm btn-primary waves-effect waves-light" data-request="/' . $prefix . '/addon/install/?ident=' . $ident . '" data-title="确定安装？"><i class="fa fa-plus"></i> 安装</button>';
    }

    /**
     * 已安装操作
     */
    public function getInstalledHtml(array $item): string
    {
        $html = '';
        $prefix = system_config('admin_prefix') ?: 'admin';
        $item['home'] = str_replace("/admin/", "/{$prefix}/", $item['home']);
        if ($item['home']) {

            $html .= $item['is_init'] === 0
                ? '<button class="mx-1 btn btn-sm btn-info waves-effect waves-light" data-request="/' . $prefix . '/addon/init/?ident=' . $item['ident'] . '" data-title="确定启用？">启用</button>'
                : '<a class="mx-1 btn btn-sm btn-primary waves-effect waves-light" href="' . $item['home'] . '">管理</a>';
        }

        $html .= '<button class="mx-1 btn btn-sm btn-danger waves-effect waves-light" data-request="/' . $prefix . '/addon/uninstall/?ident=' . $item['ident'] . '" data-title="确定卸载？"><i class="fa fa-trash-o"></i> 卸载</button>';

        return $html;
    }

    /**
     * 本地所有插件
     */
    public function all(): array
    {
        $addons = [];

        model::all()->each(function ($item) use (&$addons) {
            $addons[$item['ident']] = $item;
        });

        return array_map(function ($item) use ($addons) {

            $item = $item->toArray();
            $item['is_init'] = $addons[$item['ident']]['is_init'] ?? 0;
            $item['is_menu'] = $addons[$item['ident']]['is_menu'] ?? 0;
            $item['id'] = $addons[$item['ident']]['id'] ?? 0;

            $item['operation'] = in_array($item['ident'], array_keys($addons)) ? $this->getInstalledHtml($item) : $this->getInstallHtml($item['ident']);
            $item['installed'] = in_array($item['ident'], array_keys($addons)) ?? false;

            return $item;

        }, $this->fileRepository->scan());
    }

    /**
     * 插件安装
     */
    public function install(string $ident): bool
    {
        $addon = new Addon($this->app, $ident);

        $result = (new model())->store([
            'ident' => $addon->getIdent(),
            'name' => $addon->getName(),
            'version' => $addon->getVersion(),
            'description' => $addon->getDescription(),
            'author' => $addon->getAuthor(),
        ]);

        $this->makeCache();

        if ($result) {

            Artisan::call(
                'migrate --path=./Addons/' . $ident . '/Database/Migrations'
            );

            swoole_reload();
        }

        return $result;
    }

    /**
     * 插件卸载
     */
    public function uninstall(string $ident): bool
    {
        $result = (new model())->where('ident', $ident)->delete();

        $this->makeCache();

        if ($result) {

            Artisan::call(
                'migrate:rollback --path=./Addons/' . $ident . '/Database/Migrations'
            );

            swoole_reload();
        }

        return $result;
    }


    /**
     * 生成插件相关缓存
     */
    public function makeCache()
    {
        $statuses = $rules = $roles = [];

        $pipelines = config('pipe');

        foreach ($this->all() as $item) {

            Storage::disk("root")->deleteDirectory(
                "public/mycms/addons/" . strtolower(Str::snake($item['ident']))
            );

            Storage::disk("root")->delete(
                "bootstrap/cache/" . strtolower(Str::snake($item['ident'])) . "_addon.php"
            );

            if ($item['installed']) {

                $statuses[$item['ident']] = true;

                Storage::disk("root")->put(
                    "bootstrap/cache/" . strtolower(Str::snake($item['ident'])) . "_addon.php",
                    "<?php return " . var_export(['providers' => $item['providers'], 'eager' => $item['providers'], 'deferred' => []], true) . "; ?>");

                if (file_exists($path = addon_path($item['ident'], '/Config/behavior.php'))) {
                    $array = include_once $path;
                    foreach ($array as $key => $value) {
                        $rules[$key] = array_merge($rules[$key] ?? [], $value);
                    }
                }

                if (file_exists($path = addon_path($item['ident'], '/Config/role.php'))) {
                    $array = include_once $path;
                    $roles = array_merge($roles ?? [], $array);
                }

                if (file_exists($path = addon_path($item['ident'], '/Config/pipeline.php'))) {
                    $array = include_once $path;
                    $pipelines = array_merge($pipelines ?? [], $array);
                }

                Artisan::call(
                    'vendor:publish --tag=addon_' . strtolower(Str::snake($item['ident']))
                );

            }
        }

        Storage::disk("root")->put(
            'bootstrap/cache/role.php',
            "<?php return " . var_export($roles, true) . "; ?>"
        );

        Storage::disk("root")->put(
            'bootstrap/cache/pipeline.php',
            "<?php return " . var_export($pipelines, true) . "; ?>"
        );

        Storage::disk("root")->put('addons_statuses.json', json_encode($statuses));

        foreach (
            $this->moduleRepository->getByStatus(true)
            as $name => $module
        ) {
            if (file_exists(
                $path = module_path($name, 'Config/behavior.php')
            )) {
                $array = include_once $path;
                foreach ($array as $key => $value) {
                    $rules[$key] = array_merge($rules[$key] ?? [], $value);
                }
            }
        }

        Storage::disk("root")->put(
            'bootstrap/cache/behavior.php',
            "<?php return " . var_export($rules, true) . "; ?>"
        );

    }

    /**
     * 获取单个插件的信息
     */
    public function getAddonInfo($ident): Addon
    {
        return new Addon($this->app, $ident);
    }
}
