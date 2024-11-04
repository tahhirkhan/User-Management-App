<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PhoneNumber extends Model
{
    use HasFactory;

    protected $table = 'phone_numbers';
    protected $fillable = ['phone_number'];

    public function user() {
        return $this->hasOne(User::class, 'phone_number_id');
    }
}
