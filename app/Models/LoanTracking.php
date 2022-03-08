<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class LoanTracking extends Model
{
    use HasFactory;

    protected $fillable = [
        'customer_kyc_id',
        'loanId',
        'resourceId',
        'status'
    ];
}
