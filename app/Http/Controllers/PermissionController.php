<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Spatie\Permission\Models\Permission;
use Yajra\DataTables\DataTables;

class PermissionController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        try {
            if ($request->ajax()) {
                $data = Permission::all();

                return DataTables::of($data)
                    ->addIndexColumn()
                    ->addColumn('module', function ($permission) {
                        return explode('.', $permission->name)[0] ?? 'other';
                    })
                    ->addColumn('action', function ($permission) {
                        return explode('.', $permission->name)[1] ?? 'other';
                    })
                    ->addColumn('action_buttons', function ($data) {
                        $buttons = '';
                        $buttons .= '<button data-bs-toggle="tooltip" title="Edit Permission" class="btn btn-info btn-sm btn-edit m-1" data-bs-target="#varyingcontentModalLabel" data-id="' . $data->id . '"><i class="ti ti-pencil f-18"></i></button>';
                        $buttons .= '<button data-bs-toggle="tooltip" title="Delete Permission" class="btn btn-danger btn-sm btn-delete m-1" onclick="handleDelete(\'' . route('permissions.destroy', $data['id']) . '\', { _token: \'' . csrf_token() . '\' })"><i class="ti ti-trash f-18"></i></button>';
                        return $buttons;
                    })
                    ->rawColumns(['action_buttons'])
                    ->make(true);
            }
            return view('permissions.index');
        } catch (\Throwable $th) {
            return response()->json(['message' => $th->getMessage(), 'status' => false], 500);
        }
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('permissions.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        try {
            $request->validate([
                'name' => 'required|string|unique:permissions,name',
            ]);

            Permission::create(['name' => $request->name, 'guard_name' => 'web']);

            return response()->json(['message' => 'Permission created successfully', 'status' => 'success', 'next_path' => route('permissions.index')], 200);
        } catch (\Throwable $th) {
            return response()->json(['message' => $th->getMessage(), 'status' => 'error'], 500);
        }
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Permission $permission)
    {
        try {
            return response()->json(['data' => $permission, 'status' => 'success'], 200);
        } catch (\Throwable $th) {
            return response()->json(['message' => 'Failed to retrieve permission', 'status' => 'error'], 500);
        }
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Permission $permission)
    {
        try {
            $request->validate([
                'name' => 'required|string|unique:permissions,name,' . $permission->id,
            ]);

            $permission->update(['name' => $request->name]);

            return response()->json(['message' => 'Permission updated successfully', 'status' => 'success'], 200);
        } catch (\Throwable $th) {
            return response()->json(['message' => 'Failed to update permission', 'status' => 'error'], 500);
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Permission $permission)
    {
        try {
            $permission->delete();
            return response()->json(['message' => 'Permission deleted successfully', 'status' => 'success'], 200);
        } catch (\Throwable $th) {
            return response()->json(['message' => 'Failed to delete permission', 'status' => 'error'], 500);
        }
    }
}



