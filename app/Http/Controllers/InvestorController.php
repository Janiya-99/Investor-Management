<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreInvestorRequest;
use App\Models\Investor;

class InvestorController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return view('investors.index');
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreInvestorRequest $request)
    {
        try {
            //code...
            $data = $request->validated();
            Investor::create($data);
            return response()->json(['message' => 'Investor created successfully', 'status' => 'success'], 201);
        } catch (\Throwable $th) {
            return response()->json(['message' => 'Failed to create investor', 'status' => 'error'], 500);
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
            $data = $request->validated();
            $investor->update($data);
            return response()->json(['message' => 'Investor updated successfully', 'status' => 'success'], 200);
        } catch (\Throwable $th) {
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
