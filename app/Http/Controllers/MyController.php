<?php


namespace App\Http\Controllers;

use App\Helpers\RequestHelpers;
use App\Helpers\ResponseHelpers;
use App\Helpers\ViewHelpers;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Routing\Controller as BaseController;

class MyController extends BaseController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests, ResponseHelpers, RequestHelpers, ViewHelpers;

    public function adminFilter($filter, $extend = [], $where = []): array
    {
        $filters = json_decode($filter, true) ?: [];

        foreach ($filters as $name => $filter) {
            if (isset($extend[$name]) && $closure = $extend[$name]) {
                $where[] = $closure($filter);
            } else {
                $where[] = [$name, '=', $filter];
            }
        }

        return $where;
    }

}
