<?php

namespace Modules\Mp\Http\Controllers\Admin;

use EasyWeChat\Kernel\Exceptions\InvalidConfigException;
use GuzzleHttp\Exception\GuzzleException;

class MpMaterialController extends MpController
{
    public $view = 'admin.mp_material.';

    public $model = 'Modules\Mp\Models\MpMaterialModel';

    public $request = 'Modules\Mp\Http\Requests\MpMaterialRequest';

    /**
     * @throws InvalidConfigException
     * @throws GuzzleException
     */
    public function beforeDestroy($id)
    {
        $material = $this->getModel()::find($id);
        $this->service->deleteImage($material->mp_id, $material->media_id);
    }
}
