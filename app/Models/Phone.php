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
        'name',
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
        'name' => 'string',
        'author_id' => 'integer'
    ];

    /**
     * Validation rules
     *
     * @var array
     */
    public static $rules = [
        'number' => 'required|string|max:20',
        'name' => 'required|string|max:20',
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
}
