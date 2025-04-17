<?php


namespace Modules\System\Service;


use App\Service\MyService;
use Expand\Addon\Addon;
use Modules\System\Models\Attr;
use Modules\System\Models\DiyPage;
use Modules\System\Models\Menu;
use Modules\System\Models\Region;
use Modules\System\Models\Role;

class SystemService extends MyService
{

    /**
     * 获取地区列表
     * @param $pid
     * @return mixed
     */
    public function regions($pid = 0)
    {
        return Region::where('pid', $pid)->get();
    }

    /**
     * 插件添加到菜单
     * @param $name
     * @param $homePath
     * @return bool
     */
    public function addonToMenu($name, $homePath): bool
    {

        $addonMenu = Menu::where('title', '系统插件')->first();

        if (!$addonMenu) {

            $addonMenu = new Menu();

            $addonMenu->store([
                'pid' => 0,
                'title' => '系统插件',
                'url' => '',
                'icon' => 'fa fa-bars',
                'target' => '_self',
                'sort' => '0',
            ]);
        }

        $data = [
            'pid' => $addonMenu->id,
            'title' => $name,
            'url' => $homePath,
            'icon' => 'fa fa-bars',
            'target' => '_self',
            'sort' => '0',
        ];

        return (new Menu())->store($data);
    }

    /**
     * 删除插件菜单
     * @param $homePath
     * @return mixed
     */
    public function addonRemoveForMenu($homePath)
    {
        return Menu::where([
            ['url', '=', $homePath],
        ])->delete();
    }

    /**
     * 获取系统辅助属性
     * @param string $type
     * @return array
     */
    public function attributes(string $type = ''): array
    {
        if ($type) {

            return Attr::where('type', $type)->get()->toArray();
        }

        return Attr::get()->toArray();
    }

    /**
     * 获取系统是否安装某个插件
     * @param $ident
     * @return bool
     */
    public function addonEnabled($ident): bool
    {
        $addon = new Addon(app(), $ident);
        return $addon->isEnabled();
    }

    /**
     * 通过地址获取单个页面
     * @param $path
     * @return mixed
     */
    public function diyPage($path)
    {
        return DiyPage::where('page_path', $path)->where('lang', current_lang())->first();
    }

    /**
     * 获取所有页面
     * @return mixed
     */
    public function diyPages()
    {
        return DiyPage::where('lang', current_lang())->get();
    }


    /**
     * @param $id
     * @return array|mixed
     */
    public function getRoleNodes($id)
    {
        $role = Role::find($id);

        return $role ? json_decode($role->role_node, true) : [];
    }
}
