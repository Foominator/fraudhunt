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
}
