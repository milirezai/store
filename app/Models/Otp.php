<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Otp extends Model
{
    use HasFactory;
    protected $fillable = ['token','user_id','otp_code','login_id','type','used','status'];

    public function generateCode()
    {
        return rand(111111,999999);
    }
}
