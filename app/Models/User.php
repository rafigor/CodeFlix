<?php

namespace CodeFlix\Models;

use Bootstrapper\Interfaces\TableInterface;
use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Prettus\Repository\Contracts\Transformable;
use Prettus\Repository\Traits\TransformableTrait;
use CodeFlix\Notifications\DefaultResetPasswordNotification;
use Tymon\JWTAuth\Contracts\JWTSubject;

class User extends Authenticatable implements TableInterface, Transformable, JWTSubject
{
    const ROLE_ADMIN=1;
    const ROLE_CLIENT=2;

    use TransformableTrait;
    use Notifiable;

    protected $fillable = ['name', 'email', 'password', 'role'];

    protected $hidden = [
        'password', 'remember_token',
    ];

    public static function generatePassword($password = null){
        return !$password? bcrypt(str_random(8)):bcrypt($password);
    }

    public function sendPasswordResetNotification($token){
        $this->notify(new DefaultResetPasswordNotification($token));
    }

    public function transform()
    {
        // TODO: Implement transform() method.
    }

    /**
     * A list of headers to be used when a table is displayed
     *
     * @return array
     */
    public function getTableHeaders()
    {
        return ['#', 'Nome', 'e-mail'];
    }

    /**
     * Get the value for a given header. Note that this will be the value
     * passed to any callback functions that are being used.
     *
     * @param string $header
     * @return mixed
     */
    public function getValueForHeader($header)
    {
        switch($header){
            case '#': return $this->id;
            case 'Nome': return $this->name;
            case 'e-mail': return $this->email;
        }
    }

    /**
     * Get the identifier that will be stored in the subject claim of the JWT.
     *
     * @return mixed
     */
    public function getJWTIdentifier()
    {
        return $this->id;
    }

    /**
     * Return a key value array, containing any custom claims to be added to the JWT.
     *
     * @return array
     */
    public function getJWTCustomClaims()
    {
        return [
            'user' => [
                'id' => $this->id,
                'name' => $this->name,
                'email' => $this->email
            ]
        ];
    }
}
