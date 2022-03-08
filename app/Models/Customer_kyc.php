<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Customer_kyc extends Model
{
    use HasFactory;
    protected $fillable = [
        'business_name',
        'phone',
        'date_of_incorporation',
        'address',
        'email',
        'nationality',
        'rc_number',
        'business_type',
        'CAC',
        'utility',
        'bank_statement',
        'is_active'
    ];

    public function getDateOfIncorporationAttribute($value)
    {
        return Carbon::parse($value)->format("d F Y");
    }

//    public function setDateOfIncorporationAttribute($value)
//    {
//        return $this->attributes['date_of_incorporation'] = Carbon::parse($value)->format("d F Y");
//    }
    public function customers()
    {
        return $this->hasMany(Customer::class);
    }

//    protected function createdAt()
//    {
//        return Attribute::make(
//            get: fn ($value) => $value->diffForHumans(),
//        );
//    }

    protected $casts = [
        'created_at' => 'datetime:Y-m-d',
    ];

}
