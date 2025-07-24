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

    protected $primaryKey = 'user_id';
    protected $table = 'users';

    // public $incrementing = true;        // set to false if it's NOT auto-increment
    // protected $keyType = 'int';         // or 'string' if it's varchar

    protected $fillable = [
        'email',
        'mobile',
    ];

    protected $hidden = [
        'remember_token',
    ];

    protected $casts = [
        'email_verified_at' => 'datetime',
    ];


    // FOR BUSINESS LETER I ADD
    public function businesses()
    {
        return $this->hasMany(Business::class, 'user_id');
    }

    public function uploadedPhotos()
    {
        return $this->hasMany(BusinessPhoto::class, 'uploaded_by');
    }
}
