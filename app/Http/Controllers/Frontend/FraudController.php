<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Http\Requests\Frontend\CreateCommentRequest;
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

        return response()->json(['Fraud created successfully'], 200);
    }

    /**
     * @return \Illuminate\Http\JsonResponse
     */
    public function search()
    {
        request()->validate(['phone' => 'required|string|min:10|max:10']);
        $phone = request()->phone;
        $phone = Phone::where('number', '=', $phone)->first();
        if (!$phone) {
            return response()->json(['Not Found'], 404);
        }

        //Fraud creator
        $firstComment = Comment::with('phone', 'cards', 'author')->where('phone_id', $phone->id)
            ->orderBy('created_at', 'asc')->first();

        $comments = Comment::with('phone', 'cards', 'author')->where('phone_id', $phone->id)
            ->orderBy('created_at', 'desc')->where('id', '!=', $firstComment->id)->paginate(10);

        // Fraud Percent logic
        $frauds = Comment::where('phone_id', $phone->id)
            ->get(['author_id', 'status_int'])->groupBy('author_id');
        $fraudApprovedCount = 0;
        foreach ($frauds as $userId => $commentStats) {
            $statusInt = 0;
            foreach ($commentStats as $commentStat) {
                $statusInt += $commentStat->status_int;
            }
            if (0 < $statusInt) {
                $fraudApprovedCount++;
            }
        }
        $fraudPercent = round($fraudApprovedCount / $frauds->count() * 1000) / 10;

        //Auth user last comment
        $lastComment = auth()->check() && Comment::whereHas('phone', function (Builder $query) use ($phone) {
                $query->where('number', '=', $phone);
            })->where('author_id', auth()->user()->id)
                ->orderBy('created_at', 'desc')
                ->first();
        return response()->json([
            'first_comment' => $firstComment,
            'comments' => $comments,
            'fraud_percent' => $fraudPercent,
            'last_comment_status' => $lastComment->status ?? null,
        ], 200);
    }

    public function comment(CreateCommentRequest $request)
    {
        $phone = Phone::find($request->phone_id);
        if (!$phone) {
            response()->json(['Not Found'], 404);
        }

        //Auth user last comment (with status)
        $lastComment = Comment::where('phone_id', $phone->id)
            ->where('author_id', auth()->user()->id)
            ->where('status_int', '!=', 0)
            ->orderBy('created_at', 'desc')
            ->first();
        $statusInt = 0;
        if (!$lastComment) {
            $statusInt = $request->status === Comment::APPROVED_STATUS ? 1 : -1;
        }
        $lastStatus = $lastComment->status_int > 0 ? Comment::APPROVED_STATUS : Comment::DECLINED_STATUS;
        if ($lastComment && $request->status !== $lastStatus) {
            $statusInt = $request->status === Comment::APPROVED_STATUS ? 2 : -2;
        }

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
            'Comment created successfully'
        ], 200);
    }
}
