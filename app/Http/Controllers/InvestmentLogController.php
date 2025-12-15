<?php

namespace App\Http\Controllers;

use App\Models\InvestmentLog;

class InvestmentLogController extends Controller
{
    /**
     * Display investment logs.
     */
    public function index()
    {
        $logs = InvestmentLog::with(['investment.investor', 'payment'])
            ->latest('log_date')
            ->latest('id')
            ->paginate(20);

        return view('investments.logs', compact('logs'));
    }
}
