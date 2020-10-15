<?php

namespace App\Models;

use Eloquent as Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * Class Phone
 * @package App\Models
 * @version October 8, 2020, 1:27 pm UTC
 *
 * @property \App\Models\User $author
 * @property string $number
 * @property integer $author_id
 */
class Phone extends Model
{
    use SoftDeletes, HasFactory;

    public $table = 'phones';

    protected $dates = ['deleted_at'];

    public $fillable = [
        'number',
        'author_id',
    ];

    /**
     * The attributes that should be casted to native types.
     *
     * @var array
     */
    protected $casts = [
        'id' => 'integer',
        'number' => 'string',
        'author_id' => 'integer'
    ];

    /**
     * Validation rules
     *
     * @var array
     */
    public static $rules = [
        'number' => 'required|string|max:20',
        'created_at' => 'nullable|nullable',
        'updated_at' => 'nullable|nullable'
    ];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     **/
    public function author()
    {
        return $this->belongsTo(\App\Models\User::class, 'author_id', 'id');
    }

    public function comments()
    {
        return $this->hasMany(\App\Models\Comment::class, 'phone_id', 'id');
    }

    public function cards()
    {
        return $this->hasManyThrough(
            Card::class,
            Comment::class,
            'phone_id', // Foreign key on comments table...
            'comment_id', // Foreign key on cards table...
            'id', // Local key on phones table...
            'id' // Local key on comments table...
        );
    }

    public function getFraudPercent(): float
    {
        $comments = $this->comments()->get(['author_id', 'status_int'])
            ->groupBy('author_id'); // 1 user - 1 vote
        if (!$comments->count()) {
            return 0;
        }

        $fraudApprovedCount = 0;
        foreach ($comments as $userId => $userComments) {
            if (0 < $userComments->sum('status_int')) {
                $fraudApprovedCount++;
            }
        }
        return round($fraudApprovedCount / $comments->count() * 1000) / 10;
    }

    public function getNewStatusInt(string $newStatus, int $userId): int
    {
        //User`s last comment (with status)
        $lastComment = $this->comments()->where('author_id', $userId)
            ->where('status_int', '!=', 0)
            ->latest()
            ->first();

        if (!$lastComment) {
            return Comment::APPROVED_STATUS === $newStatus ? 1 : -1;
        }

        $lastStatus = $lastComment->status_int > 0 ? Comment::APPROVED_STATUS : Comment::DECLINED_STATUS;
        if ($newStatus !== $lastStatus) {
            return Comment::APPROVED_STATUS === $newStatus ? 2 : -2;
        }
        return 0;
    }
}
