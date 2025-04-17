<?php


namespace Addons\Nav\Models;


use App\Models\MyModel;

class Nav extends MyModel
{
    protected $table = 'my_nav';

    public function parent()
    {
        return $this->hasOne('Addons\Nav\Models\Nav', 'id', 'pid');
    }

    public static function toTree()
    {
        $navs = self::where('lang', current_lang())->orderBy('sort', 'asc')->get();

        collect($navs)->each(function ($item) use (&$result) {
            $result[$item['pid']][] = $item;
        });

        return $result;
    }

}
