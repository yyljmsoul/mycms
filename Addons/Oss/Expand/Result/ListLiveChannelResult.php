<?php

namespace Addons\Oss\Expand\Result;

use Addons\Oss\Expand\Model\LiveChannelListInfo;

class ListLiveChannelResult extends Result
{
    protected function parseDataFromResponse()
    {
        $content = $this->rawResponse->body;
        $channelList = new LiveChannelListInfo();
        $channelList->parseFromXml($content);
        return $channelList;
    }
}
