<?php


namespace Addons\SystemLog\Controllers;


use Addons\SystemLog\Models\SystemLog;
use App\Http\Controllers\MyController;
use Illuminate\Http\Request;

class SystemLogController extends MyController
{

    /**
     * 系统记录列表
     */
    public function index(Request $request)
    {

        if ($request->ajax() && $request->wantsJson()) {
            $admins = SystemLog::orderBy('id', 'desc')
                ->paginate($this->param('limit', 'intval'))->toArray();

            return $this->success($admins);
        }

        return $this->view('admin.system_log.index');
    }

    /**
     * 系统记录详情
     */
    public function show()
    {
        $systemLog = SystemLog::find($this->param('id', 'intval'));
        return $this->view('admin.system_log.show', compact('systemLog'));
    }

}
