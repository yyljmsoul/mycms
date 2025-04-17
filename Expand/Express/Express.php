<?php

namespace Expand\Express;

class Express
{
    protected $object;

    public function __construct()
    {
        $default = config('express.default');

        $this->object = app("Expand\Express\\{$default}\Express");
    }

    /**
     * 查询物流动态
     * @param $type
     * @param $code
     * @return array
     */
    public function query($type, $code): array
    {
        return $this->object->query($type, $code);
    }
}
