<?php

namespace App\Services;

use Illuminate\Support\Facades\Route;

class RouteBuilder
{
    public function route(string $routeName)
    {
        $resultName = app()->getLocale() . ".$routeName";
        if (Route::has($resultName)) {
            return route($resultName);
        }
        if (Route::has($routeName)) {
            return route($routeName);
        }
        throw new \Exception("Route '$routeName' not exists");
    }

    /**
     * @param string $routeName
     * @return string
     */
    public function removeLocalePrefix(string $routeName): string
    {
        $nameSegments = explode('.', $routeName);
        $locales = config('app.additionalLocales');
        $locales[] = config('app.defaultLocale');
        if (!in_array($nameSegments[0], $locales)) { // locale not found in route name
            return $routeName;
        }
        unset($nameSegments[0]);
        return collect($nameSegments)->implode('.');
    }
}
