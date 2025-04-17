<?php


namespace Modules\System\Http\Controllers\Admin;


use App\Http\Controllers\MyAdminController;
use Illuminate\Http\JsonResponse;
use Modules\System\Models\DiyPage;

class DiyPageController extends MyAdminController
{
    public $model = 'Modules\System\Models\DiyPage';

    public $request = 'Modules\System\Http\Requests\DiyPageRequest';

    public $view = 'admin.diy_page.';


    public function getIndexWhere(): array
    {
        return [
            ['lang', '=', '']
        ];
    }


    public function afterStore($id)
    {
        $lang = $this->param('lang', '', []);
        $page = DiyPage::find($id);

        foreach ($lang as $key => $item) {

            $item['lang'] = $key;
            $item['page_path'] = $page->page_path;
            $item['page_template'] = $page->page_template;

            DiyPage::insert($item);
        }
    }

    /**
     * 编辑页
     */
    public function editAction()
    {
        $langPage = [];

        $data = $this->getModel()::with($this->editWith)
            ->find($this->param('id', 'intval'));

        if ($sysLang = system_tap_lang()) {

            $abb = array_keys($sysLang);

            $result = $this->getModel()::where('page_path', $data->page_path)
                ->whereIn('lang', $abb)
                ->get()
                ->toArray();

            foreach ($result as $item) {

                $langPage[$item['lang']] = $item;
            }
        }

        return $this->view($this->view . 'edit', compact('data', 'langPage'));
    }

    public function afterUpdate($id)
    {
        $lang = $this->param('lang', '', []);
        $page = DiyPage::find($id);

        foreach ($lang as $key => $item) {

            $item['lang'] = $key;
            $item['page_path'] = $page->page_path;
            $item['page_template'] = $page->page_template;

            DiyPage::where('id', $item['id'])->update($item);
        }
    }


    /**
     * 删除记录
     */
    public function destroy(): JsonResponse
    {
        $id = $this->param('id', 'intval');
        $item = $this->getModel()::find($id);

        $result = $this->getModel()::where('page_path', $item->page_path)->delete();

        return $this->result($result);
    }
}
