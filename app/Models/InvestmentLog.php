<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Traits\Loggable;

class InvestmentLog extends Model
{
    use HasFactory, Loggable;

    protected $fillable = [
        'investment_id',
        'payment_id',
        'type',
        'amount',
        'log_date',
        'description',
        'created_by',
    ];

    protected $casts = [
        'log_date' => 'date',
        'amount' => 'decimal:2',
    ];

    public function investment()
    {
        return $this->belongsTo(Investment::class);
    }

    public function payment()
    {
        return $this->belongsTo(Payment::class);
    }
}
