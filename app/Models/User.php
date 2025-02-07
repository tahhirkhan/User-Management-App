<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    protected $table = 'users';

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'full_name',
        'username',
        'email_id',
        'phone_number_id',
        'address_id',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    // Relationship to Email:
    public function email() {
        return $this->belongsTo(Email::class, 'email_id')->withDefault();
    }

    // Relationship to PhoneNumber:
    public function phoneNumber() {
        return $this->belongsTo(PhoneNumber::class, 'phone_number_id')->withDefault();
    }

    // Relationship to Address:
    public function address() {
        return $this->belongsTo(Address::class, 'address_id');
    }
}
