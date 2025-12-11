<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Traits\Loggable;
use App\Models\Investor;
use App\Models\User;

class InvestorHasDocument extends Model
{
    use HasFactory, Loggable;

    protected $fillable = [
        'investor_id',
        'description',
        'document_path',
        'uploaded_at',
        'uploaded_by',
        'file_path',
    ];

    public function investor()
    {
        return $this->belongsTo(Investor::class);
    }

    public function uploader()
    {
        return $this->belongsTo(User::class, 'uploaded_by');
    }
}
