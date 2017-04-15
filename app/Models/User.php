<?php

namespace CodeFlix\Models;

use CodeFlix\Notifications\DefaultResetPasswordNotification;
use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;

/**
 * CodeFlix\Models\User
 *
 * @property int $id
 * @property string $name
 * @property string $email
 * @property string $password
 * @property string $remember_token
 * @property \Carbon\Carbon $created_at
 * @property \Carbon\Carbon $updated_at
 * @property int $role
 * @property-read \Illuminate\Notifications\DatabaseNotificationCollection|\Illuminate\Notifications\DatabaseNotification[] $notifications
 * @method static \Illuminate\Database\Query\Builder|\CodeFlix\Models\User whereCreatedAt($value)
 * @method static \Illuminate\Database\Query\Builder|\CodeFlix\Models\User whereEmail($value)
 * @method static \Illuminate\Database\Query\Builder|\CodeFlix\Models\User whereId($value)
 * @method static \Illuminate\Database\Query\Builder|\CodeFlix\Models\User whereName($value)
 * @method static \Illuminate\Database\Query\Builder|\CodeFlix\Models\User wherePassword($value)
 * @method static \Illuminate\Database\Query\Builder|\CodeFlix\Models\User whereRememberToken($value)
 * @method static \Illuminate\Database\Query\Builder|\CodeFlix\Models\User whereRole($value)
 * @method static \Illuminate\Database\Query\Builder|\CodeFlix\Models\User whereUpdatedAt($value)
 * @mixin \Eloquent
 */
class User extends Authenticatable
{
    use Notifiable;

    const ROLE_ADMIN=1;
    const ROLE_CLIENT=2;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'email', 'password', 'role'
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    public function sendPasswordResetNotification($token)
    {
        $this->notify(new DefaultResetPasswordNotification($token));
    }
}
