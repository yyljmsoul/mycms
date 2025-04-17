<?php

namespace Addons\Oss\Expand\Result;


use Addons\Oss\Expand\Model\WormConfig;

/**
 * Class GetBucketWormResult
 * @package OSS\Result
 */
class GetBucketWormResult extends Result
{
    /**
     * Parse bucket stat data
     *
     * @return WormConfig
     */
    protected function parseDataFromResponse()
    {
        $content = $this->rawResponse->body;
        $config = new WormConfig();
        $config->parseFromXml($content);
        return $config;
    }
}
