<?php

namespace Addons\Oss\Expand\Result;

use Addons\Oss\Expand\Model\BucketInfo;
use Addons\Oss\Expand\Model\BucketListInfo;

/**
 * Class ListBucketsResult
 *
 * @package OSS\Result
 */
class ListBucketsResult extends Result
{
    /**
     * @return BucketListInfo
     */
    protected function parseDataFromResponse()
    {
        $bucketList = array();
        $content = $this->rawResponse->body;
        $xml = new \SimpleXMLElement($content);
        if (isset($xml->Buckets) && isset($xml->Buckets->Bucket)) {
            foreach ($xml->Buckets->Bucket as $bucket) {
                $bucketInfo = new BucketInfo();
                $bucketInfo->parseFromXmlNode($bucket);
                $bucketList[] = $bucketInfo;
            }
        }
        return new BucketListInfo($bucketList);
    }
}
