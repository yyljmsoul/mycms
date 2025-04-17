<?php


namespace Modules\User\Http\Controllers\Admin;


use App\Http\Controllers\MyController;
use Illuminate\Http\Request;
use Modules\User\Models\UserBalance;

class BalanceController extends MyController
{

    public function index(Request $request)
    {
        if ($request->ajax() && $request->wantsJson()) {

            $balance = UserBalance::with(['user:id,name'])->orderBy('id', 'desc')
                ->where($this->adminFilter($request->input('filter'),
                    ['user.name' => function ($value) {
                        $user = app('user')->user($value);
                        return ['user_id', '=', $user->id ?? 0];
                    }]))
                ->paginate($this->param('limit', 'intval'))->toArray();

            return $this->success($balance);
        }
        return $this->view('admin.balance.index');
    }

}
