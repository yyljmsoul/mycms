<?php

namespace Modules\Mp\Http\Controllers\Admin;

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Modules\Mp\Models\MpArticleModel;

class MpTemplateController extends MpController
{
    public $view = 'admin.mp_template.';

    public $model = 'Modules\Mp\Models\MpTemplateModel';

    public $request = 'Modules\Mp\Http\Requests\MpTemplateRequest';

    public function afterStore($id)
    {
        $this->putTemplate($id);
    }

    public function afterUpdate($id)
    {
        $this->putTemplate($id);
    }

    /**
     * 写入临时模板
     * @param $id
     * @return void
     */
    protected function putTemplate($id)
    {
        $template = $this->getModel()->find($id);
        Storage::disk('root')
            ->put('resources/views/mp_template/' . $id . '_content.blade.php', $template->content);
        Storage::disk('root')
            ->put('resources/views/mp_template/' . $id . '_title.blade.php', strip_tags($template->title));
    }

    /**
     * 预览效果
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View
     */
    public function preview()
    {
        $id = $this->param('id');
        $template = $this->getModel()->find($id);

        $data = collect($this->dataSource($template, true))->first();
        $data = json_decode(json_encode($data), true);
        $title = $this->makeTitle($id, $data);
        $content = $this->makeContent($id, $data);

        return $this->view($this->view . 'preview', compact('content', 'title'));
    }

    /**
     * 解析数据源
     * @param $template
     * @param $isPreview
     * @return array|mixed
     */
    protected function dataSource($template, $isPreview = false)
    {
        if ($template->ds_type == 'json') {

            return json_decode($template->json_data, true);

        } else {

            $query = DB::table($template->db_table);

            if ($template->db_condition) {
                $query = $query->whereRaw($template->db_condition);
            }

            if ($template->db_limit > 0) {
                $query = $query->limit($template->db_limit);
            }

            $result = $query->get()->toArray();
            if ($isPreview === false && $result && $template->db_action) {
                DB::update("update {$template->db_table} set {$template->db_action} where id in(" . join(",", array_column($result, 'id')) . ")");
            }

            return $result;
        }
    }

    /**
     * 编译内容
     * @param $id
     * @param $source
     * @return string
     */
    protected function makeContent($id, $source): string
    {
        return view("mp_template.{$id}_content", $source)->render();
    }

    /**
     * 编译标题
     * @param $id
     * @param $source
     * @return string
     */
    protected function makeTitle($id, $source): string
    {
        return view("mp_template.{$id}_title", $source)->render();
    }

    /**
     * @return \Illuminate\Http\JsonResponse
     */
    public function make()
    {
        $count = 0;
        $id = $this->param('id');
        $template = $this->getModel()->find($id);

        foreach ($this->dataSource($template) as $data) {

            $data = json_decode(json_encode($data), true);
            $title = $this->makeTitle($id, $data);
            $content = $this->makeContent($id, $data);

            MpArticleModel::insert([
                'title' => $title,
                'content' => $content,
            ]);

            $count++;
        }

        return $this->result(true, ['msg' => "成功生成{$count}条"]);

    }
}
