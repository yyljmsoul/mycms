<?php

namespace Expand\Api;

interface ApiHandleInterface
{

    public function getName(): string;

    public function handle($params);
}
