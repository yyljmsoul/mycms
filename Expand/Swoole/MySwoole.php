<?php


namespace Expand\Swoole;

use Illuminate\Contracts\Container\BindingResolutionException;
use Illuminate\Contracts\Http\Kernel;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Facade;
use Swoole\Process;

class MySwoole
{

    use Console, \Expand\Swoole\Process;

    public $http;

    /**
     * @var \Illuminate\Contracts\Container\Container
     */
    public $app;

    public static $instance;

    /**
     * @var array|mixed
     */
    public $config = [];

    public function __construct()
    {
        $this->config = require "config.php";

        $this->initHttp();
    }

    public static function getInstance(): MySwoole
    {
        if (!(self::$instance instanceof self)) {
            self::$instance = new self();
        }

        return self::$instance;
    }

    /**
     * 初始化服务器
     */
    public function initHttp()
    {
        if (!$this->isRunning()) {

            $this->http = new \swoole_http_server($this->config['host'], $this->config['port']);

            $this->http->set([
                'worker_num' => $this->config['worker_num'],
                'max_request' => $this->config['max_request'],
                'daemonize' => true,
            ]);

            $this->http->on('WorkerStart', [$this, 'onWorkerStart']);
            $this->http->on('request', [$this, 'onRequest']);
            $this->http->on('start', [$this, 'onStart']);
        }
    }


    /**
     * 运行统一入口
     * @param $argv
     */
    public function run($argv)
    {
        if (isset($argv[1]) && method_exists($this, $argv[1])) {
            $this->{$argv[1]}();
        }
    }

    /**
     * 启动服务
     */
    public function start()
    {
        !$this->http && $this->initHttp();

        if (!$this->isRunning()) {

            $this->info('MyCms start success!');
            $this->http->start();
        }

        $this->isRunning() && $this->info('MyCms is running!');
    }

    /**
     * 重载服务
     */
    public function reload()
    {
        if ($this->isRunning()) {
            $this->http->reload();
        }
    }

    /**
     * 停止服务
     */
    public function stop()
    {
        $masterPid = $this->read()[0];
        Process::kill($masterPid, SIGTERM);

        $start = time();

        do {

            if (!$this->isRunning()) {
                break;
            }

            usleep(100000);

        } while (time() < $start + 15);

        unlink($this->config['pid_file']);

        $this->info('MyCms stop success!');

    }

    /**
     * 重启服务
     */
    public function restart()
    {

        $this->isRunning() && $this->stop();

        $this->start();
    }

    /**
     * 判断服务是否在运行
     */
    public function isRunning(): bool
    {
        if (!is_file($this->config['pid_file'])) {
            return false;
        }

        list($masterPid, $managerPid) = $this->read();

        if ($managerPid) {

            return $masterPid && Process::kill((int)$managerPid, 0);
        }

        return $masterPid && Process::kill((int)$masterPid, 0);
    }

    public function onStart($server)
    {
        $this->info('MyCms start success!');
        $this->write($server->master_pid . ',' . $server->manager_pid);
    }

    public function onWorkerStart($server, $workId)
    {
        if (extension_loaded('apc')) {
            apc_clear_cache();
        }

        if (extension_loaded('Zend OPcache')) {
            opcache_reset();
        }

        require ROOT_PATH . '/vendor/autoload.php';

        $this->app = require ROOT_PATH . '/bootstrap/app.php';
    }

    /**
     * @throws BindingResolutionException
     */
    public function onRequest($req, $res)
    {

        $request = Request::create(
            $req->server['request_uri'],
            $req->server['request_method'],
            array_merge($req->get ?? [], $req->post ?? []),
            $req->cookie ?? [],
            $req->files ?? [],
            $this->transformServerParameters($req->server ?? [], $req->header ?? []),
            $req->rawContent()
        );

        $kernel = $this->app->make(Kernel::class);

        $response = $kernel->handle($request);

        $res->status($response->getStatusCode());

        foreach ($response->headers->allPreserveCaseWithoutCookies() as $name => $values) {
            foreach ($values as $value) {
                $res->header($name, $value, false);
            }
        }

        foreach ($response->headers->getCookies() as $cookie) {
            $res->header('Set-Cookie', $cookie->getName() . strstr($cookie, '='), false);
        }

        $res->end($response->getContent());

        $this->resetProviders();

    }

    /**
     * 每次都需要重新加载的服务
     */
    protected function resetProviders()
    {
        foreach ($this->config['resets'] as $provider) {

            if (class_exists($provider)) {

                $provider = new $provider($this->app);
                $provider->reset();
            }
        }
    }

    /**
     * 请求 server 转换
     */
    protected function transformServerParameters(array $server, array $header): array
    {
        $__SERVER = [];

        foreach ($server as $key => $value) {
            $key = strtoupper($key);
            $__SERVER[$key] = $value;
        }

        foreach ($header as $key => $value) {
            $key = str_replace('-', '_', $key);
            $key = strtoupper($key);

            if (!in_array($key, ['REMOTE_ADDR', 'SERVER_PORT', 'HTTPS'])) {
                $key = 'HTTP_' . $key;
            }

            $__SERVER[$key] = $value;
        }

        return $__SERVER;
    }

}
