<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\ProductReturn;
use Illuminate\Http\Request;
use Carbon\Carbon;

class ProductController extends Controller
{
    public function index()
    {
        return view('products.index');
    }

    public function getData(Request $request)
    {
        $query = Product::query();

        // Filter by code
        if ($request->filled('code')) {
            $query->where('code', 'like', '%' . $request->code . '%');
        }

        // Filter by name
        if ($request->filled('name')) {
            $query->where('name', 'like', '%' . $request->name . '%');
        }

        $products = $query->orderBy('created_at', 'desc')->paginate(10);

        // Calculate totals based on filtered query
        $totalQuantity = (clone $query)->sum('quantity');
        $totalValue = (clone $query)->selectRaw('SUM(quantity * price) as total')->value('total') ?? 0;

        return response()->json([
            'products' => $products,
            'totalQuantity' => $totalQuantity,
            'totalValue' => $totalValue,
        ]);
    }

    public function store(Request $request)
    {
        $request->validate([
            'code' => 'required|unique:products,code',
            'name' => 'required',
            'quantity' => 'required|integer|min:1',
            'price' => 'required|numeric|min:0',
            'import_date' => 'required|date',
        ]);

        $product = Product::create($request->all());

        return response()->json([
            'success' => true,
            'message' => 'Nhập hàng thành công!',
            'product' => $product
        ]);
    }

    public function update(Request $request, $id)
    {
        $product = Product::findOrFail($id);

        $request->validate([
            'code' => 'required|unique:products,code,' . $id,
            'name' => 'required',
            'quantity' => 'required|integer|min:0',
            'price' => 'required|numeric|min:0',
            'import_date' => 'required|date',
        ]);

        $product->update($request->all());

        return response()->json([
            'success' => true,
            'message' => 'Cập nhật thông tin thành công!',
            'product' => $product
        ]);
    }

    public function destroy($id)
    {
        $product = Product::findOrFail($id);
        $product->delete();

        return response()->json([
            'success' => true,
            'message' => 'Xóa sản phẩm thành công!'
        ]);
    }

    public function returnProduct(Request $request, $id)
    {
        $request->validate([
            'quantity' => 'required|integer|min:1',
            // return_date is not strictly needed for logic unless we log it, but user asked for form.
        ]);

        $product = Product::findOrFail($id);

        if ($request->quantity > $product->quantity) {
            return response()->json([
                'success' => false,
                'message' => 'Số lượng trả không được lớn hơn số lượng tồn kho!'
            ], 422);
        }

        $product->quantity -= $request->quantity;
        $product->save();

        // Create log in ProductReturn
        ProductReturn::create([
            'product_name' => $product->name,
            'quantity' => $request->quantity,
            'return_date' => $request->return_date ?? date('Y-m-d'),
            'reason' => 'Trả cho nhà cung cấp từ kho',
            'refund_amount' => 0, // Usually no direct refund tracking for supplier returns here
            'status' => 'trả cho nhà cung cấp'
        ]);

        return response()->json([
            'success' => true,
            'message' => 'Trả hàng thành công!'
        ]);
    }
}
