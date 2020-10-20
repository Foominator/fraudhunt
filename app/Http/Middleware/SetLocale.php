<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

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
        $locale = app()->getLocale();
        if ($request->cookie('locale')) {
            $locale = $request->cookie('locale');
        }
        if (auth()->check()) {
            $locale = auth()->user()->locale;
        }

        if (!in_array($locale, ['ua', 'ru'])) {
            abort(404);
        }
        $urlLocale = $request->segment(1);
        if (!in_array($urlLocale, ['ua', 'ru'])) {
            $urlLocale = 'ua'; //default
        }
        if ($urlLocale !== $locale) {
            $segments = request()->segments();
            if ('ua' == $locale) { //default locale is not in path
                unset($segments[0]);
                $newPath = collect($segments)->implode('/');

            } else {
                if (in_array($segments[0] ?? 'ua', ['ua', 'ru'])) {
                    $segments[0] = $locale;
                    $newPath = collect($segments)->implode('/');
                } else {
                    $newPath = collect($segments)->implode('/');
                    $newPath = "$locale/$newPath";
                }
            }
            $queryString = $request->getQueryString();
            return redirect()->to("/$newPath?$queryString");
        }

        app()->setLocale($locale);
        return $next($request);
    }
}
