<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Services\RouteBuilder;

class MainController extends Controller
{
    /**
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View
     */
    public function main()
    {
        return view('main.main');
    }

    /**
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View
     */
    public function advices()
    {
        $locale = app()->getLocale();
        return view("main.static_content.$locale.advices");
    }

    /**
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View
     */
    public function rules()
    {
        $locale = app()->getLocale();
        return view("main.static_content.$locale.rules");
    }

    public function setLocale(string $newLocale)
    {
        $locales = config('app.additional_locales');
        $locales[] = config('app.default_locale');
        if (!in_array($newLocale, $locales)) {
            abort(404);
        }
        app()->setLocale($newLocale);

        if ($user = auth()->user()) {
            $user->locale = $newLocale;
            $user->save();
        }

        $url = url()->previous();
        $query = explode('?', $url);
        $prevRouteName = app('router')->getRoutes($url)->match(app('request')->create($url))->getName();
        $newRouteName = (new RouteBuilder)->removeLocalePrefix($prevRouteName);
        $newPath = (new RouteBuilder)->route($newRouteName);
        if (isset($query[1])) {
            $newPath = "$newPath?$query[1]";
        }
        return redirect()->to($newPath)->cookie(cookie('locale', $newLocale, time() + (10 * 365 * 24 * 60 * 60)));
    }
}
