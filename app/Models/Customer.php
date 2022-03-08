<?php

namespace App\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class Customer extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    protected $fillable = [
        'first_name',
        'last_name',
        'email',
        'phone',
        'password',
        'otp_code',
        'role_id',
        'referrer_code',
        'is_active',
        'customer_kyc_id'
    ];

    public function customerKycs()
    {
        return $this->belongsTo(Customer_kyc::class, 'customer_kyc_id');
    }

}
