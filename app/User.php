<?php

namespace App;

use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Sentinel;
use Reminder;

class User extends Authenticatable
{
    use Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'email', 'password',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    public static function verifyCodeResetPassword($id,$code)
    {
        $user = Sentinel::findById($id);
        $check = Reminder::exists($user);
        if($check){
            $data = [
                'code' => 200,
                ];
            return $data;
        }
    }
}
