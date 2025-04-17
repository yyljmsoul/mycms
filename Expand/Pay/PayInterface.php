<?php

namespace Expand\Pay;

use Illuminate\Http\JsonResponse;

interface PayInterface
{
    public function submit(array $order, $payType = ''): JsonResponse;

    public function notify(array $order = []);

    public function refund(array $order);

    public function getPayType();
}
