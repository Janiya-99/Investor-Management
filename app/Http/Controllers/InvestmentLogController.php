<?php

namespace App\Http\Controllers;

use App\Models\InvestmentLog;
use Illuminate\Http\Request;
use Yajra\DataTables\DataTables;

class InvestmentLogController extends Controller
{
    /**
     * Display investment logs.
     */
    public function index(Request $request)
    {
        if ($request->ajax()) {
            $logs = InvestmentLog::with(['investment.investor'])
                ->select('*');

            return DataTables::of($logs)
                ->addIndexColumn()
                ->editColumn('investment_id', function ($row) {
                    return '#' . ($row->investment_id ?? 'N/A');
                })
                ->addColumn('investor_name', function ($row) {
                    return $row->investment->investor->full_name ?? 'N/A';
                })
                ->editColumn('type', function ($row) {
                    return '<span class="text-capitalize">' . $row->type . '</span>';
                })
                ->editColumn('amount', function ($row) {
                    return number_format($row->amount, 2);
                })
                ->editColumn('log_date', function ($row) {
                    return optional($row->log_date)->format('Y-m-d');
                })
                ->editColumn('description', function ($row) {
                    return $row->description ?? '-';
                })
                ->rawColumns(['type'])
                ->make(true);
        }

        return view('investments.logs');
    }
}
