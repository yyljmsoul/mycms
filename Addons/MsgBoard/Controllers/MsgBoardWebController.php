<?php

namespace Addons\MsgBoard\Controllers;

use Addons\MsgBoard\Models\MsgBoardModel;
use Addons\MsgBoard\Requests\MsgBoardSubmitRequest;
use App\Http\Controllers\MyController;

class MsgBoardWebController extends MyController
{
    public function submit(MsgBoardSubmitRequest $request)
    {
        $data = $request->validated();

        if (empty($data['email']) && empty($data['phone'])) {

            return $this->result(false, ['msg' => '请填写联系方式']);
        }

        $result = MsgBoardModel::insert($data);

        return $this->result($result, ['msg' => '提交成功']);
    }
}
