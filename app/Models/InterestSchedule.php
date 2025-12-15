<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Traits\Loggable;

class InterestSchedule extends Model
{
    use HasFactory, Loggable;

    protected $fillable = [
        'investment_id',
        'due_date',
        'interest_amount',
        'capital_amount',
        'total_amount',
        'paid_at',
        'paid_amount',
        'status',
        'note',
        'created_by',
        'last_updated_by',
    ];

    protected $casts = [
        'due_date' => 'date',
        'paid_at' => 'date',
        'interest_amount' => 'decimal:2',
        'capital_amount' => 'decimal:2',
        'total_amount' => 'decimal:2',
        'paid_amount' => 'decimal:2',
    ];

    public function investment()
    {
        return $this->belongsTo(Investment::class);
    }
}

