<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Http\Requests\Frontend\CreateCommentRequest;
use App\Http\Requests\Frontend\CreateFraudRequest;
use App\Models\Card;
use App\Models\Comment;
use App\Models\Phone;

class FraudController extends Controller
{
    /**
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View
     */
    public function index()
    {
        $fraudsCount = Phone::count();
        return view('main.fraud.index', compact('fraudsCount'));
    }

    /**
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View
     */
    public function create()
    {
        return view('main.fraud.create');
    }

    /**
     * @param CreateFraudRequest $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function store(CreateFraudRequest $request)
    {
        foreach ($request->phones as $phoneNumber) {
            $phone = Phone::create([
                'number' => $phoneNumber,
                'author_id' => auth()->user()->id,
            ]);

            $comment = Comment::create([
                'description' => $request->comment,
                'status' => Comment::APPROVED_STATUS,
                'status_int' => 1,
                'author_id' => auth()->user()->id,
                'phone_id' => $phone->id,
            ]);

            foreach ($request->cards as $card) {
                Card::create([
                    'card_num' => $card,
                    'comment_id' => $comment->id,
                ]);
            }
        }

        return response()->json(['Мошенник успешно добавлен'], 200);
    }

    /**
     * @return \Illuminate\Http\JsonResponse
     */
    public function search()
    {
        request()->validate(['phone' => 'required|string|min:10|max:10']);

        $phone = Phone::with('comments')->where('number', '=', request()->phone)->first();
        if (!$phone) {
            return response()->json(['Not Found'], 404);
        }

        //Phone creator`s comment
        $firstComment = $phone->comments->sortBy('created_at')->first()->load(['phone', 'cards', 'author']);

        //Last phone comments
        $comments = $phone->comments()->with(['phone', 'cards', 'author'])
            ->where('id', '!=', $firstComment->id)->latest()->paginate(10);

        //Auth user`s last comment
        $lastComment = !auth()->check() ? null : $phone->comments()
            ->where('status', '!=', Comment::NEUTRAL_STATUS)
            ->where('author_id', auth()->user()->id)->latest()->first();

        return response()->json([
            'first_comment' => $firstComment,
            'comments' => $comments,
            'fraud_percent' => $phone->getFraudPercent(),
            'last_comment_status' => $lastComment->status ?? null,
        ], 200);
    }

    public function comment(CreateCommentRequest $request)
    {
        $phone = Phone::find($request->phone_id);
        if (!$phone) {
            return response()->json(['Not Found'], 404);
        }

        $statusInt = $phone->getNewStatusInt($request->status, auth()->user()->id);
        $comment = Comment::create([
            'description' => $request->comment,
            'status' => 0 === $statusInt ? Comment::NEUTRAL_STATUS : $request->status,
            'status_int' => $statusInt,
            'author_id' => auth()->user()->id,
            'phone_id' => $phone->id,
        ]);

        foreach ($request->cards as $card) {
            Card::create([
                'card_num' => $card,
                'comment_id' => $comment->id,
            ]);
        }

        return response()->json([
            'Комментарий успешно добавлен'
        ], 200);
    }
}
