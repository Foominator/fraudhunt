<?php

namespace App\Models;

use Eloquent as Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * Class Comment
 * @package App\Models
 * @version October 9, 2020, 6:48 am UTC
 *
 * @property \App\Models\User $author
 * @property \App\Models\Phone $phone
 * @property string $description
 * @property string $status
 * @property integer $author_id
 * @property integer $phone_id
 */
class Comment extends Model
{
    use SoftDeletes, HasFactory;

    public $table = 'comments';

    protected $dates = ['deleted_at'];

    public $fillable = [
        'description',
        'status',
        'author_id',
        'phone_id'
    ];

    /**
     * The attributes that should be casted to native types.
     *
     * @var array
     */
    protected $casts = [
        'id' => 'integer',
        'description' => 'string',
        'status' => 'string',
        'author_id' => 'integer',
        'phone_id' => 'integer'
    ];

    /**
     * Validation rules
     *
     * @var array
     */
    public static $rules = [
        'description' => 'required|string',
        'status' => 'required|in:approved,declined',
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

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     **/
    public function phone()
    {
        return $this->belongsTo(\App\Models\Phone::class, 'phone_id', 'id');
    }

    public function cards()
    {
        return $this->hasMany(\App\Models\Card::class, 'comment_id', 'id');
    }
}
