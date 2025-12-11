<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Traits\Loggable;
use App\Models\Investor;
use App\Models\Bank;
use App\Models\BankBranch;

class InvestorHasBankDetails extends Model
{
    use HasFactory, Loggable;

    protected $fillable = [
        'investor_id',
        'bank_branch_id',
        'bank_id',
        'account_number',
        'account_name',
    ];

    public function investor()
    {
        return $this->belongsTo(Investor::class);
    }

    public function bank()
    {
        return $this->belongsTo(Bank::class);
    }

    public function branch()
    {
        return $this->belongsTo(BankBranch::class, 'bank_branch_id');
    }
}
