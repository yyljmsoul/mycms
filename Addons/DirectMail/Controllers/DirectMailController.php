<?php

namespace Addons\DirectMail\Controllers;

use Addons\DirectMail\Models\DirectMailModel;
use App\Http\Controllers\MyAdminController;

class DirectMailController extends MyAdminController
{
    public $model = 'Addons\DirectMail\Models\DirectMailModel';

    public $request = 'Addons\DirectMail\Requests\DirectMailRequest';

    public $view = 'admin.direct_mail.';

    public function afterStore($id)
    {
        $this->defaultHandle($id);
        $this->makeDefaultCache();
    }

    public function afterUpdate($id)
    {
        $this->defaultHandle($id);
        $this->makeDefaultCache();
    }

    /**
     * 处理默认模板
     * @param $id
     * @return void
     */
    protected function defaultHandle($id)
    {
        $mail = DirectMailModel::find($id);

        if ($mail->is_default == 1) {

            DirectMailModel::where('id', '<>', $id)->update(['is_default' => 0]);
        }
    }

    /**
     * 生成默认配置缓存
     * @return void
     */
    protected function makeDefaultCache()
    {
        $array = [];

        $mail = DirectMailModel::where('is_default', 1)->first();

        if ($mail) {

            $array = $mail->toArray();
        }

        $array['transport'] = 'directmail';

        $array = array_merge(config('direct_mail'), $array);

        file_put_contents(
            addon_path('DirectMail', '/Config/config.php'),
            "<?php\n\nreturn " . var_export($array, true) . ";"
        );
    }
}
