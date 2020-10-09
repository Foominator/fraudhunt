<?php

namespace App\Http\Controllers;

use App\Http\Requests\CreateFraudRequest;
use App\Repositories\CardRepository;
use App\Repositories\CommentRepository;
use App\Repositories\PhoneRepository;

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
        $phone = app()->make(PhoneRepository::class)->create([
            'number' => $request->phone,
            'name' => $request->name,
            'author_id' => auth()->user()->id,
        ]);

        $comment = app()->make(CommentRepository::class)->create([
            'description' => $request->comment,
            'status ' => 'approved',
            'author_id' => auth()->user()->id,
            'phone_id' => $phone->id,
        ]);

        $cardRepository = app()->make(CardRepository::class);
        foreach ($request->cards as $card) {
            $cardRepository->create([
                'card_num' => $card,
                'comment_id' => $comment->id,
            ]);
        }

        return response()->json(['Created successfully'], 200);
    }
}
