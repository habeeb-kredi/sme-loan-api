<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
class BankCard extends Model
{
     
    use HasFactory, SoftDeletes;
    protected $fillable = [
        'name',
        'card_number',
        'date',
        'cvv',
        'is_default',
        'customer_kyc_id'
    ];
}
