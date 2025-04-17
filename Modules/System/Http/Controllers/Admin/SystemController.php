<?php

namespace Modules\System\Http\Controllers\Admin;

use App\Http\Controllers\MyController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Modules\Cms\Models\Article;
use Modules\Order\Models\Order;
use Modules\Shop\Models\Goods;
use Modules\System\Models\Config;
use Modules\System\Service\AddonService;
use Modules\System\Service\MenuService;
use Modules\User\Models\User;

class SystemController extends MyController
{

    /**
     * 系统后台首页
     */
    public function index(Request $request, MenuService $menuService, Config $config)
    {
        $data = [
            'article_count' => Article::count(),
            'user_count' => User::count(),
            'goods_count' => Goods::count(),
            'order_total' => Order::where('pay_status', 1)->sum('order_amount'),
            'order_count' => Order::where('pay_status', 1)->count(),
            'user_today' => User::where('created_at', ">", date("Y-m-d 00:00:00"))->count(),
            'order_today_total' => Order::where('pay_status', 1)->where('created_at', ">", date("Y-m-d 00:00:00"))->sum('order_amount'),
            'order_today_count' => Order::where('pay_status', 1)->where('created_at', ">", date("Y-m-d 00:00:00"))->count(),
        ];

        $goodsTop = Goods::orderBy('sales', 'desc')->limit(10)->get();
        $orders = Order::orderBy('id', 'desc')->limit(10)->get();

        return $this->view('admin.index', compact('data', 'orders', 'goodsTop'));
    }

    /**
     * 后台欢迎页
     */
    public function dashboard()
    {

        $data = [
            'diy_js_path' => system_resource_url('/mycms/admin/js/system.index.js'),
            'diy_action' => 'dashboard',
            'article_count' => Article::count(),
            'user_count' => User::count(),
            'goods_count' => Goods::count(),
            'view_count' => Article::sum('view'),
            'users' => User::orderBy('id', 'desc')->limit(10)->get()
        ];

        return $this->view('admin.dashboard', $data);
    }

    /**
     * 后台上传图片接口
     */
    public function images(Request $request)
    {
        $path = '';
        $date = date('Ym/d');
        $disk = system_config('site_upload_disk');

        if ($request->file('file')) {
            $path = $request->file('file')
                ->store('public/uploads/files/' . $date, $disk);
        }

        if ($request->file('video')) {
            $path = $request->file('video')
                ->store('public/uploads/videos/' . $date, $disk);
        }

        if ($request->file('image')) {
            $path = $request->file('image')
                ->store('public/uploads/images/' . $date, $disk);
        }

        if ($request->file('editormd-image-file')) {
            $path = $request->file('editormd-image-file')
                ->store('public/uploads/images/' . $date, $disk);
        }

        if ($request->file('upload')) {
            $path = $request->file('upload')
                ->store('public/uploads/other/' . $date, $disk);
        }

        $response = empty($path)
            ? ['success' => 0, 'uploaded' => 0, 'message' => '上传失败', 'msg' => '上传失败']
            : [
                'code' => '200',
                'msg' => '上传成功',
                'message' => '上传成功',
                'state' => 'SUCCESS',
                'success' => 1,
                'uploaded' => 1,
                'data' => system_image_url($path),
                'url' => system_image_url($path),
                'path' => $path
            ];

        return json_encode($response, JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE);
    }


    /**
     * 保存远程图片
     * @return false|string
     */
    public function catcher(Request $request)
    {
        $list = [];
        $date = date('Ym/d');
        $disk = system_config('site_upload_disk');
        $images = $request->input('catcher');

        foreach ($images as $image) {

            $path = 'public/uploads/images/' . $date . '/' . Str::random(40) . ".png";

            Storage::disk($disk)
                ->put($path, file_get_contents($image));

            $list[] = [
                'url' => system_image_url($path),
                'source' => $image,
                'state' => 'SUCCESS',
            ];
        }

        $response = [
            'code' => '200',
            'msg' => '上传成功',
            'state' => 'SUCCESS',
            'list' => $list
        ];

        return json_encode($response, JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE);
    }

    /**
     * 更新缓存
     */
    public function updateCache(AddonService $service)
    {

        $service->makeCache();

        update_system_config_cache();

        return $this->result(true);
    }

}
