<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Investor;
use Illuminate\Support\Facades\Hash;
use App\Http\Requests\StoreInvestorRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
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
        return view('investors.create');
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

        //    $user->assignRole('investor');
            $data['user_id'] = $user->id;
            Investor::create($data);

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
            
            $user = User::findOrFail($investor->user_id);

            $user->update($data);
            
            DB::commit();

            return response()->json(['message' => 'Investor updated successfully', 'status' => 'success'], 200);
        } catch (\Throwable $th) {
            DB::rollBack();
            return response()->json(['message' => 'Failed to update investor', 'status' => 'error'], 500);
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Investor $investor)
    {
        try {
            $investor->delete();
            return response()->json(['message' => 'Investor deleted successfully', 'status' => 'success'], 200);
        } catch (\Throwable $th) {
            return response()->json(['message' => 'Failed to delete investor', 'status' => 'error'], 500);
        }
    }
}
