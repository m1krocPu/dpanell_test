<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable
{
    use  HasFactory, Notifiable;

    protected $table = 'dp_users';
    const CREATED_AT = 'users_created';
    const UPDATED_AT = 'users_updated';
    protected $primaryKey = 'users_id';
    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'users_name',
        'users_email',
        'users_pwd',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'users_pwd',
    ];


    public function getAuthPassword()
    {
        return $this->users_pwd;
    }

}
