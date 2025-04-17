<?php


namespace Modules\System\Http\ViewComposer;


use Illuminate\View\View;

class AdminComposer
{
    public function compose(View $view)
    {
        $route = request()->route();
        if ($route && in_array("admin.auth", $route->middleware())) {

            $roles = array_merge(config('role'), (config('role_ext') ?? []));;
            $reqPath = request()->route()->uri();
            $reqPath = strstr($reqPath, '/');
            $reqPath = "admin". $reqPath;
            $prevReqPath = mb_substr($reqPath, 0, strripos($reqPath, "/"));

            $params = request()->all();
            $prevReqUrl = request()->url();
            $prevReqUrl = mb_substr($prevReqUrl, 0, strripos($prevReqUrl, "/")) . '?' . http_build_query($params);

            $roleNodes = app('system')->getRoleNodes(system_admin_role_id());
            foreach ($roleNodes as &$node) {
                $node = "/" . ltrim($node, "/");
                if (strstr($node, '{') !== false) {
                    preg_match_all("/\{(.*)\}/", $node, $match);
                    if (isset($match[1])) {
                        foreach ($match[1] as $mt) {
                            $node = str_replace('{' . $mt . '}', request()->route()->parameter($mt), $node);
                        }
                    }
                }
            }

            $view->with([
                'system_menus' => (new \Modules\System\Service\MenuService)->leftMenu(),
                'system_version' => config('app.version'),
                'system_editor' => system_config('default_editor'),
                'current_page_name' => $roles[$reqPath] ?? '未命名页面',
                'prev_page_name' => $roles[$prevReqPath] ?? '',
                'prev_page_url' => isset($roles[$prevReqPath]) ? $prevReqUrl : '',
                'admin_role_nodes' => $roleNodes,
                'auth_admin_user' => auth()->guard('admin')->user()
            ]);
        }
    }
}
