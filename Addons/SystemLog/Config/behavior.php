<?php

$prefix = system_config("admin_prefix") ?: "admin";

return [
    "md:admin_auth:200" => [
        "\Addons\SystemLog\Events\SystemLogEvent"
    ],
    "url:{$prefix}/login:POST:200" => [
        "\Addons\SystemLog\Events\SystemLogEvent"
    ],
];
