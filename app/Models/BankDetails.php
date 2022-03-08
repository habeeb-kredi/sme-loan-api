<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
class BankDetails extends Model
{
    use HasFactory, SoftDeletes;
    protected $fillable = [
        'bank_name',
        'account_number',
        'organization_name',
        'repayment_code',
        "customer_kyc_id"
         

    ];
}
