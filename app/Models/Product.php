<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Traits\Loggable;

class Product extends Model
{
    use HasFactory, Loggable;

    protected $fillable = [
        'name',
        'period_type',
        'period',
        'min_interest_rate',
        'max_interest_rate',
        'min_amount',
        'max_amount',
        'interest_calculation_type',
        'capital_withdrawal_notice_period',
        'penalty_type',
        'penalty_min_rate',
        'penalty_max_rate',
        'status',
        'created_by',
        'last_updated_by',
    ];
}
