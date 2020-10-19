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

        app()->setLocale($locale);
//        dump($locale);
        return $next($request);
    }
}
