<?php

namespace App\Http\Controllers;

use App\Http\Requests\CreateFraudRequest;

class FraudController extends Controller
{
    /**
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View
     */
    public function create()
    {
        return view('main.fraud.create');
    }

    public function store(CreateFraudRequest $request)
    {
        return response()->json($request->all());
    }
}
