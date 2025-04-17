<?php


namespace Modules\System\Service;


use Modules\System\Models\Menu;

class MenuService
{

    public function menuTree($menus = [], $pid = 0, $prefix = '')
    {
        $menus = $menus ?: Menu::toTree();

        if (isset($menus[$pid]) && is_array($menus[$pid])) {

            collect($menus[$pid])->each(function ($item) use (&$result, $menus, $prefix) {
                $result[] = ['id' => $item['id'], 'title' => $prefix . $item['title']];
                $child = $this->menuTree($menus, $item['id'], "{$prefix}__");
                if (is_array($child)) {
                    $result = array_merge($result, $child);
                }
            });

            return $result;
        }

    }

    /**
     * 获取管理员菜单
     * @return mixed
     */
    public function leftMenu()
    {
        $roleId = system_admin_role_id();
        if ($roleId !== 1) {
            $roleNodes = app('system')->getRoleNodes(system_admin_role_id());
            foreach ($roleNodes as &$node) {
                $node = "/". ltrim($node, "/");
            }
            //兼容以往版本
            $roleNodes[] = '/user/admin/';
            $menus = Menu::where('status', 1)->whereIn('url', $roleNodes ?: ['-'])
                ->orWhere('url', '')
                ->orderBy('sort', 'asc')->get();
        } else {
            $menus = Menu::where('status', 1)->orderBy('sort', 'asc')->get();
        }

        collect($menus)->each(function ($item) use (&$result) {
            $result[$item['pid']][] = $item;
        });

        return $result;
    }


}
