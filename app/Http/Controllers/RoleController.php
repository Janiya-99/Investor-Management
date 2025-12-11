<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;
use Yajra\DataTables\DataTables;
use Illuminate\Support\Facades\DB;

class RoleController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        try {
            if ($request->ajax()) {
                $data = Role::with('permissions')->get();

                return DataTables::of($data)
                    ->addIndexColumn()
                    ->addColumn('permissions', function ($role) {
                        return $role->permissions->pluck('name')->join(', ');
                    })
                    ->addColumn('action', function ($data) {
                        $buttons = '';
                        $buttons .= '<button data-bs-toggle="tooltip" title="Edit Role" class="btn btn-info btn-sm btn-edit m-1" data-bs-target="#varyingcontentModalLabel" data-id="' . $data->id . '"><i class="ti ti-pencil f-18"></i></button>';
                        $buttons .= '<button data-bs-toggle="tooltip" title="Delete Role" class="btn btn-danger btn-sm btn-delete m-1" onclick="handleDelete(\'' . route('roles.destroy', $data['id']) . '\', { _token: \'' . csrf_token() . '\' })"><i class="ti ti-trash f-18"></i></button>';
                        return $buttons;
                    })
                    ->rawColumns(['action'])
                    ->make(true);
            }
            return view('roles.index');
        } catch (\Throwable $th) {
            return response()->json(['message' => $th->getMessage(), 'status' => false], 500);
        }
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $permissions = Permission::all()->groupBy(function ($permission) {
            return explode('.', $permission->name)[0] ?? 'other';
        });
        return response()->json(['permissions' => $permissions, 'status' => 'success'], 200);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        try {
            $request->validate([
                'name' => 'required|string|unique:roles,name',
                'permissions' => 'required|array',
                'permissions.*' => 'exists:permissions,id',
            ]);

            DB::beginTransaction();

            $role = Role::create(['name' => $request->name, 'guard_name' => 'web']);
            $role->syncPermissions($request->permissions);

            DB::commit();

            return response()->json(['message' => 'Role created successfully', 'status' => 'success', 'next_path' => route('roles.index')], 200);
        } catch (\Throwable $th) {
            DB::rollBack();
            return response()->json(['message' => $th->getMessage(), 'status' => 'error'], 500);
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(Role $role)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Role $role)
    {
        try {
            $permissions = Permission::all()->groupBy(function ($permission) {
                return explode('.', $permission->name)[0] ?? 'other';
            });
            $role->load('permissions');
            return response()->json(['data' => $role, 'permissions' => $permissions, 'status' => 'success'], 200);
        } catch (\Throwable $th) {
            return response()->json(['message' => 'Failed to retrieve role', 'status' => 'error'], 500);
        }
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Role $role)
    {
        try {
            $request->validate([
                'name' => 'required|string|unique:roles,name,' . $role->id,
                'permissions' => 'required|array',
                'permissions.*' => 'exists:permissions,id',
            ]);

            DB::beginTransaction();

            $role->update(['name' => $request->name]);
            $role->syncPermissions($request->permissions);

            DB::commit();

            return response()->json(['message' => 'Role updated successfully', 'status' => 'success'], 200);
        } catch (\Throwable $th) {
            DB::rollBack();
            return response()->json(['message' => 'Failed to update role', 'status' => 'error'], 500);
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Role $role)
    {
        try {
            if ($role->name === 'Super Admin') {
                return response()->json(['message' => 'Cannot delete Super Admin role', 'status' => 'error'], 403);
            }
            $role->delete();
            return response()->json(['message' => 'Role deleted successfully', 'status' => 'success'], 200);
        } catch (\Throwable $th) {
            return response()->json(['message' => 'Failed to delete role', 'status' => 'error'], 500);
        }
    }
}

