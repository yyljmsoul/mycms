<?php


namespace Modules\System\Http\Controllers\Admin;


use App\Http\Controllers\MyController;
use App\Models\Addon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Str;
use Modules\System\Service\AddonService;

class AddonController extends MyController
{

    protected $addonService;

    public function __construct(AddonService $addonService)
    {
        $this->addonService = $addonService;
    }

    /**
     * 插件列表页
     */
    public function index(Request $request)
    {

        if ($request->ajax() && $request->wantsJson()) {
            $data = $this->addonService->all();
            return $this->success([
                'data' => $data,
                'total' => count($data),
                'per_page' => count($data),
                'current_page' => 1,
                'last_page' => 1,
            ]);
        }

        return $this->view('admin.addon.index');
    }

    /**
     * 插件安装操作
     */
    public function install()
    {
        $ident = $this->param('ident');
        $result = $this->addonService->install($ident);

        return $this->result($result);
    }

    /**
     * 插件卸载操作
     */
    public function uninstall()
    {
        $ident = $this->param('ident');
        $result = $this->addonService->uninstall($ident);

        return $this->result($result);
    }

    /**
     * 插件初始化操作
     */
    public function init()
    {
        $ident = $this->param('ident');

        Artisan::call(
            'vendor:publish --tag=addon_' . strtolower(Str::snake($ident))
        );

        Addon::where('ident', $ident)->update(['is_init' => 1]);

        return $this->result(true);
    }

    /**
     * 显示在菜单
     */
    public function modify()
    {
        if ($id = $this->param('id', 'intval')) {

            $addon = Addon::find($id);

            if ($this->param('field') == 'is_menu') {

                $addonInfo = $this->addonService->getAddonInfo($addon->ident);

                if (!$addonInfo->getHome()) {

                    return $this->result(false, ['msg' => '该插件无法设置为菜单']);
                }

                $this->param('value') == 1 ?
                    app('system')->addonToMenu($addon->name, $addonInfo->getHome()) :
                    app('system')->addonRemoveForMenu($addonInfo->getHome());

            }

            $addon->{$this->param('field')} = $this->param('value');
            $result = $addon->save();

            return $this->result($result);
        }

        return $this->result(false);
    }

}
