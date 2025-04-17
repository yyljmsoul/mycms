<?php


namespace Addons\Nav\Controllers;


use Addons\Nav\Models\Nav;
use Addons\Nav\Requests\NavRequest;
use App\Http\Controllers\MyController;
use Illuminate\Http\Request;

class NavController extends MyController
{

    public function index()
    {
        is_home(system_config());

        return is_mobile() ? $this->view('web.mobile') : $this->view('web.index');
    }

    /**
     * 后台导航列表
     * @param Request $request
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View|\Illuminate\Http\JsonResponse
     */
    public function show(Request $request)
    {
        if ($request->ajax() && $request->wantsJson()) {

            $where = [
                ['lang', '=', '']
            ];
            if ($json = $request->input('filter')) {
                $filters = json_decode($json, true);
                foreach ($filters as $name => $filter) {
                    if ($name == 'name') {
                        $where[] = [$name, 'like', "%{$filter}%"];
                    }
                    if ($name == 'parent.name') {
                        $parent = Nav::where('name', $filter)->first();
                        if ($parent) {
                            $where[] = ['pid', '=', $parent->id];
                        }
                    }
                }
            }

            $nav = Nav::with('parent')->orderBy('id', 'desc')
                ->where($where)
                ->paginate($this->param('limit', 'intval'))->toArray();

            return $this->success($nav);
        }

        return $this->view('admin.index');
    }

    /**
     * 后台新增导航
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View
     */
    public function create()
    {
        $navs = app('nav')->categoryTree();
        return $this->view('admin.create', compact('navs'));
    }

    /**
     * 保存导航
     * @param NavRequest $request
     * @param Nav $nav
     * @return \Illuminate\Http\JsonResponse
     */
    public function store(NavRequest $request, Nav $nav)
    {
        $data = $request->validated();
        $result = $nav->store($data);

        if ($result) {

            $this->langStore($nav->id);
        }

        return $this->result($result);
    }

    /**
     * 编辑页
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View
     */
    public function edit()
    {
        $navs = app('nav')->categoryTree();

        $id = $this->param('id', 'intval');
        $nav = Nav::find($id);

        $langPage = [];

        if ($sysLang = system_lang()) {

            $abb = array_keys($sysLang);

            $result = Nav::where('lang_ident', $nav->lang_ident)
                ->whereIn('lang', $abb)
                ->get()
                ->toArray();

            foreach ($result as $item) {

                $langPage[$item['lang']] = $item;
            }
        }

        return $this->view('admin.edit', compact('navs', 'nav', 'langPage'));
    }

    /**
     * 更新导航
     * @param NavRequest $request
     * @param Nav $nav
     * @return \Illuminate\Http\JsonResponse
     */
    public function update(NavRequest $request, Nav $nav)
    {
        if ($id = $this->param('id', 'intval')) {
            $data = $request->validated();
            $data['id'] = $id;

            $result = $nav->up($data);

            if ($result) {

                $this->langUpdate($id);
            }

            return $this->result($result);
        }

        return $this->result(false);
    }

    /**
     * 删除导航
     * @return \Illuminate\Http\JsonResponse
     */
    public function destroy()
    {
        $id = $this->param('id', 'intval');
        $item = Nav::find($id);

        $result = Nav::where('lang_ident', $item->lang_ident)->delete();

        return $this->result($result);
    }

    /**
     * 配置
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View
     */
    public function config()
    {
        $config = system_config([]);
        return $this->view('admin.config', compact('config'));
    }

    /**
     * 配置保存
     * @return \Illuminate\Http\JsonResponse
     */
    public function cfgStore()
    {
        $theme = $this->param('site_home_theme');
        $result = system_config_store(['site_home_theme' => $theme], 'system');

        return $this->result($result);
    }

    /**
     * 多语言更新
     * @param $id
     * @return void
     */
    public function langUpdate($id)
    {
        $lang = $this->param('lang', '', []);

        foreach ($lang as $key => $item) {
            $item['lang'] = $key;
            Nav::where('id', $item['id'])->update($item);
        }
    }

    /**
     * 多语言保存
     * @param $id
     * @return void
     */
    public function langStore($id)
    {
        $lang = $this->param('lang', '', []);
        $data = Nav::find($id);
        $data->lang_ident = $id;
        $data->save();

        foreach ($lang as $key => $item) {
            $item['lang'] = $key;
            $item['lang_ident'] = $id;
            Nav::insert($item);
        }
    }
}
