<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Yajra\DataTables\DataTables;
use App\Http\Requests\UserRequest;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Testing\Fluent\Concerns\Has;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        try {
            //code...
            if ($request->ajax()) {

                $data = User::all();

                return DataTables::of($data)
                    ->addIndexColumn()
                    ->addColumn('action', function ($data) {
                        $buttons = '';

                        $loggedInUserId = Auth::id();
                        // if (auth()->user()->can('admin-common-user-view')) {
                        $buttons .= ' <button data-bs-toggle="modal" data-bs-target="#varyingcontentModalLabel" class="btn btn-info btn-sm btn-edit m-1" data-id="' . $data->id . '" ><i class="ti ti-pencil f-18"></i></button>';
                        // }
                        // if (auth()->user()->can('admin-common-user-delete')) {
                            if ($data->id !== $loggedInUserId) {
                                $buttons .= '<button class="btn btn-danger btn-sm btn-delete m-1" onclick="handleDelete(\'' . route('users.destroy', $data['id']) . '\', { _token: \'' . csrf_token() . '\' })"><i class="ti ti-trash f-18"></i></button>';
                            }
                        // }
                        return $buttons;
                    })
                    ->rawColumns(['action'])
                    ->make(true);
            }
            return view('users.index');
        } catch (\Throwable $th) {
            return response()->json(['message' => $th->getMessage(), 'status' => false], 500);
        }
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
    public function store(UserRequest $request)
    {
        try {
            //code...
            $data = $request->validated();

            if ($request->hasFile('profile_photo')) {
                $file = $request->file('profile_photo');
                $fileData = base64_encode(file_get_contents($file->getRealPath()));
                $data['profile_photo'] = 'data:' . $file->getMimeType() . ';base64,' . $fileData;
            }
            $data['password'] = Hash::make($data['password']);
            User::create($data);

            return response()->json(['message' => 'User created successfully', 'status' => true], 200);
        } catch (\Throwable $th) {
            return response()->json(['message' => $th->getMessage(), 'status' => false], 500);
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        try {
            //code...
            $user = User::findOrFail($id);
            return response()->json(['data' => $user, 'status' => true], 200);
        } catch (\Throwable $th) {
            return response()->json(['message' => $th->getMessage(), 'status' => false], 500);
        }
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UserRequest $request, string $id)
    {
        try {
            //code...
            $data = $request->validated();
            $user = User::findOrFail($id);
            if ($request->hasFile('profile_photo')) {
                $file = $request->file('profile_photo');
                $fileData = base64_encode(file_get_contents($file->getRealPath()));
                $data['profile_photo'] = 'data:' . $file->getMimeType() . ';base64,' . $fileData;
            }

            if (!empty($data['password'])) {
                $data['password'] = Hash::make($data['password']);
            } else {
                unset($data['password']);
            }

            $user->update($data);
            return response()->json(['message' => 'User updated successfully', 'status' => true], 200);
        } catch (\Throwable $th) {
            //throw $th;
            return response()->json(['message' => $th->getMessage(), 'status' => false], 500);
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        try {
            //code...
            $user = User::findOrFail($id);
            $user->delete();
            
            return response()->json(['message' => 'User deleted successfully', 'status' => true], 200);
        } catch (\Throwable $th) {
            return response()->json(['message' => $th->getMessage(), 'status' => false], 500);
        }
    }
}
