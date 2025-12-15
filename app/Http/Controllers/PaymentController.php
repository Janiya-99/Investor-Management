<?php

namespace App\Http\Controllers;

use App\Http\Requests\StorePaymentRequest;
use App\Http\Requests\UpdatePaymentRequest;
use App\Models\InvestorHasBankDetails;
use App\Models\Investment;
use App\Models\Payment;
use App\Models\InvestmentLog;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;

class PaymentController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        try {
            $payments = Payment::with(['investment.investor', 'bankDetail', 'user'])
                ->latest()
                ->paginate(15);

            return view('payments.index', compact('payments'));
        } catch (\Throwable $th) {
            Log::error('Failed to load payments list', ['error' => $th->getMessage()]);

            return redirect()->back()->with('error', 'Unable to load payments right now. Please try again.');
        }
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        try {
            $investments = Investment::with(['investor', 'product'])->orderByDesc('created_at')->get();
            $bankDetails = InvestorHasBankDetails::with(['investor', 'bank', 'branch'])->get();

            return view('payments.create', [
                'investments' => $investments,
                'bankDetails' => $bankDetails,
            ]);
        } catch (\Throwable $th) {
            Log::error('Failed to load payment create form', ['error' => $th->getMessage()]);

            return redirect()->back()->with('error', 'Unable to load payment form. Please try again.');
        }
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StorePaymentRequest $request)
    {
        try {
            $data = $request->validated();
            $data['created_by'] = Auth::id();
            $data['last_updated_by'] = Auth::id();
            $data['user_id'] = $data['user_id'] ?? Auth::id();

            $payment = Payment::create($data);

            InvestmentLog::create([
                'investment_id' => $payment->investment_id,
                'payment_id' => $payment->id,
                'type' => $payment->type,
                'amount' => $payment->amount,
                'log_date' => $payment->payment_date,
                'description' => 'Payment recorded',
                'created_by' => Auth::id(),
            ]);

            return redirect()->route('payments.index')->with('success', 'Payment recorded successfully.');
        } catch (\Throwable $th) {
            Log::error('Failed to record payment', ['error' => $th->getMessage()]);

            return redirect()->back()->withInput()->with('error', 'Unable to record payment. Please try again.');
        }
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Payment $payment)
    {
        try {
            $investments = Investment::with(['investor', 'product'])->orderByDesc('created_at')->get();
            $bankDetails = InvestorHasBankDetails::with(['investor', 'bank', 'branch'])->get();

            return view('payments.create', [
                'payment' => $payment,
                'investments' => $investments,
                'bankDetails' => $bankDetails,
            ]);
        } catch (\Throwable $th) {
            Log::error('Failed to load payment edit form', ['payment_id' => $payment->id, 'error' => $th->getMessage()]);

            return redirect()->back()->with('error', 'Unable to load payment for editing. Please try again.');
        }
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdatePaymentRequest $request, Payment $payment)
    {
        try {
            $data = $request->validated();
            $data['last_updated_by'] = Auth::id();
            $data['user_id'] = $data['user_id'] ?? Auth::id();

            $payment->update($data);

            $payment->logs()->create([
                'investment_id' => $payment->investment_id,
                'type' => $payment->type,
                'amount' => $payment->amount,
                'log_date' => $payment->payment_date,
                'description' => 'Payment updated',
                'created_by' => Auth::id(),
            ]);

            return redirect()->route('payments.index')->with('success', 'Payment updated successfully.');
        } catch (\Throwable $th) {
            Log::error('Failed to update payment', ['payment_id' => $payment->id, 'error' => $th->getMessage()]);

            return redirect()->back()->withInput()->with('error', 'Unable to update payment. Please try again.');
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Payment $payment)
    {
        try {
            $payment->delete();

            return redirect()->route('payments.index')->with('success', 'Payment deleted successfully.');
        } catch (\Throwable $th) {
            Log::error('Failed to delete payment', ['payment_id' => $payment->id, 'error' => $th->getMessage()]);

            return redirect()->back()->with('error', 'Unable to delete payment. Please try again.');
        }
    }
}
