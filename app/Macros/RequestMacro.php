<?php

namespace App\Macros;

use Illuminate\Routing\Route;
use Illuminate\Routing\Router;
use Illuminate\Support\Arr;
use InvalidArgumentException;

class RequestMacro
{
    /**
     * 修改属性
     */
    public function propertyAware(): callable
    {
        return function ($property, $value){

            /** @var \Illuminate\Http\Request $this */
            if (! property_exists($this, $property)) {
                throw new InvalidArgumentException('The property not exists.');
            }

            $this->{$property} = $value;

            return $this;
        };
    }

    /**
     * 匹配路由
     */
    public function matchRoute(): callable
    {
        return function ($includingMethod = true){
            // 1. 获取路由集合
            /* @var \Illuminate\Routing\RouteCollection $routeCollection */
            $routeCollection = app(Router::class)->getRoutes();
            /** @var \Illuminate\Http\Request $this */
            $routes = is_null($this->method())
                ? $routeCollection->getRoutes()
                : Arr::get($routeCollection->getRoutesByMethod(), $this->method(), []);
            [$fallbacks, $routes] = collect($routes)->partition(function ($route){
                return $route->isFallback;
            });

            return $routes->merge($fallbacks)->first(function (Route $route) use ($includingMethod){
                // 2. 遍历匹配
                return $route->matches($this, $includingMethod);
            });
        };
    }
}
