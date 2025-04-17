<?php


namespace Addons\SiteMap\Controllers;


use App\Http\Controllers\MyController;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Storage;
use Modules\Cms\Models\Article;
use Modules\Cms\Models\ArticleCategory;
use Modules\Cms\Models\ArticleTag;
use Modules\Shop\Models\Goods;
use Modules\Shop\Models\GoodsCategory;

class SiteMapController extends MyController
{

    const NUMBER = 10000;

    public function index()
    {
        return $this->view('admin.index');
    }


    /**
     * 生成网站地图
     * @return JsonResponse
     */
    public function make(): JsonResponse
    {
        $array = [
            'common', 'category', 'article', 'tag', 'goods', 'extend'
        ];

        $data = [];

        foreach ($array as $item) {

            $data[] = $this->makeMap($item);
        }

        return $this->result($this->makeIndex($data));
    }

    /**
     * 仅更新网站地图索引
     * @return JsonResponse
     */
    public function update(): JsonResponse
    {
        $files = Storage::disk('root')
            ->files('public/sitemap/index');

        foreach ($files as &$file) {

            $file = str_replace("public", system_config('site_url'), $file);
        }

        return $this->result($this->makeIndex($files));
    }

    /**
     * 生成索引地图
     * @param $data
     * @return bool
     */
    public function makeIndex($data): bool
    {
        $siteMap = '<?xml version="1.0" encoding="UTF-8"?>
                        <sitemapindex xmlns="http://www.sitemaps.org/schemas/sitemap/0.9">';

        foreach ($data as $map) {

            if (is_string($map)) {
                $siteMap .= !empty($map) ? '<sitemap><loc>' . $map . '</loc></sitemap>' : '';
            } else {
                foreach ($map as $m) {
                    $siteMap .= '<sitemap><loc>' . $m . '</loc></sitemap>';
                }
            }
        }

        $siteMap .= '</sitemapindex>';

        return Storage::disk('root')->put('public/sitemap/sitemap.xml', $siteMap);
    }

    /**
     * 生成单个地图
     * @param $ident
     * @return false|mixed
     */
    public function makeMap($ident)
    {
        return call_user_func([$this, $ident . "Map"]);
    }

    /**
     * 数据转XML文件
     * @param $data
     * @param $path
     */
    public function makeXml($data, $path)
    {

        $xml = '<?xml version="1.0" encoding="UTF-8"?>';
        $xml .= '<urlset
      xmlns="http://www.sitemaps.org/schemas/sitemap/0.9"
      xmlns:xsi="http://www.w3.org/2001/XMLSchema-instance"
      xsi:schemaLocation="http://www.sitemaps.org/schemas/sitemap/0.9
            http://www.sitemaps.org/schemas/sitemap/0.9/sitemap.xsd">';

        foreach ($data as $item) {

            $priority = $item['priority'] ?? 0.8;
            $xml .= "<url><loc>{$item['url']}</loc><lastmod>{$item['date']}</lastmod><priority>{$priority}</priority></url>";
        }

        $xml .= '</urlset>';

        Storage::disk('root')->put('public' . $path, $xml);

        Cache::put(md5($path), count($data));
    }

    /**
     * 数据转XML文件(供外部调用)
     * @param $data
     * @param $path
     */
    public static function makeMapXml($data, $path)
    {
        (new self())->makeXml($data, $path);
    }

    /**
     * 是否需要更新
     * @param $path
     * @return bool
     */
    public function isUpdate($path): bool
    {
        if (!Storage::disk('root')->exists('public' . $path)) {

            return true;
        }

        if (Cache::get(md5($path)) < self::NUMBER) {

            return true;
        }

        return false;
    }

    /**
     * 是否需要更新(供外部调用)
     * @param $path
     * @return bool
     */
    public static function mapUpdate($path): bool
    {
        return (new self)->isUpdate($path);
    }

    /**
     * 公共地图
     * @return string
     */
    public function commonMap(): string
    {
        $path = "/sitemap/index/common.xml";
        $siteUrl = system_config('site_url');

        $data = [
            [
                'url' => $siteUrl,
                'date' => date("Y-m-d"),
                'priority' => 1
            ]
        ];

        $this->makeXml($data, $path);

        return $siteUrl . $path;
    }


    /**
     * 文章分类地图
     * @return string
     */
    public function categoryMap(): string
    {
        $path = "/sitemap/index/category.xml";
        $siteUrl = system_config('site_url');

        $categories = ArticleCategory::select(['id', 'updated_at'])->get()->toArray();;
        foreach ($categories as &$category) {

            $category['date'] = date("Y-m-d", strtotime($category['updated_at']));
            $category['url'] = category_path($category['id']);
        }

        $this->makeXml($categories, $path);

        return $siteUrl . $path;
    }


    /**
     * 文章地图
     * @return array
     */
    public function articleMap(): array
    {
        $urls = [];
        $siteUrl = system_config('site_url');

        $count = intval(Article::count() / self::NUMBER) + 1;

        for ($i = 0; $i < $count; $i++) {

            $path = "/sitemap/index/article_" . ($i + 1) . ".xml";

            if ($this->isUpdate($path)) {

                $articles = Article::select(['id', 'updated_at'])
                    ->offset($i * self::NUMBER)
                    ->limit(self::NUMBER)->get()->toArray();

                foreach ($articles as &$article) {

                    $article['date'] = date("Y-m-d", strtotime($article['updated_at']));
                    $article['url'] = single_path($article['id']);
                }

                $urls[] = $siteUrl . $path;

                $this->makeXml($articles, $path);
            }

        }

        return $urls;
    }


    /**
     * 文章标签地图
     * @return array
     */
    public function tagMap(): array
    {

        $urls = [];
        $siteUrl = system_config('site_url');

        $count = intval(ArticleTag::count() / 10000) + 1;

        for ($i = 0; $i < $count; $i++) {

            $path = "/sitemap/index/tag_" . ($i + 1) . ".xml";

            $tags = ArticleTag::select(['id', 'updated_at'])
                ->offset($i * self::NUMBER)
                ->limit(self::NUMBER)
                ->get()->toArray();

            foreach ($tags as &$tag) {

                $tag['date'] = date("Y-m-d", strtotime($tag['updated_at']));
                $tag['url'] = tag_path($tag['id']);
            }

            $urls[] = $siteUrl . $path;

            $this->makeXml($tags, $path);
        }

        return $urls;
    }


    /**
     * 商品地图
     * @return string
     */
    public function goodsMap(): string
    {
        $path = "/sitemap/index/goods.xml";
        $siteUrl = system_config('site_url');

        $goodsMap = [];
        $goodsCategories = GoodsCategory::select(['id', 'updated_at'])->get()->toArray();

        if ($goodsCategories) {

            $goodsMap[] = [
                'date' => date("Y-m-d"),
                'url' => store_path(),
            ];
        }

        foreach ($goodsCategories as $category) {

            $goodsMap[] = [
                'date' => date("Y-m-d", strtotime($category['updated_at'])),
                'url' => store_category_path($category['id']),
            ];

        }

        $goods = Goods::select(['id', 'updated_at'])->get()->toArray();
        foreach ($goods as $item) {

            $goodsMap[] = [
                'date' => date("Y-m-d", strtotime($item['updated_at'])),
                'url' => goods_path($item['id']),
            ];

        }

        if ($goodsMap) {

            $this->makeXml($goodsMap, $path);
            return $siteUrl . $path;
        } else {
            return '';
        }

    }


    /**
     * 拓展地图
     * @return array
     */
    public function extendMap(): array
    {
        return pipeline_func([], "site_map");
    }
}
