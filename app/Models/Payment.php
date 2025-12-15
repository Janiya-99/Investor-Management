<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Traits\Loggable;

class Payment extends Model
{
    use HasFactory, Loggable;

    protected $fillable = [
        'investment_id',
        'investor_bank_details_id',
        'user_id',
        'payment_date',
        'amount',
        'type',
        'status',
        'note',
        'created_by',
        'last_updated_by',
    ];

    protected $casts = [
        'payment_date' => 'date',
        'amount' => 'decimal:2',
    ];

    public function investment()
    {
        return $this->belongsTo(Investment::class);
    }

    public function bankDetail()
    {
        return $this->belongsTo(InvestorHasBankDetails::class, 'investor_bank_details_id');
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function logs()
    {
        return $this->hasMany(InvestmentLog::class);
    }
}
