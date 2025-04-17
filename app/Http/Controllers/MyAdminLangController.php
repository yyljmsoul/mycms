<?php

namespace App\Http\Controllers;

use Illuminate\Http\JsonResponse;

class MyAdminLangController extends MyAdminController
{

    protected $extendFields = [];

    public function getIndexWhere(): array
    {
        return [
            ['lang', '=', '']
        ];
    }


    public function afterStore($id)
    {
        $lang = $this->param('lang', '', []);
        $data = $this->getModel()::find($id);
        $data->lang_ident = $id;
        $data->save();

        foreach ($lang as $key => $item) {
            $item['lang'] = $key;
            $item['lang_ident'] = $id;

            if ($this->extendFields) {
                foreach ($this->extendFields as $field) {
                    $item[$field] = $data->{$field};
                }
            }

            $this->getModel()::insert($item);
        }
    }

    /**
     * 编辑页
     */
    public function edit()
    {
        $langPage = [];

        $data = $this->getModel()::with($this->editWith)
            ->find($this->param('id', 'intval'));

        if ($sysLang = system_lang()) {

            $abb = array_keys($sysLang);

            $result = $this->getModel()::where('lang_ident', $data->lang_ident)
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

        foreach ($lang as $key => $item) {
            $item['lang'] = $key;
            $this->getModel()::where('id', $item['id'])->update($item);
        }
    }

    /**
     * 删除记录
     */
    public function destroy(): JsonResponse
    {
        $id = $this->param('id', 'intval');
        $item = $this->getModel()::find($id);

        $result = $this->getModel()::where('lang_ident', $item->lang_ident)->delete();

        return $this->result($result);
    }
}
