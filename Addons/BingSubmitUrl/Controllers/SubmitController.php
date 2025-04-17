<?php


namespace Addons\BingSubmitUrl\Controllers;


use Addons\BingSubmitUrl\Models\BingSubmitLog;
use Addons\BingSubmitUrl\Requests\ConfigRequest;
use App\Http\Controllers\MyController;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Modules\Cms\Models\Article;

class SubmitController extends MyController
{
    private $lowerName = 'bing_submit_url';

    public function index(Request $request)
    {
        if ($request->ajax() && $request->wantsJson()) {
            $logs = BingSubmitLog::orderBy('id', 'desc')
                ->paginate($this->param('limit', 'intval'))->toArray();

            return $this->success($logs);
        }

        return $this->view('admin.index');
    }

    public function config()
    {
        $systemConfig = system_config([], $this->lowerName);
        return $this->view('admin.config', compact('systemConfig'));
    }

    /**
     * 保存系统配置
     */
    public function store(ConfigRequest $request)
    {
        $data = $request->validated();

        $result = system_config_store($data, $this->lowerName);

        return $this->result($result);
    }

    /**
     * 手动推送资源页面
     */
    public function create()
    {
        return $this->view('admin.create');
    }

    /**
     * 手动推送资源
     */
    public function push(): JsonResponse
    {
        if ($urls = $this->param('urls')) {

            bing_submit_url($urls);

            return $this->result(true, ['msg' => '推送成功']);
        }

        if ($date = $this->param('date')) {

            if ($urls = $this->getDateUrls($date)) {

                bing_submit_url(implode("\n", $urls));

                return $this->result(true, ['msg' => "成功推送" . count($urls) . "条资源"]);
            }

            return $this->result(false, ['msg' => '该日无新增资源']);
        }

        return $this->result(false, ['msg' => '请输入网址']);
    }

    /**
     * 获取指定日期文章 URL
     * @param $date
     * @return array
     */
    public function getDateUrls($date): array
    {

        $urls = [];
        $pushTotal = system_config('by_push_total', $this->lowerName) ?? 100;

        $articles = Article::whereBetween('created_at', [$date . ' 00:00:00', $date . ' 23:59:59'])->select(['id'])->limit($pushTotal)->get();

        foreach ($articles as $article) {

            $urls[] = single_path($article->id);
        }

        return $urls;
    }

    /**
     * 推送昨日新增资源
     */
    public function crontab(): JsonResponse
    {

        $type = system_config('by_push_type', $this->lowerName);

        if ($type == 2) {

            $date = date('Y-m-d', time() - 24 * 3600);

            if ($urls = $this->getDateUrls($date)) {

                bing_submit_url(implode("\n", $urls));

                return $this->result(true, ['msg' => "成功推送" . count($urls) . "条资源"]);
            }

            return $this->result(false, ['msg' => '昨日无新增资源']);
        }

        return $this->result(false, ['msg' => 'is closed']);
    }
}
