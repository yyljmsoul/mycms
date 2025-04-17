<?php

namespace Addons\Oss\Expand\Result;


use Addons\Oss\Expand\Model\BucketStat;

/**
 * Class GetRefererResult
 * @package OSS\Result
 */
class GetBucketStatResult extends Result
{
    /**
     * Parse bucket stat data
     *
     * @return BucketStat
     */
    protected function parseDataFromResponse()
    {
        $content = $this->rawResponse->body;
        $stat = new BucketStat();
        $stat->parseFromXml($content);
        return $stat;
    }
}
