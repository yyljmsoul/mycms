<?php

namespace App\Models;

use App\Helpers\RepositoryHelpers;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class MyModel extends Model
{
    use HasFactory, RepositoryHelpers;

    /**
     * 微擎特殊处理表
     * @var string[]
     */
    const tables = [
        "my_article",
        "my_article_category",
        "my_article_category_meta",
        "my_article_comment",
        "my_article_meta",
        "my_article_tag",
        "my_article_tag_rel",
        "my_order",
        "my_order_goods",
        "my_diy_page",
        "my_pay_log",
        "my_shop_cart",
        "my_shop_category_meta",
        "my_shop_goods",
        "my_shop_goods_albums",
        "my_shop_goods_category",
        "my_shop_goods_meta",
        "my_system_admin",
        "my_system_attr",
        "my_system_config",
        "my_system_menu",
        "my_system_role",
        "my_user",
        "my_user_address",
        "my_user_balance",
        "my_user_meta",
        "my_user_point",
        "my_user_rank",
    ];

    /**
     * 单条记录插入
     * @param $data
     * @return mixed
     */
    public static function insert($data)
    {
        $object = new static();
        $object->store($data);

        return $object->{$object->getKeyName()} ?? false;
    }

    /**
     * 批量数据插入
     * @param $data
     */
    public static function insertAll($data)
    {
        if ($data) {

            $object = new static();

            if (env('IS_WE7') && in_array($object->getTable(), static::tables)) {

                $uniacid = session('uniacid');

                foreach ($data as &$item) {

                    $item['uniacid'] = $uniacid;
                }
            }

            DB::table($object->getTable())->insert($data);
        }
    }

    /**
     * 修改数据
     * @param $condition
     * @param $data
     * @return bool
     */
    public static function modify($condition, $data): bool
    {
        if (is_numeric($condition)) {

            $object = new static();
            $data[$object->getKeyName()] = $condition;

            return $object->up($data);
        }

        if (is_array($condition)) {

            return static::where($condition)->update($data);
        }

        return false;
    }

    /**
     * 只查询 status 为 1 的作用域。
     *
     * @param Builder $query
     * @return void
     */
    public function scopeStatus(Builder $query)
    {
        $query->where('status', 1);
    }

    /**
     * 设置单项服务全局条件
     */
    protected static function boot()
    {
        parent::boot();

        $object = new static();

        if (env('IS_WE7') && in_array($object->getTable(), static::tables)) {

            $uniacid = session('uniacid');

            static::addGlobalScope('avaiable', function (Builder $builder) use ($uniacid) {
                $builder->where('uniacid', '=', $uniacid);
            });
        }
    }


    /**
     * 处理多语言适配
     * @param $meta
     * @return mixed
     */
    protected static function langMeta($meta)
    {
        if (strstr($meta->meta_key, "lang_") === false) {

            return $meta->meta_value;

        } else {

            $value = json_decode($meta->meta_value, true);

            return $value !== null ? $value : $meta->meta_value;
        }
    }

    /**
     * 获取模型对象多语言数据
     * @param $ident
     * @param $name
     * @return MyModel|mixed|void
     */
    public function getModelLang($ident, $name = '')
    {
        if ($lang = current_lang()) {

            foreach ($this->{"lang_{$lang}_{$ident}"} ?: [] as $key => $value) {

                $this->setAttribute($key, $value);
            }
        }

        return $name ? $this->{$name} : $this;
    }
}
