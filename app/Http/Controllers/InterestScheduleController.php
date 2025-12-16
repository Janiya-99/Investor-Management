<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreInterestScheduleRequest;
use App\Http\Requests\UpdateInterestScheduleRequest;
use App\Models\InterestSchedule;
use App\Models\Investment;
use App\Models\Investor;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Yajra\DataTables\DataTables;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Throwable;

class InterestScheduleController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        try {
            if ($request->ajax()) {
                $investors = Investor::whereHas('investments.interestSchedules')
                    ->withCount(['investments as total_schedules_count' => function ($query) {
                        $query->join('interest_schedules', 'investments.id', '=', 'interest_schedules.investment_id');
                    }])
                    ->with(['investments.interestSchedules' => function ($query) {
                        $query->selectRaw('sum(total_amount) as pending_amount, investment_id')
                            ->where('status', 'pending')
                            ->groupBy('investment_id');
                    }]);

                return DataTables::of($investors)
                    ->addIndexColumn()
                    ->addColumn('total_pending_amount', function ($row) {
                        $total = $row->investments->flatMap->interestSchedules->sum('pending_amount');
                        return number_format($total, 2);
                    })
                    ->addColumn('action', function ($row) {
                        return '<button class="btn btn-sm btn-outline-primary btn-details" data-id="' . $row->id . '">View Schedules</button>';
                    })
                    ->make(true);
            }

            return view('interest-schedules.index');
        } catch (Throwable $th) {
            Log::error('Failed to load interest schedules', ['error' => $th->getMessage()]);
            return redirect()->back()->with('error', 'Unable to load interest schedules. Please try again.');
        }
    }

    public function getInvestorSchedules(Request $request, $investorId)
    {
        $schedules = InterestSchedule::whereHas('investment', function ($query) use ($investorId) {
            $query->where('investor_id', $investorId);
        })->with(['investment.product']);

        return DataTables::of($schedules)
            ->editColumn('investment_id', function ($row) {
                return '#' . $row->investment_id;
            })
            ->addColumn('product_name', function ($row) {
                return $row->investment->product->name ?? 'N/A';
            })
            ->editColumn('due_date', function ($row) {
                return optional($row->due_date)->format('Y-m-d');
            })
            ->editColumn('interest_amount', function ($row) {
                return number_format($row->interest_amount, 2);
            })
            ->editColumn('capital_amount', function ($row) {
                return number_format($row->capital_amount, 2);
            })
            ->editColumn('total_amount', function ($row) {
                return number_format($row->total_amount, 2);
            })
            ->editColumn('status', function ($row) {
                 $statusClass = match ($row->status) {
                    'paid' => 'bg-success-subtle text-success',
                    'overdue' => 'bg-danger-subtle text-danger',
                    'scheduled' => 'bg-info-subtle text-info',
                    'cancelled' => 'bg-secondary-subtle text-secondary',
                    default => 'bg-warning-subtle text-warning',
                };
                return '<span class="badge rounded-pill ' . $statusClass . '">' . ucfirst($row->status) . '</span>';
            })
            ->addColumn('action', function ($row) {
                 $editBtn = '<a href="' . route('interest-schedules.edit', $row->id) . '" class="btn btn-info btn-sm m-1"><i class="ti ti-pencil f-18"></i></a>';
                 $deleteBtn = '<button class="btn btn-danger btn-sm m-1" onclick="handleDelete(\'' . route('interest-schedules.destroy', $row->id) . '\', { _token: \'' . csrf_token() . '\' })"><i class="ti ti-trash f-18"></i></button>';
                 return $editBtn . $deleteBtn;
            })
            ->rawColumns(['status', 'action'])
            ->make(true);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        try {
            $investments = Investment::with(['investor', 'product'])
                ->orderByDesc('created_at')
                ->get();

            return view('interest-schedules.create', [
                'investments' => $investments,
            ]);
        } catch (Throwable $th) {
            Log::error('Failed to load interest schedule form', ['error' => $th->getMessage()]);

            return redirect()->back()->with('error', 'Unable to load interest schedule form. Please try again.');
        }
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreInterestScheduleRequest $request)
    {
        try {
            $data = $request->validated();
            $data['capital_amount'] = $data['capital_amount'] ?? 0;
            $data['total_amount'] = ($data['interest_amount'] ?? 0) + ($data['capital_amount'] ?? 0);
            $data['created_by'] = Auth::id();
            $data['last_updated_by'] = Auth::id();

            InterestSchedule::create($data);

            return redirect()->route('interest-schedules.index')->with('success', 'Interest schedule created successfully.');
        } catch (Throwable $th) {
            Log::error('Failed to create interest schedule', ['error' => $th->getMessage()]);

            return redirect()->back()->withInput()->with('error', 'Unable to create interest schedule. Please try again.');
        }
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(InterestSchedule $interestSchedule)
    {
        try {
            $investments = Investment::with(['investor', 'product'])
                ->orderByDesc('created_at')
                ->get();

            return view('interest-schedules.create', [
                'interestSchedule' => $interestSchedule,
                'investments' => $investments,
            ]);
        } catch (Throwable $th) {
            Log::error('Failed to load interest schedule edit form', ['schedule_id' => $interestSchedule->id, 'error' => $th->getMessage()]);

            return redirect()->back()->with('error', 'Unable to load interest schedule for editing. Please try again.');
        }
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateInterestScheduleRequest $request, InterestSchedule $interestSchedule)
    {
        try {
            $data = $request->validated();
            $data['capital_amount'] = $data['capital_amount'] ?? 0;
            $data['total_amount'] = ($data['interest_amount'] ?? 0) + ($data['capital_amount'] ?? 0);
            $data['last_updated_by'] = Auth::id();

            $interestSchedule->update($data);

            return redirect()->route('interest-schedules.index')->with('success', 'Interest schedule updated successfully.');
        } catch (Throwable $th) {
            Log::error('Failed to update interest schedule', ['schedule_id' => $interestSchedule->id, 'error' => $th->getMessage()]);

            return redirect()->back()->withInput()->with('error', 'Unable to update interest schedule. Please try again.');
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(InterestSchedule $interestSchedule)
    {
        try {
            $interestSchedule->delete();

            return redirect()->route('interest-schedules.index')->with('success', 'Interest schedule deleted successfully.');
        } catch (Throwable $th) {
            Log::error('Failed to delete interest schedule', ['schedule_id' => $interestSchedule->id, 'error' => $th->getMessage()]);

            return redirect()->back()->with('error', 'Unable to delete interest schedule. Please try again.');
        }
    }

    /**
     * Generate an interest schedule for an investment.
     */
    public static function generateForInvestment(Investment $investment, array $data)
    {
        $rate = $data['interest_rate'] / 100;
        $period = (int)$data['period'];
        $periodType = $data['period_type'];
        $calculationType = $data['interest_calculation_type'];
        $currentCapital = $data['investment_amount'];
        $startDate = Carbon::parse($data['start_date']);

        for ($i = 1; $i <= $period; $i++) {
            $dueDate = $startDate->copy();

            // Calculate due date based on period type
            switch ($periodType) {
                case 'days':
                    $dueDate->addDays($i);
                    break;
                case 'weeks':
                    $dueDate->addWeeks($i);
                    break;
                case 'months':
                    $dueDate->addMonths($i);
                    break;
                case 'years':
                    $dueDate->addYears($i);
                    break;
            }

            $interestAmount = $currentCapital * $rate;
            $totalAmount = $currentCapital + $interestAmount;

            InterestSchedule::create([
                'investment_id' => $investment->id,
                'due_date' => $dueDate,
                'interest_amount' => $interestAmount,
                'capital_amount' => $currentCapital,
                'total_amount' => $totalAmount,
                'status' => 'pending',
                'created_by' => Auth::id(),
                'last_updated_by' => Auth::id(),
            ]);

            // Update capital if compound interest, otherwise it stays the same (simple)
            if ($calculationType === 'compound') {
                $currentCapital = $totalAmount;
            }
        }
    }
}

