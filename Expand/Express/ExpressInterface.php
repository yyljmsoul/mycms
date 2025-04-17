<?php

namespace Expand\Express;

interface ExpressInterface
{

    public function query($code, $type): array;

}
