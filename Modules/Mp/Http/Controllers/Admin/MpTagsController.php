<?php

namespace Modules\Mp\Http\Controllers\Admin;


use EasyWeChat\Kernel\Exceptions\InvalidConfigException;
use GuzzleHttp\Exception\GuzzleException;

class MpTagsController extends MpController
{

    public $view = 'admin.mp_tags.';

    public $model = 'Modules\Mp\Models\MpTagsModel';

    /**
     * @throws InvalidConfigException
     */
    public function index($ident)
    {

        if (request()->ajax() && request()->wantsJson()) {

            $mp = $this->service->getMpObject($ident, 'id');
            $data = $mp->user_tag->list();
            $this->cache($ident, $data['tags']);

            return $this->success([
                'total' => count($data['tags']),
                'current_page' => 1,
                'last_page' => 1,
                'per_page' => count($data['tags']),
                'data' => $data['tags']
            ]);
        }

        return $this->view($this->view . 'index');
    }


    /**
     * @throws InvalidConfigException
     * @throws GuzzleException
     */
    public function store($ident)
    {
        $name = $this->param('name');

        $mp = $this->service->getMpObject($ident, 'id');
        $mp->user_tag->create($name);

        return $this->success();
    }


    /**
     * @throws InvalidConfigException
     */
    public function edit($ident)
    {
        $data = [];
        $tagId = $this->param('id');

        $mp = $this->service->getMpObject($ident, 'id');
        $list = $mp->user_tag->list();

        foreach ($list['tags'] as $tag) {
            if ($tag['id'] == $tagId) {
                $data = $tag;
                break;
            }
        }

        return $this->view($this->view . 'edit', compact('data'));
    }


    /**
     * @throws InvalidConfigException
     * @throws GuzzleException
     */
    public function update($ident)
    {
        $tagId = $this->param('id');
        $name = $this->param('name');

        $mp = $this->service->getMpObject($ident, 'id');
        $mp->user_tag->update($tagId, $name);

        return $this->success();
    }


    /**
     * @param $ident
     * @param $data
     * @return void
     */
    protected function cache($ident, $data = [])
    {
        $this->getModel()::where('mp_id', $ident)
            ->whereNotIn('tag_id', array_column($data, 'id'))
            ->delete();

        foreach ($data as $value) {

            $result = $this->getModel()::where('mp_id', $ident)
                ->where('tag_id', $value['id'])->first();

            if ($result) {
                $this->getModel()::where('mp_id', $ident)
                    ->where('tag_id', $value['id'])->update([
                        'name' => $value['name']
                    ]);
            } else {
                $this->getModel()::insert([
                    'mp_id' => $ident,
                    'tag_id' => $value['id'],
                    'name' => $value['name'],
                ]);
            }
        }
    }
}
