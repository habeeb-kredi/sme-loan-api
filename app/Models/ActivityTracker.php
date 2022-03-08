<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ActivityTracker extends Model
{
    use HasFactory;
    protected $fillable = ["title",
    "description",
    "on_page",
    "customer_kyc_id"];
}
