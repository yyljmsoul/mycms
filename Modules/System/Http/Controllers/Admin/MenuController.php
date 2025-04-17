<?php


namespace Modules\System\Http\Controllers\Admin;


use App\Http\Controllers\MyController;
use Illuminate\Http\Request;
use Modules\System\Http\Requests\MenuStoreRequest;
use Modules\System\Http\Requests\MenuUpdateRequest;
use Modules\System\Models\Menu;
use Modules\System\Service\MenuService;

class MenuController extends MyController
{
    /**
     * 系统后台首页
     */
    public function index(Request $request)
    {
        if ($request->ajax() && $request->wantsJson()) {

            $menus = Menu::with('parent')->orderBy('id', 'desc')
                ->get()->toArray();

            return $this->success([
                'data' => $menus,
                'total' => count($menus),
                'per_page' => count($menus),
                'current_page' => 1,
                'last_page' => 1,
            ]);
        }

        return $this->view('admin.menu.index');
    }

    /**
     * 菜单添加页面
     */
    public function create(MenuService $menuService)
    {
        $menus = $menuService->menuTree();
        return $this->view('admin.menu.create', compact('menus'));
    }

    /**
     * 保存菜单
     */
    public function store(MenuStoreRequest $request, Menu $menu)
    {
        $data = $request->validated();
        $result = $menu->store($data);

        return $this->result($result);
    }

    /**
     * 编辑菜单页面
     */
    public function edit(MenuService $menuService)
    {
        $id = $this->param('id', 'intval');
        $menu = Menu::find($id);

        $menus = $menuService->menuTree();

        return $this->view('admin.menu.edit', compact('menu', 'menus'));
    }

    /**
     * 更新菜单
     */
    public function update(MenuUpdateRequest $request, Menu $menu)
    {
        $data = $request->validated();
        $result = $menu->up($data);

        return $this->result($result);
    }

    /**
     * 删除菜单
     */
    public function destroy()
    {
        $result = Menu::destroy($this->param('id', 'intval'));
        return $this->result($result);
    }

    /**
     * 菜单配置
     */
    public function config()
    {
        $config = system_config();
        return $this->view('admin.menu.config', compact('config'));
    }

    /**
     * 保存配置
     * @return \Illuminate\Http\JsonResponse
     */
    public function storeCfg(): \Illuminate\Http\JsonResponse
    {
        $data = [
            'menu_show_type' => $this->param('menu_show_type', 'intval'),
            'menu_default_open' => $this->param('menu_default_open', 'intval'),
        ];

        $result = system_config_store($data, 'system');

        return $this->result($result);
    }

    /**
     * 修改菜单字段
     */
    public function modify(): \Illuminate\Http\JsonResponse
    {
        $menu = Menu::find($this->param('id', 'intval'));
        $menu->{$this->param('field')} = $this->param('value');
        $result = $menu->save();

        return $this->result($result);
    }



    /**
     * 复制菜单
     * @return \Illuminate\Http\JsonResponse
     */
    public function copy()
    {
        $menu = Menu::find($this->param('id', 'intval'))->toArray();
        unset($menu['id']);

        $result = Menu::insert($menu);
        return $this->result($result);
    }
}
