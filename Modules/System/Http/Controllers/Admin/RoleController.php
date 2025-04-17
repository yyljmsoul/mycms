<?php


namespace Modules\System\Http\Controllers\Admin;


use App\Http\Controllers\MyController;
use Illuminate\Http\Request;
use Modules\System\Http\Requests\RoleStoreRequest;
use Modules\System\Http\Requests\RoleUpdateRequest;
use Modules\System\Models\Role;
use Modules\System\Service\RoleService;

class RoleController extends MyController
{

    /**
     * 角色列表
     */
    public function index(Request $request)
    {
        if ($request->ajax() && $request->wantsJson()) {

            $roles = Role::orderBy('id', 'desc')
                ->paginate($this->param('limit', 'intval'))->toArray();

            return $this->success($roles);
        }

        return $this->view('admin.role.index');
    }

    /**
     * 添加角色页面
     */
    public function create()
    {
        return $this->view('admin.role.create');
    }

    /**
     * 保存角色
     */
    public function store(RoleStoreRequest $request, Role $role)
    {
        $data = $request->validated();
        $result = $role->store($data);

        return $this->result($result);
    }

    /**
     * 编辑角色页面
     */
    public function edit()
    {
        $role = Role::find($this->param('id', 'intval'));
        return $this->view('admin.role.edit', compact('role'));
    }

    /**
     * 更新角色
     */
    public function update(RoleUpdateRequest $request, Role $role)
    {
        $data = $request->validated();
        $result = $role->up($data);

        return $this->result($result);
    }

    /**
     * 删除角色
     */
    public function destroy()
    {
        $result = Role::destroy($this->param('id', 'intval'));
        return $this->result($result);
    }

    /**
     * 角色授权页面
     */
    public function showAuth(RoleService $roleService, Request $request)
    {

        $role = Role::find($this->param('id', 'intval'));

        $nodes = $roleService->toTree(json_decode($role->role_node ?: '[]', true));

        return $this->view('admin.role.auth', compact('role', 'nodes'));
    }

    /**
     * 角色授权
     */
    public function auth()
    {
        $nodes = array_unique(array_values($this->param('nodes')));
        $nodes[] = 'admin';
        $nodes[] = 'admin/index';
        $result = Role::where('id', $this->param('id', 'intval'))
            ->update(['role_node' => json_encode($nodes)]);

        return $this->result($result);
    }

}
