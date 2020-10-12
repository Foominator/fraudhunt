<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Http\Requests\Frontend\CreateFraudRequest;
use App\Models\Card;
use App\Models\Comment;
use App\Models\Phone;
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
                'status ' => 'approved',
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

        return response()->json(['Fraud created successfully'], 200);
    }

    /**
     * @return \Illuminate\Http\JsonResponse
     */
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

        $fraudApproved = Comment::with('phone', 'cards')->whereHas('phone', function (Builder $query) use ($phone) {
            $query->where('number', '=', $phone);
        })->where('status', 'approved')->count();
        $fraudPercent = round($fraudApproved / ($comments->total() + 1) * 1000) / 10;

        return response()->json([
            'first_comment' => $firstComment,
            'comments' => $comments,
            'fraud_percent' => $fraudPercent,
        ], 200);
    }

    public function comment()
    {

    }
}
