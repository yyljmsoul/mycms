<?php


namespace Addons\BingSubmitUrl\Listeners;


use Addons\BingSubmitUrl\Events\BingSubmitUrlEvent;

class BingSubmitUrlListener
{
    /**
     * Handle the event.
     *
     * @param BingSubmitUrlEvent $event
     */
    public function handle(BingSubmitUrlEvent $event)
    {

        $type = system_config('by_push_type', 'bing_submit_url');

        if (empty($type) || $type == 1) {

            $url = $event->getUrl();
            $url && bing_submit_url($url);
        }

    }
}
