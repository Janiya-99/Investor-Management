<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Traits\Loggable;

class Investor extends Model
{
    use HasFactory, Loggable;

    protected $fillable = [
        'title',
        'first_name',
        'last_name',
        'full_name',
        'email',
        'nic',
        'contact_no',
        'address_line_1',
        'address_line_2',
        'address_line_3',
        'beneficiary_full_name',
        'beneficiary_nic',
        'beneficiary_contact_no',
        'beneficiary_relation',
        'registration_date',
        'last_updated_date_time',
        'last_updated_by',
        'created_by',
        'tax_status',
        'tax_no',
        'otp',
        'status',
        'user_id',
    ];


    public function documents()
    {
        return $this->hasMany(InvestorHasDocument::class);
    }

    public function bankDetails()
    {
        return $this->hasMany(InvestorHasBankDetails::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
