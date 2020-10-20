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
        $savedLocale = app()->getLocale();
        if ($request->cookie('locale')) {
            $savedLocale = $request->cookie('locale');
        }
        if (auth()->check()) {
            $savedLocale = auth()->user()->locale;
        }

        $urlLocale = $request->segment(1);
        if (!in_array($urlLocale, ['ua', 'ru'])) {
            $urlLocale = 'ua'; //default
        }

        if ('/' === $request->getPathInfo() && 'ua' !== $savedLocale) {
            return redirect("/$savedLocale");
        }

        if (!in_array($urlLocale, ['ua', 'ru'])) {
            abort(404);
        }

        app()->setLocale($urlLocale);
        return $next($request);
    }
}
