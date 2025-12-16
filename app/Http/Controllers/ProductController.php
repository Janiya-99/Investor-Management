<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;
use App\Http\Requests\ProductRequest;
use Yajra\DataTables\Facades\DataTables;

class ProductController extends Controller
{
    public function __construct()
    {
        $this->middleware('permission:products.view', ['only' => ['index']]);
        $this->middleware('permission:products.create', ['only' => ['create', 'store']]);
        $this->middleware('permission:products.edit', ['only' => ['edit', 'update']]);
        $this->middleware('permission:products.delete', ['only' => ['destroy']]);
    }
    
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        try {
            //code...
            if ($request->ajax()) {

                $data = Product::all();

                return DataTables::of($data)
                    ->addIndexColumn()
                    ->addColumn('action', function ($data) {
                        $buttons = '';

                        // if (auth()->user()->can('admin-common-user-view')) {
                        $buttons .= ' <button data-bs-toggle="modal" data-bs-target="#varyingcontentModalLabel" class="btn btn-info btn-sm btn-edit m-1" data-id="' . $data->id . '" ><i class="ti ti-pencil f-18"></i></button>';
                        // }
                        // if (auth()->user()->can('admin-common-user-delete')) {
                            if ($data->status !== 1) {
                                $buttons .= '<button class="btn btn-danger btn-sm btn-delete m-1" onclick="handleDelete(\'' . route('products.destroy', $data['id']) . '\', { _token: \'' . csrf_token() . '\' })"><i class="ti ti-trash f-18"></i></button>';
                            }
                        // }
                        return $buttons;
                    })
                    ->rawColumns(['action'])
                    ->make(true);
            }
                 return view('products.index');

        } catch (\Throwable $th) {
            return response()->json(['message' => $th->getMessage(), 'status' => false], 500);
        }
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(ProductRequest $request)
    {
        try {
            //code...
            $data = $request->validated();
            Product::create($data);
            return response()->json(['message' => 'Product created successfully', 'status' => true], 200);
        } catch (\Throwable $th) {
            return response()->json(['message' => $th->getMessage(), 'status' => false], 500);
        }
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Product $product)
    {
        try {
            //code...
            return response()->json(['data' => $product, 'status' => true], 200);
        } catch (\Throwable $th) {
            return response()->json(['message' => $th->getMessage(), 'status' => false], 500);
        }
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(ProductRequest $request, Product $product)
    {
        try {
            //code...
            $data = $request->validated();
            $product->update($data);
            return response()->json(['message' => 'Product updated successfully', 'status' => true], 200);
        } catch (\Throwable $th) {
            return response()->json(['message' => $th->getMessage(), 'status' => false], 500);
        }
    }


    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Product $product)
    {
        try {
            //code...
            $product->delete();
            return response()->json(['message' => 'Product deleted successfully', 'status' => true], 200);
        } catch (\Throwable $th) {
            //throw $th;
            return response()->json(['message' => $th->getMessage(), 'status' => false], 500);
        }
    }
}
