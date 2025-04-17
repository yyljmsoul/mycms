<?php

namespace Addons\Qiniu\Expand;

use Addons\Qiniu\Expand\Config as Conf;
use Addons\Qiniu\Expand\Storage\BucketManager;
use Addons\Qiniu\Expand\Storage\UploadManager;
use Illuminate\Support\Facades\Storage;
use League\Flysystem\Adapter\AbstractAdapter;
use League\Flysystem\Config;

class QiNiuAdapter extends AbstractAdapter
{

    protected $access;

    protected $secret;

    protected $client;

    protected $token;

    protected $auth;

    protected $bucket;

    protected $manager;

    public function __construct($access, $secret, $bucket)
    {

        $this->access = $access;
        $this->secret = $secret;
        $this->bucket = $bucket;

        $auth = new Auth($access, $secret);
        $this->token = $auth->uploadToken($bucket);

        $this->client = new UploadManager();

        $config = new Conf();
        $this->manager = new BucketManager($auth, $config);
    }

    /**
     * @throws \Exception
     */
    public function write($path, $contents, Config $config): bool
    {
        $path = $this->applyPathPrefix($path);

        Storage::disk('root')->put($path, $contents);

        $this->client->putFile($this->token, $path, base_path($path));

        Storage::disk('root')->delete($path);

        return true;
    }

    /**
     * @throws \Exception
     */
    public function writeStream($path, $resource, Config $config)
    {
        $contents = stream_get_contents($resource);

        return $this->write($path, $contents, $config);
    }

    /**
     * @throws \Exception
     */
    public function update($path, $contents, Config $config)
    {
        return $this->write($path, $contents, $config);
    }

    /**
     * @throws \Exception
     */
    public function updateStream($path, $resource, Config $config)
    {
        return $this->writeStream($path, $resource, $config);
    }

    public function rename($path, $newpath)
    {
        if (!$this->copy($path, $newpath)) {

            return false;
        }

        return $this->delete($path);
    }

    public function copy($path, $newpath)
    {
        $path = $this->applyPathPrefix($path);
        $newpath = $this->applyPathPrefix($newpath);

        $this->manager->copy($this->bucket, $path, $this->bucket, $newpath, true);

        return true;
    }

    public function delete($path): bool
    {
        $path = $this->applyPathPrefix($path);

        $this->manager->delete($this->bucket, $path);

        return true;
    }

    public function deleteDir($dirname)
    {
        // TODO: Implement deleteDir() method.
    }

    public function createDir($dirname, Config $config)
    {
        // TODO: Implement createDir() method.
    }

    public function setVisibility($path, $visibility)
    {
        // TODO: Implement setVisibility() method.
    }

    public function has($path)
    {
        // TODO: Implement has() method.
    }

    public function read($path)
    {
        // TODO: Implement read() method.
    }

    public function readStream($path)
    {
        // TODO: Implement readStream() method.
    }

    public function listContents($directory = '', $recursive = false)
    {
        // TODO: Implement listContents() method.
    }

    public function getMetadata($path)
    {
        // TODO: Implement getMetadata() method.
    }

    public function getSize($path)
    {
        // TODO: Implement getSize() method.
    }

    public function getMimetype($path)
    {
        // TODO: Implement getMimetype() method.
    }

    public function getTimestamp($path)
    {
        // TODO: Implement getTimestamp() method.
    }

    public function getVisibility($path)
    {
        // TODO: Implement getVisibility() method.
    }
}
