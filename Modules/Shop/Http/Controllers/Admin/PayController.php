<?php


namespace Modules\Shop\Http\Controllers\Admin;


use App\Http\Controllers\MyController;
use Illuminate\Http\Request;
use Modules\Shop\Models\PayLog;

class PayController extends MyController
{

    public function logs(Request $request)
    {
        if ($request->ajax() && $request->wantsJson()) {

            $point = PayLog::with('user:id,name')
                ->selectRaw("*,FROM_UNIXTIME(pay_time,'%Y-%m-%d %H:%i:%s') as pay_time")
                ->where($this->adminFilter($request->input('filter'), [
                    'user.name' => function ($value) {
                        $user = app('user')->user($value);
                        return ['user_id', '=', $user->id ?? 0];
                    }
                ], ['trade_type' => 'goods']))
                ->orderBy('id', 'desc')
                ->paginate($this->param('limit', 'intval'))->toArray();

            return $this->success($point);
        }

        return $this->view('admin.pay.logs');
    }

    public function config()
    {
        $systemConfig = system_config([]);
        return $this->view('admin.pay.config', compact('systemConfig'));
    }

    public function store()
    {
        $data = request()->all();
        $result = system_config_store($data, 'system');

        return $this->result($result);
    }
}
