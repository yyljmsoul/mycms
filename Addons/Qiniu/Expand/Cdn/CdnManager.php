<?php

namespace Addons\Qiniu\Expand\Cdn;

use Addons\Qiniu\Expand\Auth;
use Addons\Qiniu\Expand\Http\Client;
use Addons\Qiniu\Expand\Http\Error;

final class CdnManager
{

    private $auth;
    private $server;

    public function __construct(Auth $auth)
    {
        $this->auth = $auth;
        $this->server = 'http://fusion.qiniuapi.com';
    }

    /**
     * @param array $urls 待刷新的文件链接数组
     * @return array
     */
    public function refreshUrls(array $urls)
    {
        return $this->refreshUrlsAndDirs($urls, array());
    }

    /**
     * @param array $dirs 待刷新的文件链接数组
     * @return array
     * 目前客户默认没有目录刷新权限，刷新会有400038报错，参考：https://developer.qiniu.com/fusion/api/1229/cache-refresh
     * 需要刷新目录请工单联系技术支持 https://support.qiniu.com/tickets/category
     */
    public function refreshDirs(array $dirs)
    {
        return $this->refreshUrlsAndDirs(array(), $dirs);
    }

    /**
     * @param array $urls 待刷新的文件链接数组
     * @param array $dirs 待刷新的目录链接数组
     *
     * @return array 刷新的请求回复和错误，参考 examples/cdn_manager.php 代码
     * @link http://developer.qiniu.com/article/fusion/api/refresh.html
     *
     * 目前客户默认没有目录刷新权限，刷新会有400038报错，参考：https://developer.qiniu.com/fusion/api/1229/cache-refresh
     * 需要刷新目录请工单联系技术支持 https://support.qiniu.com/tickets/category
     */
    public function refreshUrlsAndDirs(array $urls, array $dirs)
    {
        $req = array();
        if (!empty($urls)) {
            $req['urls'] = $urls;
        }
        if (!empty($dirs)) {
            $req['dirs'] = $dirs;
        }

        $url = $this->server . '/v2/tune/refresh';
        $body = json_encode($req);
        return $this->post($url, $body);
    }

    /**
     * 查询 CDN 刷新记录
     *
     * @param string $requestId 指定要查询记录所在的刷新请求id
     * @param string $isDir 指定是否查询目录，取值为 yes/no，默认不填则为两种类型记录都查询
     * @param array $urls 要查询的url列表，每个url可以是文件url，也可以是目录url
     * @param string $state 指定要查询记录的状态，取值processing／success／failure
     * @param int $pageNo 要求返回的页号，默认为0
     * @param int $pageSize 要求返回的页长度，默认为100
     * @param string $startTime 指定查询的开始日期，格式2006-01-01
     * @param string $endTime 指定查询的结束日期，格式2006-01-01
     * @return array
     * @link https://developer.qiniu.com/fusion/api/1229/cache-refresh#4
     */
    public function getCdnRefreshList(
        $requestId = null,
        $isDir = null,
        $urls = array(),
        $state = null,
        $pageNo = 0,
        $pageSize = 100,
        $startTime = null,
        $endTime = null
    )
    {
        $req = array();
        setWithoutEmpty($req, 'requestId', $requestId);
        setWithoutEmpty($req, 'isDir', $isDir);
        setWithoutEmpty($req, 'urls', $urls);
        setWithoutEmpty($req, 'state', $state);
        setWithoutEmpty($req, 'pageNo', $pageNo);
        setWithoutEmpty($req, 'pageSize', $pageSize);
        setWithoutEmpty($req, 'startTime', $startTime);
        setWithoutEmpty($req, 'endTime', $endTime);

        $body = json_encode($req);
        $url = $this->server . '/v2/tune/refresh/list';
        return $this->post($url, $body);
    }

    /**
     * @param array $urls 待预取的文件链接数组
     *
     * @return array 预取的请求回复和错误，参考 examples/cdn_manager.php 代码
     *
     * @link http://developer.qiniu.com/article/fusion/api/refresh.html
     */
    public function prefetchUrls(array $urls)
    {
        $req = array(
            'urls' => $urls,
        );

        $url = $this->server . '/v2/tune/prefetch';
        $body = json_encode($req);
        return $this->post($url, $body);
    }

    /**
     * 查询 CDN 预取记录
     *
     * @param string $requestId 指定要查询记录所在的刷新请求id
     * @param array $urls 要查询的url列表，每个url可以是文件url，也可以是目录url
     * @param string $state 指定要查询记录的状态，取值processing／success／failure
     * @param int $pageNo 要求返回的页号，默认为0
     * @param int $pageSize 要求返回的页长度，默认为100
     * @param string $startTime 指定查询的开始日期，格式2006-01-01
     * @param string $endTime 指定查询的结束日期，格式2006-01-01
     * @return array
     * @link https://developer.qiniu.com/fusion/api/1227/file-prefetching#4
     */
    public function getCdnPrefetchList(
        $requestId = null,
        $urls = array(),
        $state = null,
        $pageNo = 0,
        $pageSize = 100,
        $startTime = null,
        $endTime = null
    )
    {
        $req = array();
        setWithoutEmpty($req, 'requestId', $requestId);
        setWithoutEmpty($req, 'urls', $urls);
        setWithoutEmpty($req, 'state', $state);
        setWithoutEmpty($req, 'pageNo', $pageNo);
        setWithoutEmpty($req, 'pageSize', $pageSize);
        setWithoutEmpty($req, 'startTime', $startTime);
        setWithoutEmpty($req, 'endTime', $endTime);

        $body = json_encode($req);
        $url = $this->server . '/v2/tune/prefetch/list';
        return $this->post($url, $body);
    }

    /**
     * @param array $domains 待获取带宽数据的域名数组
     * @param string $startDate 开始的日期，格式类似 2017-01-01
     * @param string $endDate 结束的日期，格式类似 2017-01-01
     * @param string $granularity 获取数据的时间间隔，可以是 5min, hour 或者 day
     *
     * @return array 带宽数据和错误信息，参考 examples/cdn_manager.php 代码
     *
     * @link http://developer.qiniu.com/article/fusion/api/traffic-bandwidth.html
     */
    public function getBandwidthData(array $domains, $startDate, $endDate, $granularity)
    {
        $req = array();
        $req['domains'] = implode(';', $domains);
        $req['startDate'] = $startDate;
        $req['endDate'] = $endDate;
        $req['granularity'] = $granularity;

        $url = $this->server . '/v2/tune/bandwidth';
        $body = json_encode($req);
        return $this->post($url, $body);
    }

    /**
     * @param array $domains 待获取流量数据的域名数组
     * @param string $startDate 开始的日期，格式类似 2017-01-01
     * @param string $endDate 结束的日期，格式类似 2017-01-01
     * @param string $granularity 获取数据的时间间隔，可以是 5min, hour 或者 day
     *
     * @return array 流量数据和错误信息，参考 examples/cdn_manager.php 代码
     *
     * @link http://developer.qiniu.com/article/fusion/api/traffic-bandwidth.html
     */
    public function getFluxData(array $domains, $startDate, $endDate, $granularity)
    {
        $req = array();
        $req['domains'] = implode(';', $domains);
        $req['startDate'] = $startDate;
        $req['endDate'] = $endDate;
        $req['granularity'] = $granularity;

        $url = $this->server . '/v2/tune/flux';
        $body = json_encode($req);
        return $this->post($url, $body);
    }

    /**
     * @param array $domains 待获取日志下载链接的域名数组
     * @param string $logDate 获取指定日期的日志下载链接，格式类似 2017-01-01
     *
     * @return array 日志下载链接数据和错误信息，参考 examples/cdn_manager.php 代码
     *
     * @link http://developer.qiniu.com/article/fusion/api/log.html
     */
    public function getCdnLogList(array $domains, $logDate)
    {
        $req = array();
        $req['domains'] = implode(';', $domains);
        $req['day'] = $logDate;

        $url = $this->server . '/v2/tune/log/list';
        $body = json_encode($req);
        return $this->post($url, $body);
    }

    private function post($url, $body)
    {
        $headers = $this->auth->authorization($url, $body, 'application/json');
        $headers['Content-Type'] = 'application/json';
        $ret = Client::post($url, $body, $headers);
        if (!$ret->ok()) {
            return array(null, new Error($url, $ret));
        }
        $r = ($ret->body === null) ? array() : $ret->json();
        return array($r, null);
    }

    /**
     * 构建时间戳防盗链鉴权的访问外链
     *
     * @param string $rawUrl 需要签名的资源url
     * @param string $encryptKey 时间戳防盗链密钥
     * @param string $durationInSeconds 链接的有效期（以秒为单位）
     *
     * @return string 带鉴权信息的资源外链，参考 examples/cdn_timestamp_antileech.php 代码
     */
    public static function createTimestampAntiLeechUrl($rawUrl, $encryptKey, $durationInSeconds)
    {
        $parsedUrl = parse_url($rawUrl);
        $deadline = time() + $durationInSeconds;
        $expireHex = dechex($deadline);
        $path = isset($parsedUrl['path']) ? $parsedUrl['path'] : '';
        $strToSign = $encryptKey . $path . $expireHex;
        $signStr = md5($strToSign);
        if (isset($parsedUrl['query'])) {
            $signedUrl = $rawUrl . '&sign=' . $signStr . '&t=' . $expireHex;
        } else {
            $signedUrl = $rawUrl . '?sign=' . $signStr . '&t=' . $expireHex;
        }
        return $signedUrl;
    }
}
