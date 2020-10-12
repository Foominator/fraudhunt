<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Http\Requests\CreateFraudRequest;
use App\Models\Comment;
use App\Models\Phone;
use App\Repositories\CardRepository;
use App\Repositories\CommentRepository;
use App\Repositories\PhoneRepository;
use Illuminate\Database\Eloquent\Builder;

class FraudController extends Controller
{
    /**
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View
     */
    public function create()
    {
        return view('main.fraud.create');
    }

    /**
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View
     */
    public function index()
    {
        $fraudsCount = Phone::count();
        return view('main.fraud.index', compact('fraudsCount'));
    }

    public function store(CreateFraudRequest $request)
    {
        $phone = app()->make(PhoneRepository::class)->create([
            'number' => $request->phone,
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

        return response()->json(['Fraud created successfully'], 200);
    }

    public function search()
    {
        request()->validate(['phone' => 'required|string|min:10|max:10']);
        $phone = request()->phone;
        $firstComment = Comment::with('phone', 'cards')->whereHas('phone', function (Builder $query) use ($phone) {
            $query->where('number', '=', $phone);
        })->orderBy('created_at', 'asc')->first();

        if (!$firstComment) {
            return response()->json([
                'first_comment' => [],
                'comments' => [],
            ], 200);
        }

        $comments = Comment::with('phone', 'cards')->whereHas('phone', function (Builder $query) use ($phone) {
            $query->where('number', '=', $phone);
        })->orderBy('created_at', 'desc')->where('id', '!=', $firstComment->id)->paginate(10);

        return response()->json([
            'first_comment' => $firstComment,
            'comments' => $comments,
        ], 200);
    }
}
