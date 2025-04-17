<?php

use Expand\Swoole\MySwoole;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Pipeline\Pipeline;
use Illuminate\Support\Facades\Storage;
use League\CommonMark\GithubFlavoredMarkdownConverter;
use Modules\Cms\Models\ArticleComment;
use Modules\Mp\Models\MpAccountModel;
use Modules\Order\Models\Order;
use Modules\Order\Models\OrderGoods;
use Modules\Shop\Models\Goods;
use Modules\Shop\Models\PayLog;
use Nwidart\Modules\Json;

if (!function_exists('join_data')) {
    /**
     * 将数组拼接成字符串(带单引号)
     * @param $array
     * @param $separator
     * @return string
     */
    function join_data($array, $separator = ''): string
    {
        $collect = array_map(function ($item) {
            return "'{$item}'";
        }, $array);

        return join($separator, $collect);
    }
}


if (!function_exists('addon_path')) {
    /**
     * 插件地址
     * @param $name
     * @param $path
     * @return string
     */
    function addon_path($name, $path = ''): string
    {
        return base_path('Addons/' . $name . $path);
    }
}


if (!function_exists('system_config')) {
    /**
     * 获取系统配置
     * @param $cfgKey
     * @param $group
     * @return array|false|mixed|string
     */
    function system_config($cfgKey = [], $group = 'system')
    {
        $config = system_config_cache($cfgKey, $group);

        if ($config === false) {

            try {

                $config = (new \Modules\System\Models\Config())
                    ->group($group)
                    ->getConfig(is_string($cfgKey) ? [$cfgKey] : $cfgKey);

            } catch (Exception $e) {

            }

            return is_string($cfgKey) ? ($config[$cfgKey] ?? false) : $config;
        }

        return $config;

    }
}


if (!function_exists('system_config_cache')) {
    /**
     * 从缓存中获取系统配置
     * @param $cfgKey
     * @param $group
     * @return array|false|mixed|string
     */
    function system_config_cache($cfgKey, $group)
    {
        $path = system_config_cache_path();

        if (file_exists(base_path($path))) {

            if (config('system_config') == null) {
                $config = include base_path($path);
            } else {
                $config = config('system_config');
            }

            $systemConfig = $config[$group] ?? [];

            if (empty($systemConfig)) {
                return is_string($cfgKey) ? '' : [];
            }

            if (is_string($cfgKey)) {
                return $systemConfig[$cfgKey] ?? '';
            }

            $array = [];
            foreach ($systemConfig as $key => $item) {
                if (empty($cfgKey) || in_array($key, $cfgKey)) {
                    $array[$key] = $item;
                }
            }

            return $array;
        }

        return false;
    }
}


if (!function_exists('update_system_config_cache')) {
    /**
     * 更新系统配置缓存
     * @return void
     */
    function update_system_config_cache()
    {

        $configs = \Modules\System\Models\Config::get();

        $formatConfig = [];

        foreach ($configs as $config) {

            $config = $config->toArray();

            $config['cfg_val'] = json_decode($config['cfg_val'], true) === null
                ? $config['cfg_val']
                : json_decode($config['cfg_val'], true);

            $formatConfig[$config['cfg_group']][$config['cfg_key']] = $config['cfg_val'];

        }

        \Illuminate\Support\Facades\Storage::disk('root')->put(
            system_config_cache_path(),
            "<?php \n\rreturn " . var_export($formatConfig, true) . ";"
        );

        swoole_reload();

    }
}

if (!function_exists('system_config_cache_path')) {

    /**
     * 配置缓存地址
     * @return string
     */
    function system_config_cache_path(): string
    {
        if (env('IS_WE7')) {

            $uniacid = session('uniacid');

            return "bootstrap/cache/system_config_{$uniacid}.php";
        }

        return 'bootstrap/cache/system_config.php';
    }
}


if (!function_exists('system_config_store')) {
    /**
     * 保存系统配置到数据库
     * @param $data
     * @param $group
     * @return bool|int
     */
    function system_config_store($data, $group)
    {
        $cfg = Modules\System\Models\Config::whereIn('cfg_key', array_keys($data))
            ->where('cfg_group', $group)->get()->toArray();

        $newConfigs = array_diff(
            array_keys($data),
            array_column($cfg, 'cfg_key')
        );

        foreach ($newConfigs as $cfg) {
            if ($data[$cfg] !== null) {
                (new Modules\System\Models\Config())->store([
                    'cfg_key' => $cfg,
                    'cfg_val' => is_array($data[$cfg])
                        ? json_encode($data[$cfg], JSON_UNESCAPED_UNICODE)
                        : $data[$cfg],
                    'cfg_group' => $group,
                ]);
            }
        }

        $result = (new Modules\System\Models\Config())->batchUpdate([
            'cfg_val' => ['cfg_key' => $data]
        ], "cfg_group = '{$group}'");

        update_system_config_cache();

        return $result;
    }
}


if (!function_exists('system_http_domain')) {
    /**
     * 获取当前域名
     * @return string
     */
    function system_http_domain(): string
    {
        return system_config('site_url');
    }
}


if (!function_exists('system_image_url')) {
    /**
     * 获取图片链接
     * @param $path
     * @return string
     */
    function system_image_url($path): string
    {
        if (strstr($path, '//') === false) {
            $disk = system_config('site_upload_disk');

            if ($disk == 'oss') {

                $config = system_config([], $disk);

                return isset($config['oss_url']) && $config['oss_url'] ?
                    $config['oss_url'] . $path :
                    "//" . $config['oss_bucket'] . "." . $config['oss_endpoint'] . "/" . $path;

            } elseif ($disk == 'qiniu') {

                $config = system_config([], $disk);

                return $config['qn_url'] . $path;

            } elseif (env('IS_WE7')) {

                return system_resource_url(str_replace('public/', '/', $path));
            }

            return system_config('site_url') . str_replace('public/', '/', $path);
        }

        return $path;
    }
}


if (!function_exists('system_resource_url')) {
    /**
     * 获取资源链接
     * @param $path
     * @return string
     */
    function system_resource_url($path): string
    {
        if (env('IS_WE7') && $name = env('WE7_ADDON_NAME')) {

            return "/addons/{$name}/public" . $path;
        }

        return $path;
    }
}


if (!function_exists('call_hook_function')) {
    /**
     * 调用插件函数
     * @param $name
     * @param ...$arg
     * @return false|mixed
     */
    function call_hook_function($name, ...$arg)
    {
        if (function_exists($name)) {
            return call_user_func($name, ...$arg);
        }
        return false;
    }
}


if (!function_exists('system_model_count')) {
    /**
     * 统计模型记录数
     * @param \App\Models\MyModel $model
     * @param $where
     * @return mixed
     */
    function system_model_count(\App\Models\MyModel $model, $where = [])
    {
        return $model::where($where)->count();
    }
}


if (!function_exists('system_model_sum')) {
    /**
     * 统计模型模型某个字段的总数
     * @param \App\Models\MyModel $model
     * @param $fields
     * @param $where
     * @return void
     */
    function system_model_sum(\App\Models\MyModel $model, $fields, $where = [])
    {
        if (is_string($fields)) {
            return $model::where($where)->sum($fields);
        }

        if (is_array($fields)) {
            $raws = array_map(function ($item) {
                return "SUM({$item}) as {$item}_sum";
            }, $fields);
            return $model::select(\Illuminate\Support\Facades\DB::raw(join(",", $raws)))->where($where)->first();
        }
    }
}


if (!function_exists("is_mobile")) {
    /**
     * 判断是否为手机端
     * @return bool
     */
    function is_mobile(): bool
    {

        if (isset ($_SERVER['HTTP_X_WAP_PROFILE'])) {
            return true;
        }

        $client = [
            'mobile', 'nokia', 'sony', 'ericsson', 'mot', 'samsung',
            'htc', 'sgh', 'lg', 'sharp', 'sie-', 'philips', 'panasonic',
            'alcatel', 'lenovo', 'iphone', 'ipod', 'blackberry', 'meizu',
            'android', 'netfront', 'symbian', 'ucweb', 'windowsce', 'palm',
            'operamini', 'operamobi', 'openwave', 'nexusone', 'cldc', 'midp', 'wap'
        ];

        if ($userAgent = request_user_agent()) {

            if (preg_match("/(" . implode('|', $client) . ")/i", $userAgent)) {

                return true;
            }
        }

        if (isset ($_SERVER['HTTP_ACCEPT'])) {
            if ((strpos($_SERVER['HTTP_ACCEPT'], 'vnd.wap.wml') !== FALSE) && (strpos($_SERVER['HTTP_ACCEPT'], 'text/html') === FALSE || (strpos($_SERVER['HTTP_ACCEPT'], 'vnd.wap.wml') < strpos($_SERVER['HTTP_ACCEPT'], 'text/html')))) {
                return true;
            }
        }

        return false;
    }
}


if (!function_exists('paramFilter')) {
    /**
     * 参数过滤
     * @param $value
     * @return array|mixed|string[]|null
     */
    function paramFilter($value) {

        if (is_array($value) || is_object($value)) {
            $array = array();
            foreach ($value as$k => $v) {
                $array[paramFilter($k)] = paramFilter($v);
            }
            return $array;
        }

        // 对字符串类型的数据进行处理
        if (is_string($value)) {

            // 防止XSS攻击
            $value = htmlspecialchars($value, ENT_QUOTES, 'UTF-8');

            // 过滤掉可能的危险HTML标签和JavaScript
            $value = strip_tags($value);

            // 过滤掉控制字符
            $value = preg_replace('/[\x00-\x1F\x7F]/', '',$value);

            // 其他必要的过滤逻辑
            $value = addslashes($value);
        }

        // 对于其他类型的数据（如整数、浮点数等），可能不需要过滤，或者需要根据具体情况添加过滤逻辑

        return $value;
    }

}


if (!function_exists('get_client_ip')) {
    /**
     * 获取客户端真实IP
     * @return mixed|string|null
     */
    function get_client_ip()
    {
        if (isset($_SERVER['HTTP_X_FORWARDED_FOR']) && $_SERVER['HTTP_X_FORWARDED_FOR']) {
            return explode(",", $_SERVER['HTTP_X_FORWARDED_FOR'])[0];
        }

        if (isset(request()->header()['x-forwarded-for'])) {
            return explode(",", request()->header()['x-forwarded-for'][0])[0];
        }

        return request()->getClientIp();
    }
}


if (!function_exists('get_img_suffix')) {
    /**
     * 获取图片文件格式
     * @param $name
     * @return false|mixed|string
     */
    function get_img_suffix($name)
    {
        $info = getimagesize($name);

        $suffix = false;

        if ($mime = $info['mime']) {
            $suffix = explode('/', $mime)[1];
        }

        return $suffix;
    }
}


if (!function_exists('get_resource_http_path')) {
    /**
     * 获取资源的http地址
     * @param $src
     * @param $url
     * @return mixed|string
     */
    function get_resource_http_path($src, $url)
    {

        if (substr($src, 0, 4) == 'http' || substr($src, 0, 2) == '//') {
            $imgUrl = $src;
        } else {
            $http = parse_url($url);
            $imgUrl = (
                substr($src, 0, 1) == '/'
                    ? $http['scheme'] . "://" . $http['host']
                    : dirname($url) . "/"
                ) . $src;
        }

        return $imgUrl;
    }
}


if (!function_exists('create_pay_log')) {
    /**
     * 创建支付记录
     * @param $userId
     * @param $total
     * @param $goodsId
     * @param $goodsName
     * @param $tradeType
     * @param $payType
     * @return false|string
     */
    function create_pay_log($userId, $total, $goodsId, $goodsName, $tradeType, $payType = 'dmf')
    {
        do {
            $tradeNo = date("YmdHi") . mt_rand(1111, 9999) . date("s");
            $log = PayLog::where('trade_no', $tradeNo)->first();
        } while ($log);

        $data = [
            'trade_no' => $tradeNo,
            'trade_type' => $tradeType,
            'user_id' => $userId,
            'goods_id' => $goodsId,
            'goods_name' => $goodsName,
            'total_amount' => $total,
            'pay_type' => $payType,
        ];

        $result = (new PayLog)->store($data);

        return $result ? $tradeNo : false;
    }
}


if (!function_exists('finish_pay_order')) {
    /**
     * 完成支付订单
     * @param $tradeNo
     * @return void
     */
    function finish_pay_order($tradeNo)
    {
        PayLog::where('trade_no', $tradeNo)->update(['status' => 1, 'pay_time' => time()]);

        $payLog = app('store')->payLogForTradeNo($tradeNo);

        if (function_exists("{$payLog->trade_type}_finish_order")) {
            call_user_func("{$payLog->trade_type}_finish_order", $tradeNo);
        }
    }
}


if (!function_exists('system_addons')) {
    /**
     * 获取系统已安装的插件
     * @throws Exception
     */
    function system_addons(): array
    {
        $addons = Json::make(base_path('addons_statuses.json'))->getAttributes();
        return array_keys($addons);
    }

}


if (!function_exists('pipeline_func')) {
    /**
     * 管道处理通用方法
     * @param $value
     * @param $ident
     * @param null $default
     * @return mixed
     */
    function pipeline_func($value, $ident, $default = null)
    {
        $pipes = config('pipeline')[$ident] ?? [];

        if ($pipes) {

            return app(Pipeline::class)
                ->send($value)
                ->through($pipes)
                ->then(function ($value) use ($default) {
                    return $value ?: ($default !== null ? $default : null);
                });
        }

        return $value;
    }
}


if (!function_exists('page_title')) {
    /**
     * 页面标题
     * @return array|false|mixed|string
     */
    function page_title()
    {
        $title = session('page_title');
        $pageIdent = session('the_page');

        if (function_exists("the_{$pageIdent}_title")) {
            $title = call_user_func("the_{$pageIdent}_title");
        }

        $title = pipeline_func($title, 'page_title');

        return $title ?: system_config('site_name');

    }
}


if (!function_exists('page_keyword')) {
    /**
     * 页面标题
     * @return mixed|string
     */
    function page_keyword()
    {
        $keyword = session('page_keyword');
        $pageIdent = session('the_page');

        if (function_exists("the_{$pageIdent}_keyword")) {
            $keyword = call_user_func("the_{$pageIdent}_keyword");
        }

        $keyword = pipeline_func($keyword, 'page_keyword');

        return $keyword ?: '';
    }
}


if (!function_exists('page_description')) {
    /**
     * 页面描述
     * @return mixed|string
     */
    function page_description()
    {
        $description = session('page_description');
        $pageIdent = session('the_page');

        if (function_exists("the_{$pageIdent}_description")) {
            $description = call_user_func("the_{$pageIdent}_description");
        }

        $description = pipeline_func($description, 'page_description');

        return $description ?: '';
    }
}


if (!function_exists('page_list')) {
    /**
     * 通用列表
     * @param $type
     * @param $page
     * @param $limit
     * @param $tag
     * @param $params
     * @return false|mixed
     */
    function page_list($type, $page = 1, $limit = 10, $tag = '', $params = [])
    {
        $tag = $tag ?: the_page();

        if (function_exists($tag . "_" . $type)) {

            $params[$tag . "_id"] = $params[$tag . "_id"] ?? the_page_id();
            $values = call_user_func($tag . "_" . $type, $page, $limit, $params);

            return pipeline_func($values, $tag . "_" . $type);
        }

        return false;
    }
}


if (!function_exists('article')) {
    /**
     * 获取文章详情
     * @param $id
     * @param $meta 是否获取拓展配置信息
     * @return mixed
     */
    function article($id, $meta = false)
    {
        return app('cms')->article($id, $meta);
    }
}


if (!function_exists('articles')) {
    /**
     * 文章列表
     * @param $page
     * @param $limit
     * @param $tag
     * @param $params
     * @return false|mixed
     */
    function articles($page = 1, $limit = 10, $tag = '', $params = [])
    {
        return page_list('articles', $page, $limit, $tag, $params);
    }
}


if (!function_exists('home_articles')) {

    /**
     * 首页文章列表
     * @param $page
     * @param $limit
     * @param $params
     * @return LengthAwarePaginator
     */
    function home_articles($page = 1, $limit = 10, $params = []): LengthAwarePaginator
    {
        return new_articles($page, $limit, $params);
    }
}


if (!function_exists('new_articles')) {

    /**
     * 最新文章列表
     * @param $page
     * @param $limit
     * @param $params
     * @return LengthAwarePaginator
     */
    function new_articles($page = 1, $limit = 10, $params = []): LengthAwarePaginator
    {
        return app('cms')->articlesForSort($page, $limit);
    }
}


if (!function_exists('hot_articles')) {

    /**
     * 热门文章列表
     * @param $page
     * @param $limit
     * @param $params
     * @return LengthAwarePaginator
     */
    function hot_articles($page = 1, $limit = 10, $params = []): LengthAwarePaginator
    {
        return app('cms')->articlesForSort($page, $limit, 'view');
    }
}


if (!function_exists('category_articles')) {

    /**
     * 分类文章列表
     * @param $page
     * @param $limit
     * @param $params
     * @return LengthAwarePaginator
     */
    function category_articles($page = 1, $limit = 10, $params = []): LengthAwarePaginator
    {
        return app('cms')->articleForCategory($params['category_id'], $page, $limit, $params['order'] ?? 'id', $params['sort'] ?? 'desc');
    }
}


if (!function_exists('category_hot_articles')) {

    /**
     * 分类最热文章列表
     * @param $page
     * @param $limit
     * @param $params
     * @return LengthAwarePaginator
     */
    function category_hot_articles($page = 1, $limit = 10, $params = []): LengthAwarePaginator
    {
        return app('cms')->articleForCategory($params['category_id'], $page, $limit, 'view');
    }
}


if (!function_exists('tag_articles')) {

    /**
     * 标签最新文章列表
     * @param $page
     * @param $limit
     * @param $params
     * @return LengthAwarePaginator
     */
    function tag_articles($page = 1, $limit = 10, $params = []): LengthAwarePaginator
    {
        return app('cms')->articleForTag($params['tag_id'], $page, $limit);
    }
}


if (!function_exists('search_articles')) {

    /**
     * 搜索最新文章列表
     * @param $page
     * @param $limit
     * @param $params
     * @return mixed
     */
    function search_articles($page = 1, $limit = 10, $params = [])
    {
        return app('cms')->articleForSearch($params['search'] ?? '', $page, $limit);
    }
}


if (!function_exists('attr_articles')) {

    /**
     * 属性最新文章列表
     * @param $page
     * @param $limit
     * @param $params
     * @return mixed
     */
    function attr_articles($page = 1, $limit = 10, $params = [])
    {
        return app('cms')->articleForAttr($params['name'] ?? '', $page, $limit);
    }
}


if (!function_exists('group_articles')) {

    /**
     * 分组文章列表
     * @param $page
     * @param $limit
     * @param $params
     * @return mixed
     */
    function group_articles($page = 1, $limit = 10, $params = [])
    {
        return app('cms')->articleForGroup($params['category_id'], $params['group_id'], $page, $limit);
    }
}


if (!function_exists('article_group')) {
    /**
     * 获取文章分组
     * @param $cid
     * @return mixed
     */
    function article_group($cid)
    {
        return app('cms')->articleGroup($cid);
    }
}

if (!function_exists('categories')) {
    /**
     * 分类列表
     * @param $pid
     * @return mixed
     */
    function categories($pid = 0)
    {
        $values = app('cms')->categoryTree($pid);
        return pipeline_func($values, 'categories');
    }
}


if (!function_exists('tags')) {
    /**
     * 标签列表
     * @param $limit
     * @return mixed
     */
    function tags($limit = 10)
    {
        $values = app('cms')->tags($limit);
        return pipeline_func($values, 'tags');
    }
}



if (!function_exists('rec_tags')) {
    /**
     * 标签列表
     * @param $limit
     * @return mixed
     */
    function rec_tags($limit = 10)
    {
        $values = app('cms')->rec_tags($limit);
        return pipeline_func($values, 'rec_tags');
    }
}


if (!function_exists('article_tags')) {
    /**
     * 文章标签列表
     * @param $articleId
     * @return mixed
     */
    function article_tags($articleId = false)
    {
        $articleId = $articleId ?: the_page_id();

        $values = app('cms')->tagForArticle($articleId);
        return pipeline_func($values, 'article_tags');
    }
}


if (!function_exists('article_tags_text')) {
    /**
     * 文章标签文本
     * @param $articleId
     * @return string
     */
    function article_tags_text($articleId = false): string
    {
        $articleId = $articleId ?: the_page_id();

        if ($tags = article_tags($articleId)) {

            return join(',', array_column($tags, 'tag_name'));
        }

        return '';
    }
}


if (!function_exists('article_comments')) {
    /**
     * 文章评论列表
     * @param $articleId
     * @param $rootId
     * @param $page
     * @param $limit
     * @return mixed
     */
    function article_comments($articleId, $rootId = 0, $page = 1, $limit = 10)
    {
        $values = app('cms')->commentForArticle($articleId, $rootId, $page, $limit);
        return pipeline_func($values, 'article_comments');
    }
}


if (!function_exists('comment')) {
    /**
     * 单条评论
     * @param $id
     * @param $singleId
     * @return mixed
     */
    function comment($id, $singleId = 0)
    {
        $param = [
            ['id', '=', $id],
            ['status', '=', 1],
        ];

        $singleId && $param[] = ['single_id', '=', $singleId];
        $comment = ArticleComment::where($param)->first();

        return pipeline_func($comment, 'comment');
    }
}


if (!function_exists('goods')) {
    /**
     * 商品列表
     * @param $page
     * @param $limit
     * @param $tag
     * @param $params
     * @return false|mixed
     */
    function goods($page = 1, $limit = 10, $tag = '', $params = [])
    {
        return page_list('goods', $page, $limit, $tag, $params);
    }
}


if (!function_exists('home_goods')) {

    /**
     * 首页商品列表
     * @param $page
     * @param $limit
     * @param $params
     * @return LengthAwarePaginator
     */
    function home_goods($page = 1, $limit = 10, $params = []): LengthAwarePaginator
    {
        return new_goods($page, $limit, $params);
    }
}


if (!function_exists('store_goods')) {

    /**
     * 商城首页商品列表
     * @param $page
     * @param $limit
     * @param $params
     * @return LengthAwarePaginator
     */
    function store_goods($page = 1, $limit = 10, $params = []): LengthAwarePaginator
    {
        return new_goods($page, $limit, $params);
    }
}


if (!function_exists('new_goods')) {

    /**
     * 最新商品列表
     * @param $page
     * @param $limit
     * @param $params
     * @return LengthAwarePaginator
     */
    function new_goods($page = 1, $limit = 10, $params = []): LengthAwarePaginator
    {
        return app('store')->filterCondition($params)->goodsList($page, $limit);
    }
}


if (!function_exists('hot_goods')) {

    /**
     * 热门商品列表
     * @param $page
     * @param $limit
     * @param $params
     * @return LengthAwarePaginator
     */
    function hot_goods($page = 1, $limit = 10, $params = []): LengthAwarePaginator
    {
        return app('store')->filterCondition($params)->goodsList($page, $limit, 'view');
    }
}


if (!function_exists('search_goods')) {

    /**
     * 搜索商品
     * @param $page
     * @param $limit
     * @param $params
     * @return mixed
     */
    function search_goods($page = 1, $limit = 10, $params = [])
    {
        return app('store')
            ->filterCondition($params)
            ->search(
                $params['search'] ?? '',
                $page,
                $limit,
                $params['order'] ?? 'id',
                $params['sort'] ?? 'desc'
            );
    }
}


if (!function_exists('attr_goods')) {

    /**
     * 属性商品列表
     * @param $page
     * @param $limit
     * @param $params
     * @return mixed
     */
    function attr_goods($page = 1, $limit = 10, $params = [])
    {
        return app('store')
            ->filterCondition($params)
            ->goodsForAttr(
                $params['name'] ?? '',
                $page,
                $limit,
                $params['order'] ?? 'id',
                $params['sort'] ?? 'desc'
            );
    }
}


if (!function_exists('store_category_goods')) {

    /**
     * 分类最新商品列表
     * @param $page
     * @param $limit
     * @param $params
     * @return LengthAwarePaginator
     */
    function store_category_goods($page = 1, $limit = 10, $params = []): LengthAwarePaginator
    {
        return app('store')
            ->filterCondition($params)
            ->goodsForCategory(
                $params['store_category_id'],
                $page,
                $limit,
                $params['order'] ?? 'id',
                $params['sort'] ?? 'desc'
            );
    }
}


if (!function_exists('store_category_hot_goods')) {

    /**
     * 分类最新商品列表
     * @param $page
     * @param $limit
     * @param $params
     * @return LengthAwarePaginator
     */
    function store_category_hot_goods($page = 1, $limit = 10, $params = []): LengthAwarePaginator
    {
        return app('store')->filterCondition($params)->goodsForCategory($params['store_category_id'], $page, $limit, 'view');
    }
}


if (!function_exists('store_category')) {

    /**
     * 商品分类列表
     * @return mixed
     */
    function store_category()
    {
        return app('store')->categoryTree();
    }
}


if (!function_exists('created_at_date')) {
    /**
     * 格式化日期
     * @param $dateTime
     * @param $format
     * @return false|string
     */
    function created_at_date($dateTime, $format = 'Y-m-d')
    {
        return date($format, strtotime($dateTime));
    }
}


if (!function_exists('friend_link')) {
    /**
     * 获取友情链接
     * @return mixed
     */
    function friend_link()
    {
        return pipeline_func([], 'friend_link');
    }
}


if (!function_exists('navs')) {
    /**
     * 获取导航
     * @return mixed
     */
    function navs()
    {
        return pipeline_func([], 'navs');
    }
}


if (!function_exists('ad')) {
    /**
     * 获取广告
     * @param $code
     * @return mixed
     */
    function ad($code)
    {
        $value = pipeline_func($code, 'ad', []);
        return $value == $code ? [] : $value;
    }
}


if (!function_exists('system_themes')) {
    /**
     * 扫描系统内模板
     * @return array
     * @throws \Illuminate\Contracts\Filesystem\FileNotFoundException
     */
    function system_themes(): array
    {
        $themes = [];
        $directories = Storage::disk('root')
            ->directories('Template');

        foreach ($directories as $item) {
            if (file_exists(base_path($item . '/theme.json'))) {
                $info = \Illuminate\Support\Facades\Storage::disk('root')
                    ->get($item . '/theme.json');
                $themes[] = json_decode($info, true);
            }
        }

        return $themes;
    }
}


if (!function_exists('api_param_sign')) {
    /**
     * API参数签名加密
     * @param $params
     * @return string
     */
    function api_param_sign($params): string
    {
        ksort($params);

        $string = '';
        foreach ($params as $key => $param) {
            if ($key != env('API_SIGN_NAME') && $param !== "") {
                $string .= "{$key}={$param}&";
            }
        }

        $string = trim($string, "&") . env('API_KEY');

        return md5($string);
    }
}


if (!function_exists('curl_download_get')) {
    /**
     * 下载资源 CURL
     * @param $url
     * @return bool|string
     */
    function curl_download_get($url)
    {
        $header = [
            'accept: text/html,application/xhtml+xml,application/xml;q=0.9,image/avif,image/webp,image/apng,*/*;q=0.8,application/signed-exchange;v=b3;q=0.9',
            'user-agent: Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/94.0.4606.61 Safari/537.36'
        ];

        $curl = curl_init();
        curl_setopt($curl, CURLOPT_URL, $url);
        curl_setopt($curl, CURLOPT_HEADER, 0);
        curl_setopt($curl, CURLOPT_TIMEOUT, 10);
        curl_setopt($curl, CURLOPT_HTTPHEADER, $header);
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($curl, CURLOPT_SSL_VERIFYHOST, false);

        $data = curl_exec($curl);
        $code = curl_getinfo($curl, CURLINFO_HTTP_CODE);

        if ($code != 200) {
            return false;
        } else {
            curl_close($curl);
            return $data;
        }
    }
}


if (!function_exists('request_user_agent')) {
    /**
     * 获取 User-Agent
     * @param $toLower
     * @return false|mixed|string
     */
    function request_user_agent($toLower = true)
    {
        if (isset ($_SERVER['HTTP_USER_AGENT'])) {

            return $toLower ? strtolower($_SERVER['HTTP_USER_AGENT']) : $_SERVER['HTTP_USER_AGENT'];
        }

        if (isset(request()->header()['user-agent'])) {

            return $toLower ? strtolower(request()->header()['user-agent'][0]) : request()->header()['user-agent'][0];
        }

        return false;
    }
}


if (!function_exists('is_pc')) {
    /**
     * 是否为PC客户端
     * @return bool
     */
    function is_pc(): bool
    {
        return !is_mobile();
    }
}


if (!function_exists('is_android')) {
    /**
     * 是否为安卓客户端
     * @return bool
     */
    function is_android(): bool
    {
        return strpos(request_user_agent(), 'android');
    }
}


if (!function_exists('is_ios')) {
    /**
     * 是否为苹果客户端
     * @return bool
     */
    function is_ios(): bool
    {
        return (strpos(request_user_agent(), 'iphone') || strpos(request_user_agent(), 'ipad'));
    }
}


if (!function_exists('is_wechat')) {
    /**
     * 是否为微信客户端
     * @return bool
     */
    function is_wechat(): bool
    {
        return strpos(request_user_agent(), 'micromessenger');
    }
}


if (!function_exists('is_alipay')) {
    /**
     * 是否为支付宝打开
     * @return bool
     */
    function is_alipay(): bool
    {
        return strpos(request_user_agent(), 'alipayclient');
    }
}


if (!function_exists('is_qq')) {
    /**
     * 是否为QQ打开
     * @return bool
     */
    function is_qq(): bool
    {
        return strpos(request_user_agent(), 'qq') && !is_wechat();
    }
}


if (!function_exists('is_unionpay')) {
    /**
     * 是否为云闪付打开
     * @return bool
     */
    function is_unionpay(): bool
    {
        return strpos(request_user_agent(), 'unionpay');
    }
}


if (!function_exists('goods_albums')) {
    /**
     * 获取商品相册
     * @param $goodsId
     * @return mixed
     */
    function goods_albums($goodsId)
    {
        return app('store')->goodsAlbums($goodsId);
    }
}


if (!function_exists("swoole_reload")) {

    /**
     * Swoole 热更新
     * @return void
     */
    function swoole_reload()
    {
        if (function_exists("swoole_cpu_num") && preg_match("/cli/i", php_sapi_name())) {

            $instance = MySwoole::getInstance();
            $instance->reload();
        }
    }
}


if (!function_exists("order_status_text")) {

    /**
     * 订单状态文本
     * @param $status
     * @return string
     */
    function order_status_text($status): string
    {
        return Order::ORDER_STATUS_TEXT[$status];
    }
}


if (!function_exists("delivery_status_text")) {

    /**
     * 订单发货状态文本
     * @param $status
     * @return string
     */
    function delivery_status_text($status): string
    {
        return Order::DELIVERY_STATUS_TEXT[$status];
    }
}


if (!function_exists("pay_status_text")) {

    /**
     * 支付状态文本
     * @param $status
     * @return string
     */
    function pay_status_text($status): string
    {
        return Order::PAY_STATUS_TEXT[$status];
    }
}


if (!function_exists("express_type_to_text")) {

    /**
     * 快递代码转文本
     * @param $code
     * @return string
     */
    function express_type_to_text($code): string
    {
        $expressCfg = config('express');

        $expressList = $expressCfg['api_list'][$expressCfg['default']]['express'];

        return $expressList[$code] ?? '';
    }
}


if (!function_exists("pay_type_to_text")) {

    /**
     * 支付代码转文本
     * @param $code
     * @return string
     */
    function pay_type_to_text($code): string
    {
        $payCfg = config('pay.pay_list');

        return $payCfg[$code]['name'] ?? '';

    }
}


if (!function_exists("order_logistics_detail")) {

    /**
     * 查询订单物流
     * @param $code
     * @param $type
     * @return array
     */
    function order_logistics_detail($code, $type): array
    {
        $object = new \Expand\Express\Express();
        return $object->query($type, $code);
    }
}


if (!function_exists("myRoute")) {

    /**
     * 系统自定义路由
     * @param $name
     * @param array $parameters
     * @param bool $absolute
     * @return string
     */
    function myRoute($name, array $parameters = [], bool $absolute = true): string
    {
        if (env('IS_WE7') && $addonName = env('WE7_ADDON_NAME')) {

            return "index.php?i=1&c=entry&do=mycms&m={$addonName}&route-url=" . route($name, $parameters, false);
        }

        return route($name, $parameters, $absolute);
    }
}

if (!function_exists('read_tree_recursively')) {

    /**
     * 读取树状结构数据
     * @param $items
     * @param $parent_id
     * @param $result
     * @param $level
     * @return array|mixed
     */
    function read_tree_recursively($items, $parent_id = 0, $result = [], $level = 1)
    {

        foreach ($items as $child) {

            $result[$child['id']] = [
                'id' => $child['id'],
                'parent_id' => $parent_id,
                'level' => $level
            ];

            if (!empty($child['child'])) {
                $result = read_tree_recursively($child['child'], $child['id'], $result, $level + 1);
            }
        }

        return $result;
    }
}


if (!function_exists('orderNotifyHandle')) {
    /**
     * 订单支付后回调操作
     * @param $orderSn
     * @param $payType
     * @param $outTradeNo
     * @return mixed
     */
    function orderNotifyHandle($orderSn, $payType, $outTradeNo = '')
    {
        $result = Order::where('order_sn', $orderSn)->update([
            'order_status' => Order::ORDER_STATUS_WAIT_DELIVER,
            'pay_status' => Order::PAY_STATUS_FINISH,
            'pay_type' => $payType,
            'pay_time' => time(),
            'out_trade_no' => $outTradeNo,
        ]);

        if ($result) {

            $order = Order::where('order_sn', $orderSn)->first();

            $goods = OrderGoods::where('order_id', $order->id)->get();

            foreach ($goods as $item) {

                Goods::where('id', $item->goods_id)->increment('sales', $item->number);
            }
        }

        return $result;
    }
}


if (!function_exists('template_config')) {

    /**
     * 获取模板配置
     * @param $page
     * @param $ident
     * @param string $lang
     * @return \Illuminate\Config\Repository|\Illuminate\Contracts\Foundation\Application|mixed|string
     */
    function template_config($page, $ident, $lang = '')
    {
        if ($lang) {

            return config("template.config.{$page}.{$lang}.{$ident}") ?? '';
        }

        return config("template.config.{$page}.{$ident}") ?? '';
    }
}

if (!function_exists('output_template_config')) {

    /**
     * 输出模板配置
     * @param $ident
     * @param string $page
     * @return false|\Illuminate\Config\Repository|\Illuminate\Contracts\Foundation\Application|mixed|string|string[]
     */
    function output_template_config($ident, string $page = '')
    {
        $page = $page ?: the_page();
        $lang = current_lang();
        $lang = $lang ?: (count(system_lang()) > 0 ? 'cn' : '');

        $config = template_config($page, $ident, $lang);

        foreach (config('template.system') as $sysCfg) {

            if ($sysCfg['page'] == $page) {

                foreach ($sysCfg['elements'] as $cfg) {

                    if ($cfg['ident'] == $ident) {

                        if (isset($cfg['output'])) {

                            if ($cfg['output'] == 'array') {

                                $config = $config ? explode($cfg['separator'] ?? "\n", $config) : [];
                            }
                        }

                        break;
                    }
                }
            }
        }

        return $config;
    }
}

if (!function_exists('otc')) {
    /**
     * 输出模板配置函数别名
     * @param $ident
     * @param string $page
     * @return false|\Illuminate\Config\Repository|\Illuminate\Contracts\Foundation\Application|mixed|string|string[]
     */
    function otc($ident, string $page = '')
    {
        return output_template_config($ident, $page);
    }
}

if (!function_exists('system_lang')) {

    /**
     * 获取系统开启的语言
     * @return array|false|mixed|string
     */
    function system_lang()
    {
        return system_config('lang') ?: [];
    }
}

if (!function_exists('system_tap_lang')) {

    /**
     * 获取系统开启的语言，仅用于后台
     * @return array
     */
    function system_tap_lang(): array
    {
        $tapLang = [];

        foreach (system_lang() as $lang => $name) {

            if ($lang != 'cn') {

                $tapLang[$lang] = $name;
            }
        }

        return $tapLang;
    }
}


if (!function_exists('system_default_lang')) {

    /**
     * 系统默认语言
     * @return array|false|mixed|string
     */
    function system_default_lang()
    {
        return system_config('default_lang') ?: '';
    }
}

if (!function_exists('system_lang_meta')) {

    /**
     * 获取系统开启的语言前缀
     * @return array
     */
    function system_lang_meta(): array
    {
        $result = [];

        foreach (system_lang() as $abb => $lang) {

            $result[] = "lang_{$abb}";
        }

        return $result;
    }
}


if (!function_exists('current_lang')) {

    /**
     * 获取当前语言
     * @return false|\Illuminate\Contracts\Foundation\Application|\Illuminate\Session\SessionManager|\Illuminate\Session\Store|mixed
     */
    function current_lang()
    {
        $lang = request()->getLocale();

        if (!$lang && system_lang()) {

            $lang = system_default_lang();
        }

        return $lang != 'cn' ? ($lang ?: '') : '';
    }
}

if (!function_exists('set_current_lang')) {

    /**
     * 设置当前的语言
     * @param $lang
     * @return void
     */
    function set_current_lang($lang)
    {
        if ($lang === '' || in_array($lang, array_keys(system_lang()))) {

            request()->setLocale($lang);
        }
    }
}

if (!function_exists('system_admin_id')) {
    /**
     * 当前管理员ID
     * @return mixed
     */
    function system_admin_id()
    {
        return auth()->guard('admin')->user()->getAuthIdentifier();
    }
}


if (!function_exists('system_admin_role_id')) {
    /**
     * 当前管理员权限分级
     * @return mixed
     */
    function system_admin_role_id()
    {
        return auth()->guard('admin')->user()->role_id;
    }
}

if (!function_exists('addonIsEnable')) {
    /**
     * 判断插件是否启用
     * @param $ident
     * @return bool
     */
    function addonIsEnable($ident): bool
    {
        $addons = [];

        if (file_exists(base_path('addons_statuses.json'))) {

            $array = json_decode(
                file_get_contents(base_path('addons_statuses.json')),
                true
            ) ?: [];

            $addons = array_keys($array);
        }

        return in_array($ident, $addons);
    }
}


if (!function_exists('category')) {

    /**
     * 分类信息
     * @param int $id
     * @return mixed
     */
    function category(int $id = 0)
    {
        $id = $id ?: the_page_id();

        return app('cms')->category($id);
    }
}


if (!function_exists('tplRoute')) {

    /**
     * 多语言模板路由
     * @param $name
     * @param array $parameters
     * @param bool $absolute
     * @return string
     */
    function tplRoute($name, array $parameters = [], bool $absolute = true): string
    {
        $prefix = '';

        if (system_lang()) {

            $lang = session('lang');
            $dftLang = system_default_lang();

            if ($lang && $lang !== $dftLang) {

                $prefix = $absolute ? system_config('site_url') . "/" . $lang : "/" . $lang;
            }
        }

        return $prefix . route($name, $parameters, false);
    }
}

if (!function_exists('mpAccounts')) {

    /**
     * 返回所有自媒体账号
     * @return mixed
     */
    function mpAccounts()
    {
        return MpAccountModel::get();
    }
}

if (!function_exists('tpl_lang_url')) {

    /**
     * 模板多语言URL地址
     * @param $path
     * @return string
     */
    function tpl_lang_url($path): string
    {
        if ($lang = current_lang()) {
            $path = "/" . $lang . $path;
        }

        return $path;
    }
}

if (!function_exists('system_theme')) {
    /**
     * 系统当前模板
     * @return array|false|mixed|string
     */
    function system_theme()
    {
        return system_config('cms_theme') ?: 'default';
    }
}

if (!function_exists("system_theme_files")) {
    /**
     * 获取模板下文件
     * @param $tpl
     * @return array
     */
    function system_theme_files($tpl = ''): array
    {
        $tpl = $tpl ?: system_theme();
        $files = Storage::disk('root')
            ->files("Template/{$tpl}/views");

        $themeFiles = [];
        foreach ($files as $file) {
            if (strstr($file, '.blade.php') !== false) {
                $themeFiles[] = [
                    'name' => str_replace(["Template/{$tpl}/views/", "Template\\{$tpl}\\views\\", '.blade.php'], "", $file),
                    'path' => $file,
                ];
            }

        }

        return $themeFiles;
    }
}


if (!function_exists('mp_menus')) {

    /**
     * 获取菜单列表
     * @param $mpId
     * @param $pid
     * @return mixed
     */
    function mp_menus($mpId, $pid = 0)
    {
        return app('mp')->getMenus($mpId, $pid);
    }
}

if (!function_exists('mp_tags')) {

    /**
     * 获取菜单列表
     * @param $mpId
     * @return mixed
     */
    function mp_tags($mpId)
    {
        return app('mp')->getMpTags($mpId);
    }
}


if (!function_exists('admin_has_auth')) {

    /**
     * 获取菜单列表
     * @param $node
     * @return bool
     */
    function admin_has_auth($node): bool
    {
        $roleService = new \Modules\System\Service\RoleService();
        $node = str_replace("/admin/", "/" . (system_config('admin_prefix') ?: 'admin') . "/", $node);
        return $roleService->adminHasAuth($node);
    }
}

if (!function_exists('apiDiyHandles')) {
    /**
     * 获取自定义API操作
     * @return array
     */
    function apiDiyHandles(): array
    {
        return Storage::disk('root')
            ->files("Expand/Api/handles");
    }
}



if (!function_exists('markdown_to_html')) {
    /**
     * markdown转html
     * @param $markdown
     * @return string
     */
    function markdown_to_html($markdown)
    {
        $converter = new GithubFlavoredMarkdownConverter();
        return $converter->convertToHtml($markdown);
    }
}
