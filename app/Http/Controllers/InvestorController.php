<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Investor;
use App\Models\Bank;
use App\Models\BankBranch;
use App\Models\InvestorHasBankDetails;
use App\Models\InvestorHasDocument;
use Illuminate\Support\Facades\Hash;
use App\Http\Requests\StoreInvestorRequest;
use App\Http\Requests\UpdateInvestorDocumentsRequest;
use App\Http\Requests\UpdateInvestorBankDetailsRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Yajra\DataTables\DataTables;

class InvestorController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        try {
            //code...
            if ($request->ajax()) {

                $data = Investor::all();

                return DataTables::of($data)
                    ->addIndexColumn()
                    ->addColumn('action', function ($data) {
                        $buttons = '';

                        // Edit button
                        $buttons .= '<button data-bs-toggle="tooltip" title="Edit Investor" class="btn btn-info btn-sm btn-edit m-1" data-bs-target="#varyingcontentModalLabel"  data-id="' . $data->id . '"><i class="ti ti-pencil f-18"></i></button>';

                        // Delete button
                        $buttons .= '<button data-bs-toggle="tooltip" title="Delete Investor" class="btn btn-danger btn-sm btn-delete m-1" onclick="handleDelete(\'' . route('investors.destroy', $data['id']) . '\', { _token: \'' . csrf_token() . '\' })"><i class="ti ti-trash f-18"></i></button>';

                        return $buttons;
                    })
                    ->rawColumns(['action'])
                    ->make(true);
            }
            return view('investors.index');
        } catch (\Throwable $th) {
            return response()->json(['message' => $th->getMessage(), 'status' => false], 500);
        }
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $banks = Bank::orderBy('bank_name', 'asc')->get();
        return view('investors.create', compact('banks'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreInvestorRequest $request)
    {
        try {
            //code...
            DB::beginTransaction();

            $data = $request->validated();
            $data['password'] = Hash::make($data['password']);
            $data['name'] = $data['full_name'];
            $data['last_updated_date_time'] = now();
            $data['created_by'] = Auth::id();
            $data['last_updated_by'] = Auth::id();

            $user = User::create($data);

            $user->assignRole('Investor');

            $data['user_id'] = $user->id;
            $investor = Investor::create($data);

            if ($request->filled('banks')) {
                foreach ($request->input('banks') as $bank) {
                    $investor->bankDetails()->create([
                        'bank_id' => $bank['bank_id'],
                        'bank_branch_id' => $bank['bank_branch_id'],
                        'account_number' => $bank['account_number'],
                        'account_name' => $bank['account_name'],
                    ]);
                }
            }


            if ($request->hasFile('documents.*.document_path')) {
                $documents = $request->input('documents', []);
                foreach ($request->file('documents') as $index => $document) {
                    $file = $document['document_path'] ?? null;

                    if (!$file) {
                        continue;
                    }

                    // Build the path inside storage/app
                    $path = "investors/{$investor->id}/documents/" . $file->getClientOriginalName();

                    // Store file in storage/app using Storage::disk('local')
                    Storage::disk('local')->put($path, file_get_contents($file));

                    $investor->documents()->create([
                        'description' => $documents[$index]['description'] ?? null,
                        'document_path' => $file->getClientOriginalName(),
                        'file_path' => $path,
                        'uploaded_by' => Auth::id(),
                        'uploaded_at' => now(),
                    ]);
                }
            }

            DB::commit();

            return response()->json(['message' => 'Investor created successfully', 'status' => 'success', 'next_path' => route('investors.index')], 200);
        } catch (\Throwable $th) {
            DB::rollBack();
            return response()->json(['message' => $th->getMessage(), 'status' => 'error'], 500);
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(Investor $investor)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Investor $investor)
    {
        try {
            //code...
            return response()->json(['data' => $investor, 'status' => 'success'], 200);
        } catch (\Throwable $th) {
            return response()->json(['message' => 'Failed to retrieve investor', 'status' => 'error'], 500);
        }
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(StoreInvestorRequest $request, Investor $investor)
    {
        try {
            DB::beginTransaction();
            //code...
            $data = $request->validated();
            $data['name'] = $data['full_name'];
            $data['last_updated_date_time'] = now();
            $data['last_updated_by'] = Auth::id();


            $investor->update($data);
            $investor->bankDetails()->delete();

            if ($request->filled('banks')) {
                foreach ($request->input('banks') as $bank) {
                    $investor->bankDetails()->create([
                        'bank_id' => $bank['bank_id'],
                        'bank_branch_id' => $bank['bank_branch_id'],
                        'account_number' => $bank['account_number'],
                        'account_name' => $bank['account_name'],
                    ]);
                }
            }

            $user = User::findOrFail($investor->user_id);
            if (!empty($data['password'])) {
                $data['password'] = Hash::make($data['password']);
            } else {
                unset($data['password']);
            }

            $user->update($data);

            if ($request->hasFile('documents')) {
                $documents = $request->input('documents', []);
                foreach ($request->file('documents') as $index => $document) {
                    $file = $document['document_path'] ?? null;
                    if (!$file) {
                        continue;
                    }

                    $storedPath = $file->store("investors/{$investor->id}/documents", 'public');

                    $investor->documents()->create([
                        'description' => $documents[$index]['description'] ?? null,
                        'document_path' => $file->getClientOriginalName(),
                        'file_path' => $storedPath,
                        'uploaded_by' => Auth::id(),
                        'uploaded_at' => now(),
                    ]);
                }
            }

            DB::commit();

            return response()->json(['message' => 'Investor updated successfully', 'status' => 'success'], 200);
        } catch (\Throwable $th) {
            DB::rollBack();
            return response()->json(['message' => $th->getMessage(), 'status' => 'error'], 500);
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Investor $investor)
    {
        try {
            DB::beginTransaction();

            $investor->delete();

            $user = User::findOrFail($investor->user_id);
            $user->update(['status' => 0]);

            DB::commit();
            return response()->json(['message' => 'Investor deleted successfully', 'status' => 'success'], 200);
        } catch (\Throwable $th) {
            DB::rollBack();
            return response()->json(['message' => $th->getMessage(), 'status' => 'error'], 500);
        }
    }

    /**
     * Get branches by bank ID
     */
    public function getBranchesByBank(Request $request, $bankId)
    {
        try {
            $branches = BankBranch::where('bank_id', $bankId)
                ->orderBy('bank_branch_name', 'asc')
                ->get(['id', 'bank_branch_code', 'bank_branch_name']);

            return response()->json(['branches' => $branches, 'status' => 'success'], 200);
        } catch (\Throwable $th) {
            return response()->json(['message' => 'Failed to fetch branches', 'status' => 'error'], 500);
        }
    }

    /**
     * Show investor documents page.
     */
    public function documentsPage(Request $request)
    {
        try {
            $investors = Investor::orderBy('full_name', 'asc')->get(['id', 'full_name', 'email']);
            $investor = null;

            if ($request->filled('investor_id')) {
                $investor = Investor::with('documents')->find($request->input('investor_id'));
            }

            return view('investors.documents', compact('investors', 'investor'));
        } catch (\Throwable $th) {
            return back()->withErrors(['error' => $th->getMessage()]);
        }
    }

    /**
     * Update investor documents.
     */
    public function updateDocuments(UpdateInvestorDocumentsRequest $request)
    {
        try {
            DB::beginTransaction();

            $investor = Investor::findOrFail($request->investor_id);

            if ($request->hasFile('documents')) {
                $documents = $request->input('documents', []);
                foreach ($request->file('documents') as $index => $document) {
                    $file = $document['document_path'] ?? null;
                    if (!$file) {
                        continue;
                    }

                    $storedPath = $file->store("investors/{$investor->id}/documents", 'public');

                    $investor->documents()->create([
                        'description' => $documents[$index]['description'] ?? null,
                        'document_path' => $file->getClientOriginalName(),
                        'file_path' => $storedPath,
                        'uploaded_by' => Auth::id(),
                        'uploaded_at' => now(),
                    ]);
                }
            }

            DB::commit();
            return back()->with(['success' => 'Documents uploaded successfully.', 'investor_id' => $investor->id]);
        } catch (\Throwable $th) {
            DB::rollBack();
            return back()->withErrors(['error' => $th->getMessage()]);
        }
    }

    /**
     * Show investor bank details page.
     */
    public function bankDetailsPage(Request $request)
    {
        try {
            $banks = Bank::orderBy('bank_name', 'asc')->get();
            $investors = Investor::orderBy('full_name', 'asc')->get(['id', 'full_name', 'email']);
            $investor = null;

            if ($request->filled('investor_id')) {
                $investor = Investor::with('bankDetails.branch')->find($request->input('investor_id'));
            }

            return view('investors.bank-details', compact('investor', 'banks', 'investors'));
        } catch (\Throwable $th) {
            return back()->withErrors(['error' => $th->getMessage()]);
        }
    }

    /**
     * Update investor bank details.
     */
    public function updateBankDetails(UpdateInvestorBankDetailsRequest $request)
    {
        try {
            DB::beginTransaction();

            $investor = Investor::findOrFail($request->investor_id);

            $investor->bankDetails()->delete();

            foreach ($request->input('banks') as $bank) {
                $investor->bankDetails()->create([
                    'bank_id' => $bank['bank_id'],
                    'bank_branch_id' => $bank['bank_branch_id'],
                    'account_number' => $bank['account_number'],
                    'account_name' => $bank['account_name'],
                ]);
            }

            DB::commit();
            return back()->with(['success' => 'Bank details updated successfully.', 'investor_id' => $investor->id]);
        } catch (\Throwable $th) {
            DB::rollBack();
            return back()->withErrors(['error' => $th->getMessage()]);
        }
    }

    public function returnDocument(InvestorHasDocument $document)
    {
        $path = $document->file_path;

        if (!Storage::disk('local')->exists($path)) {
            abort(404, 'File not found.');
        }

        $fullPath = Storage::disk('local')->path($path);

        return response()->file($fullPath);
    }
}
