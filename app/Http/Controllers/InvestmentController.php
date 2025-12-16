<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreInvestmentRequest;
use App\Http\Requests\UpdateInvestmentRequest;
use App\Models\Investment;
use App\Models\InvestmentLog;
use App\Models\Investor;
use App\Models\InvestorHasBankDetails;
use App\Models\Product;
use Exception;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Http\Request;
use Yajra\DataTables\DataTables;
use Throwable;

class InvestmentController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        try {
            if ($request->ajax()) {
                $investments = Investment::with(['investor', 'product']);

                return DataTables::of($investments)
                    ->addIndexColumn()
                    ->addColumn('investor_name', function ($row) {
                        return $row->investor->full_name ?? 'N/A';
                    })
                    ->addColumn('product_name', function ($row) {
                        return $row->product->name ?? 'N/A';
                    })
                    ->editColumn('investment_amount', function ($row) {
                        return number_format($row->investment_amount, 2);
                    })
                    ->editColumn('interest_rate', function ($row) {
                        return number_format($row->interest_rate, 4) . '%';
                    })
                    ->editColumn('start_date', function ($row) {
                        return optional($row->start_date)->format('Y-m-d');
                    })
                    ->editColumn('status', function ($row) {
                       return '<span class="badge bg-light text-uppercase text-dark">' . $row->status . '</span>';
                    })
                    ->addColumn('action', function ($row) {
                        $editBtn = '<a href="' . route('investments.edit', $row->id) . '" class="btn btn-info btn-sm m-1"><i class="ti ti-pencil f-18"></i></a>';
                        $deleteBtn = '<button class="btn btn-danger btn-sm m-1" onclick="handleDelete(\'' . route('investments.destroy', $row->id) . '\', { _token: \'' . csrf_token() . '\' })"><i class="ti ti-trash f-18"></i></button>';
                        return $editBtn . $deleteBtn;
                    })
                    ->rawColumns(['status', 'action'])
                    ->make(true);
            }

            return view('investments.index');
        } catch (Throwable $th) {
            Log::error('Failed to load investments list', ['error' => $th->getMessage()]);
            return redirect()->back()->with('error', 'Unable to load investments right now. Please try again.');
        }
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        try {
            $investors = Investor::with('bankDetails')->orderBy('full_name')->get();
            $products = Product::orderBy('name')->get();
            $bankDetails = InvestorHasBankDetails::with(['investor', 'bank', 'branch'])->get();

            return view('investments.create', [
                'investors' => $investors,
                'products' => $products,
                'bankDetails' => $bankDetails,
            ]);
        } catch (Throwable $th) {
            Log::error('Failed to load investment create form', ['error' => $th->getMessage()]);

            return redirect()->back()->with('error', 'Unable to load investment form. Please try again.');
        }
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreInvestmentRequest $request)
    {
        DB::beginTransaction();

        try {
            $data = $request->validated();
            $data['created_by'] = Auth::id();
            $data['last_updated_by'] = Auth::id();

            $investment = Investment::create($data);

            // Logic to add the details to Interest Schedule
            InterestScheduleController::generateForInvestment($investment, $data);

            // Create Investment Log
            InvestmentLog::create([
                'investment_id' => $investment->id,
                'payment_id' => null,
                'type' => 'capital',
                'amount' => $data['investment_amount'],
                'log_date' => now(),
                'description' => 'Initial investment created',
                'created_by' => Auth::id(),
            ]);

            DB::commit();

            return response()->json([
                'message' => 'Investment created successfully.',
                'status' => 'success',
                'next_path' => route('investments.index'),
                'reload' => false,
                'reset' => true
            ], 201);

        } catch (Exception $th) {
            DB::rollBack();

            Log::error('Failed to create investment', [
                'error' => $th->getMessage(),
                'trace' => $th->getTraceAsString(),
                'user_id' => Auth::id(),
                'data' => $request->except(['password', 'token'])
            ]);

            return response()->json([
                'message' => 'Unable to create investment. Please try again.',
                'status' => 'error'
            ], 500);
        }
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Investment $investment)
    {
        try {
            $investors = Investor::with('bankDetails')->orderBy('full_name')->get();
            $products = Product::orderBy('name')->get();
            $bankDetails = InvestorHasBankDetails::with(['investor', 'bank', 'branch'])->get();

            return view('investments.create', [
                'investment' => $investment,
                'investors' => $investors,
                'products' => $products,
                'bankDetails' => $bankDetails,
            ]);
        } catch (Throwable $th) {
            Log::error('Failed to load investment edit form', ['error' => $th->getMessage()]);

            return redirect()->back()->with('error', 'Unable to load investment for editing. Please try again.');
        }
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateInvestmentRequest $request, Investment $investment)
    {
        try {
            $data = $request->validated();
            $data['last_updated_by'] = Auth::id();

            $investment->update($data);

            return response()->json(['message' => 'Investment updated successfully.', 'status' => 'success', 'next_path' => route('investments.index')], 200);
        } catch (Throwable $th) {
            Log::error('Failed to update investment', ['investment_id' => $investment->id, 'error' => $th->getMessage()]);

            return response()->json(['message' => 'Unable to update investment. Please try again.', 'status' => 'error'], 500);
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Investment $investment)
    {
        try {
            $investment->delete();

            return response()->json(['message' => 'Investment deleted successfully', 'status' => 'success'], 200);
        } catch (Throwable $th) {
            Log::error('Failed to delete investment', ['investment_id' => $investment->id, 'error' => $th->getMessage()]);

            return response()->json(['message' => 'Unable to delete investment. Please try again.', 'status' => 'error'], 500);
        }
    }
}
