<?php

$prefix = system_config("admin_prefix") ?: "admin";

return [

    "url:{$prefix}/login:POST:200" => [
        "\Modules\System\Events\AdminLoginEvent",
    ],

    "url:{$prefix}/diy-page/create:POST:200" => [
        "\Modules\System\Events\DiyPageRouteCacheEvent",
    ],

    "url:{$prefix}/diy-page/edit:POST:200" => [
        "\Modules\System\Events\DiyPageRouteCacheEvent",
    ],

    "url:{$prefix}/diy-page/destroy:POST:200" => [
        "\Modules\System\Events\DiyPageRouteCacheEvent",
    ],
];
