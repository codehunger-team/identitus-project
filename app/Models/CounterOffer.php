<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CounterOffer extends Model
{
    use HasFactory;

    protected $fillable = ['lessor_id','lessee_id','contract_id','domain_name','first_payment','period_payment','number_of_periods','option_purchase_price'];
}
