<?php

namespace App\Models;

use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

/**
 * Class User
 * @package App\Models
 * @version October 8, 2020, 12:18 pm UTC
 *
 * @property \Illuminate\Database\Eloquent\Collection $userRoles
 * @property string $name
 * @property string $email
 * @property string|\Carbon\Carbon $email_verified_at
 * @property string $password
 * @property string $remember_token
 */
class User extends Authenticatable
{
    use SoftDeletes, HasFactory, Notifiable;

    public $table = 'users';

    const CREATED_AT = 'created_at';
    const UPDATED_AT = 'updated_at';

    protected $dates = ['deleted_at'];

    public $fillable = [
        'name',
        'email',
        'locale',
        'email_verified_at',
        'password',
        'remember_token'
    ];

    /**
     * The attributes that should be casted to native types.
     *
     * @var array
     */
    protected $casts = [
        'id' => 'integer',
        'name' => 'string',
        'email' => 'string',
        'email_verified_at' => 'datetime',
        'remember_token' => 'string'
    ];

    /**
     * Validation rules
     *
     * @var array
     */
    public static $rules = [
        'name' => 'required|string|max:255',
        'locale' => 'string|in:ua,ru',
        'email' => 'unique|required|string|max:255',
        'email_verified_at' => 'nullable',
        'password' => 'required|string|max:255',
        'remember_token' => 'nullable|string|max:100',
        'created_at' => 'nullable',
        'updated_at' => 'nullable'
    ];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function roles()
    {
        return $this->belongsToMany(Role::class, 'user_role')->withTimestamps();
    }

    /**
     * @return bool
     */
    public function isAdmin(): bool
    {
        return $this->roles()->where('roles.slug', '=', Role::ADMIN_ROLE_SLUG)->exists();
    }

    /**
     * @param string $roleSlug
     * @return bool
     */
    public function attachRole(string $roleSlug)
    {
        $role = Role::where('slug', $roleSlug)->first();
        if (!$role) {
            return false;
        }
        $this->roles()->attach($role);
        return true;
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function comments()
    {
        return $this->hasMany(
            Comment::class,
            'author_id', // Foreign key on comments table...
            'id', // Foreign key on cards table...
        );
    }
}
