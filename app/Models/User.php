<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable implements MustVerifyEmail
{

    use HasApiTokens, HasFactory, Notifiable;


    /**
     * The attributes that are mass assignable.
     *
     * @var string[]
     */

    protected $primaryKey = 'user_id';
    protected $fillable = [
        'qr_code',
        'username',
        'lname',
        'fname',
        'mname', 'suffix', 'sex',
        'email',
        'contact_no',
        'role',
        'password',
        'active',
        'department_id',
        'email_verified_at'
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];


    public function department(){
        return $this->hasOne(Department::class, 'department_id', 'department_id');
    }

    public function ao(){
        return $this->hasOne(User::class, 'user_id', 'ao_user_id');
    }




}
