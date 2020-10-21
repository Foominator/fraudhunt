<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

class SetLocale
{
    /**
     * Handle an incoming request.
     *
     * @param \Illuminate\Http\Request $request
     * @param \Closure $next
     * @return mixed
     */
    public function handle(Request $request, Closure $next)
    {
        $savedLocale = app()->getLocale();
        if ($request->cookie('locale')) {
            $savedLocale = $request->cookie('locale');
        }
        if (auth()->check()) {
            $savedLocale = auth()->user()->locale;
        }

        $defaultLocale = config('app.default_locale');
        $locales = config('app.additional_locales');
        $locales[] = $defaultLocale;

        $name = Route::currentRouteName();
        $routeLocale = explode('.', $name)[0];
        if (!in_array($routeLocale, $locales)) {
            $routeLocale = $defaultLocale;
        }

        if ('/' === $request->getPathInfo() && $defaultLocale !== $savedLocale) {
            return redirect("/$savedLocale");
        }

        app()->setLocale($routeLocale);
        return $next($request);
    }
}
