<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreInvestmentRequest;
use App\Http\Requests\UpdateInvestmentRequest;
use App\Models\Investor;
use App\Models\InvestorHasBankDetails;
use App\Models\Investment;
use App\Models\Product;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;

class InvestmentController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        try {
            $investments = Investment::with(['investor', 'product', 'bankDetail'])
                ->latest()
                ->paginate(15);

            return view('investments.index', compact('investments'));
        } catch (\Throwable $th) {
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
        } catch (\Throwable $th) {
            Log::error('Failed to load investment create form', ['error' => $th->getMessage()]);

            return redirect()->back()->with('error', 'Unable to load investment form. Please try again.');
        }
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreInvestmentRequest $request)
    {
        try {
            $data = $request->validated();
            $data['created_by'] = Auth::id();
            $data['last_updated_by'] = Auth::id();

            Investment::create($data);

            return redirect()->route('investments.index')->with('success', 'Investment created successfully.');
        } catch (\Throwable $th) {
            Log::error('Failed to create investment', ['error' => $th->getMessage()]);

            return redirect()->back()->withInput()->with('error', 'Unable to create investment. Please try again.');
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
        } catch (\Throwable $th) {
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

            return redirect()->route('investments.index')->with('success', 'Investment updated successfully.');
        } catch (\Throwable $th) {
            Log::error('Failed to update investment', ['investment_id' => $investment->id, 'error' => $th->getMessage()]);

            return redirect()->back()->withInput()->with('error', 'Unable to update investment. Please try again.');
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Investment $investment)
    {
        try {
            $investment->delete();

            return redirect()->route('investments.index')->with('success', 'Investment deleted successfully.');
        } catch (\Throwable $th) {
            Log::error('Failed to delete investment', ['investment_id' => $investment->id, 'error' => $th->getMessage()]);

            return redirect()->back()->with('error', 'Unable to delete investment. Please try again.');
        }
    }
}
