<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;

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
        return view('main.advices');
    }

    /**
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View
     */
    public function rules()
    {
        return view('main.rules');
    }

    public function setLocale(string $newLocale)
    {
        if (!in_array($newLocale, ['ua', 'ru'])) {
            abort(404);
        }

        if ($user = auth()->user()) {
            $user->locale = $newLocale;
            $user->save();
        }

        $urlLocale = request()->segment(1);
        if (!in_array($urlLocale, ['ru'])) {
            $urlLocale = 'ua'; //default
        }
        $urlFrom = explode(config('app.url'), url()->previous())[1];

        if ($urlLocale === $newLocale) {
            return redirect()->back()->cookie(cookie('locale', $newLocale, time() + (10 * 365 * 24 * 60 * 60)));
        }

        $segments = explode('/', $urlFrom);
        unset($segments[0]);

        if ('ua' == $newLocale) { //default locale is not in path
            unset($segments[1]);
            $newPath = collect($segments)->implode('/');
        } else {
            if (in_array($segments[0] ?? null, ['ru'])) { // logic for more locales, if need
                $segments[1] = $newLocale;
                $newPath = collect($segments)->implode('/');
            } else {
                $newPath = collect($segments)->implode('/');
                $newPath = "$newLocale/$newPath";
            }
        }
        return redirect()->to("/$newPath")->cookie(cookie('locale', $newLocale, time() + (10 * 365 * 24 * 60 * 60)));
    }
}
