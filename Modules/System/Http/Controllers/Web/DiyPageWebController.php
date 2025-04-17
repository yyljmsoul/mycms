<?php


namespace Modules\System\Http\Controllers\Web;


use App\Http\Controllers\MyController;

class DiyPageWebController extends MyController
{

    public function show()
    {
        $path = request()->path();

        $diyPage = app('system')->diyPage($path);

        if ($diyPage) {

            if ($diyPage->redirect_url) {
                return redirect()->to($diyPage->redirect_url);
            }

            is_diy_page($diyPage);
            return $this->theme($diyPage->page_template ?: 'diy-page', compact('diyPage'));
        }

        abort(404);
    }

}
