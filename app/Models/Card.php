<?php

namespace App\Models;

use Eloquent as Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * Class Card
 * @package App\Models
 * @version October 9, 2020, 7:22 am UTC
 *
 * @property \App\Models\Comment $comment
 * @property string $card_num
 * @property integer $comment_id
 */
class Card extends Model
{
    use SoftDeletes, HasFactory;

    public $table = 'cards';


    protected $dates = ['deleted_at'];


    public $fillable = [
        'card_num',
        'comment_id'
    ];

    /**
     * The attributes that should be casted to native types.
     *
     * @var array
     */
    protected $casts = [
        'id' => 'integer',
        'card_num' => 'string',
        'comment_id' => 'integer'
    ];

    /**
     * Validation rules
     *
     * @var array
     */
    public static $rules = [
        'card_num' => 'required|string|max:20',
        'created_at' => 'nullable|nullable',
        'updated_at' => 'nullable|nullable'
    ];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     **/
    public function comment()
    {
        return $this->belongsTo(\App\Models\Comment::class, 'comment_id', 'id');
    }
}
