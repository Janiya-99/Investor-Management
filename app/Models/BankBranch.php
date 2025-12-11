<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Traits\Loggable;

class BankBranch extends Model
{
    use HasFactory, Loggable;

    protected $fillable = ['bank_id', 'bank_branch_code', 'bank_branch_name'];
    protected $table = 'bank_branches';

    public function bank()
    {
        return $this->belongsTo(Bank::class, 'bank_id');
    }
}
