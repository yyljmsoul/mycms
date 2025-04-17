<?php


namespace Addons\LinkSubmit\Listeners;


use Addons\LinkSubmit\Events\LinkSubmitEvent;

class LinkSubmitListener
{
    /**
     * Handle the event.
     *
     * @param LinkSubmitEvent $event
     */
    public function handle(LinkSubmitEvent $event)
    {
        $type = system_config('bd_push_type', 'link_submit');

        if (empty($type) || $type == 1) {

            $url = $event->getUrl();

            $url && link_submit($url);
        }


    }
}
