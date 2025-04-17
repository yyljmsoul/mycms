<?php


namespace Addons\Oss\Expand;


use Addons\Oss\Expand\Core\OssException;
use League\Flysystem\Adapter\AbstractAdapter;
use League\Flysystem\AdapterInterface;
use League\Flysystem\Config;

class OssAdapter extends AbstractAdapter
{

    protected $id;

    protected $secret;

    protected $bucket;

    protected $endpoint;

    protected $client;

    public function __construct($id, $secret, $bucket, $endpoint)
    {

        $this->id = $id;
        $this->secret = $secret;
        $this->bucket = $bucket;
        $this->endpoint = $endpoint;

        $this->initClient();
    }

    protected function initClient()
    {
        $this->client = new OssClient($this->id, $this->secret, $this->endpoint);
    }

    public function getClient()
    {
        return $this->client;
    }

    public function write($path, $contents, Config $config): bool
    {
        $path = $this->applyPathPrefix($path);

        $this->client->putObject($this->bucket, $path, $contents);

        return true;
    }

    public function writeStream($path, $resource, Config $config)
    {
        $contents = stream_get_contents($resource);

        return $this->write($path, $contents, $config);
    }

    public function update($path, $contents, Config $config)
    {
        return $this->write($path, $contents, $config);
    }

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

        try {
            $this->client->copyObject($this->bucket, $path, $this->bucket, $newpath);
        } catch (OssException $exception) {
            return false;
        }

        return true;
    }

    public function delete($path)
    {
        $path = $this->applyPathPrefix($path);

        try {
            $this->client->deleteObject($this->bucket, $path);
        } catch (OssException $ossException) {
            return false;
        }

        return true;
    }

    public function deleteDir($dirname)
    {
        $fileList = $this->listContents($dirname, true);
        foreach ($fileList as $file) {
            $this->delete($file['path']);
        }

        return true;
    }

    public function createDir($dirname, Config $config)
    {
        $defaultFile = trim($dirname, '/') . '/oss.txt';

        return $this->write($defaultFile, 'oss~', $config);
    }

    public function setVisibility($path, $visibility)
    {
        $object = $this->applyPathPrefix($path);

        $acl = (AdapterInterface::VISIBILITY_PUBLIC === $visibility) ? OssClient::OSS_ACL_TYPE_PUBLIC_READ : OssClient::OSS_ACL_TYPE_PRIVATE;

        try {
            $this->client->putObjectAcl($this->bucket, $object, $acl);
        } catch (OssException $exception) {
            return false;
        }

        return compact('visibility');
    }

    public function has($path)
    {
        $path = $this->applyPathPrefix($path);

        return $this->client->doesObjectExist($this->bucket, $path);
    }

    public function read($path)
    {
        try {
            $contents = $this->getObject($path);
        } catch (OssException $exception) {
            return false;
        }

        return compact('contents', 'path');
    }

    public function readStream($path)
    {
        try {
            $stream = fopen('php://temp', 'w+b');
            fwrite($stream, $this->getObject($path));
            rewind($stream);
        } catch (OssException $exception) {
            return false;
        }

        return compact('stream', 'path');
    }

    public function listContents($directory = '', $recursive = false)
    {
        $list = [];
        $directory = '/' == substr($directory, -1) ? $directory : $directory . '/';
        $result = $this->listDirObjects($directory, $recursive);

        if (!empty($result['objects'])) {
            foreach ($result['objects'] as $files) {
                if ('oss.txt' == substr($files['Key'], -7) || !$fileInfo = $this->normalizeFileInfo($files)) {
                    continue;
                }
                $list[] = $fileInfo;
            }
        }

        // prefix
        if (!empty($result['prefix'])) {
            foreach ($result['prefix'] as $dir) {
                $list[] = [
                    'type' => 'dir',
                    'path' => $dir,
                ];
            }
        }

        return $list;
    }

    public function getMetadata($path)
    {
        $path = $this->applyPathPrefix($path);

        try {
            $metadata = $this->client->getObjectMeta($this->bucket, $path);
        } catch (OssException $exception) {
            return false;
        }

        return $metadata;
    }

    public function getSize($path)
    {
        return $this->normalizeFileInfo(['Key' => $path]);
    }

    public function getMimetype($path)
    {
        return $this->normalizeFileInfo(['Key' => $path]);
    }

    public function getTimestamp($path)
    {
        return $this->normalizeFileInfo(['Key' => $path]);
    }

    public function getVisibility($path)
    {
        // TODO: Implement getVisibility() method.
    }

    /**
     * Read an object from the OssClient.
     *
     * @param $path
     *
     * @return string
     */
    protected function getObject($path)
    {
        $path = $this->applyPathPrefix($path);

        return $this->client->getObject($this->bucket, $path);
    }

    /**
     * normalize file info.
     *
     * @return array
     */
    protected function normalizeFileInfo(array $stats)
    {
        $filePath = ltrim($stats['Key'], '/');

        $meta = $this->getMetadata($filePath) ?? [];

        if (empty($meta)) {
            return [];
        }

        return [
            'type' => 'file',
            'mimetype' => $meta['content-type'],
            'path' => $filePath,
            'timestamp' => $meta['info']['filetime'],
            'size' => $meta['content-length'],
        ];
    }
}
