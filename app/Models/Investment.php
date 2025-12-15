<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Traits\Loggable;

class Investment extends Model
{
    use HasFactory, Loggable;

    protected $fillable = [
        'investor_id',
        'product_id',
        'investor_bank_details_id',
        'investment_amount',
        'interest_rate',
        'period_type',
        'period',
        'start_date',
        'maturity_date',
        'capital_withdrawal_notice_period',
        'penalty_rate',
        'status',
        'notes',
        'created_by',
        'last_updated_by',
    ];

    protected $casts = [
        'start_date' => 'date',
        'maturity_date' => 'date',
        'investment_amount' => 'decimal:2',
        'interest_rate' => 'decimal:4',
        'penalty_rate' => 'decimal:4',
    ];

    public function investor()
    {
        return $this->belongsTo(Investor::class);
    }

    public function product()
    {
        return $this->belongsTo(Product::class);
    }

    public function bankDetail()
    {
        return $this->belongsTo(InvestorHasBankDetails::class, 'investor_bank_details_id');
    }

    public function payments()
    {
        return $this->hasMany(Payment::class);
    }

    public function logs()
    {
        return $this->hasMany(InvestmentLog::class);
    }

    public function interestSchedules()
    {
        return $this->hasMany(InterestSchedule::class);
    }
}
