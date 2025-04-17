<?php


namespace Addons\AliSms\Controllers;


use Addons\AliSms\Models\AliSms;
use Addons\AliSms\Models\AliSmsLog;
use Addons\AliSms\Requests\AliSmsRequest;
use App\Http\Controllers\MyController;
use Illuminate\Http\Request;

class AliSmsController extends MyController
{

    public function index(Request $request)
    {
        if ($request->ajax() && $request->wantsJson()) {
            $sms = AliSms::orderBy('id', 'desc')
                ->paginate($this->param('limit', 'intval'))->toArray();

            return $this->success($sms);
        }

        return $this->view('admin.index');
    }

    public function create()
    {
        return $this->view('admin.create');
    }

    public function store(AliSmsRequest $request, AliSms $sms)
    {
        $data = $request->validated();

        if ($data['is_default'] == 1) {

            AliSms::query()->update(['is_default' => 0]);
        }

        $result = $sms->store($data);

        return $this->result($result);
    }

    public function edit()
    {
        $sms = AliSms::find($this->param('id', 'intval'));

        return $this->view('admin.edit', compact('sms'));
    }

    public function update(AliSmsRequest $request, AliSms $sms)
    {
        if ($id = $this->param('id', 'intval')) {

            $data = $request->validated();
            $data['id'] = $id;

            if ($data['is_default'] == 1) {

                AliSms::query()->update(['is_default' => 0]);
            }

            $result = $sms->up($data);

            return $this->result($result);
        }

        return $this->result(false);
    }

    public function destroy()
    {
        $result = AliSms::destroy($this->param('id', 'intval'));
        return $this->result($result);
    }

    public function logs(Request $request)
    {
        if ($request->ajax() && $request->wantsJson()) {
            $logs = AliSmsLog::where('sms_id', $this->param('id', 'intval'))->orderBy('id', 'desc')
                ->paginate($this->param('limit', 'intval'))->toArray();

            return $this->success($logs);
        }

        return $this->view('admin.logs');
    }
}
