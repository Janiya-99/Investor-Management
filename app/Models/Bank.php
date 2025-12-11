<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Traits\Loggable;

class Bank extends Model
{
    use HasFactory, Loggable;

    protected $fillable = ['bank_code', 'bank_name'];

    protected $table = 'banks';

    public function bank_branches()
    {
        return $this->hasMany(BankBranch::class, 'bank_id');
    }
}
