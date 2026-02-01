<?php

namespace App\Http\Controllers;

use App\Models\ProductReturn;
use App\Models\ProductReturnDetail;
use App\Models\Customer;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class ProductReturnController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index()
    {
        $customers = Customer::all();
        $products = Product::all();
        return view('returns.index', compact('customers', 'products'));
    }

    public function getData(Request $request)
    {
        $query = ProductReturn::with(['customer', 'details']);

        // Filter by customer
        if ($request->filled('customer_id')) {
            $query->where('customer_id', $request->customer_id);
        }

        // Filter by date range
        if ($request->filled('from_date')) {
            $query->where('return_date', '>=', $request->from_date);
        }
        if ($request->filled('to_date')) {
            $query->where('return_date', '<=', $request->to_date);
        }

        // Filter by status
        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        $returns = $query->latest('return_date')->get();

        // Calculate totals
        $totalCount = $returns->count();
        $totalRefund = $returns->sum('total_refund_amount');

        return response()->json([
            'returns' => $returns,
            'totalCount' => $totalCount,
            'totalRefund' => $totalRefund,
        ]);
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'customer_id' => 'required_if:status,khách trả|nullable|exists:customers,id',
            'return_date' => 'required|date',
            'reason' => 'nullable|string',
            'status' => 'required|string',
            'details' => 'required|array|min:1',
            'details.*.product_id' => 'required|integer|exists:products,id',
            'details.*.quantity' => 'required|integer|min:1',
            'details.*.refund_price' => 'required|numeric|min:0',
        ]);

        try {
            DB::beginTransaction();

            $totalRefundAmount = 0;
            foreach ($validated['details'] as $item) {
                $totalRefundAmount += $item['quantity'] * $item['refund_price'];
            }

            $return = ProductReturn::create([
                'customer_id' => $validated['customer_id'],
                'return_date' => $validated['return_date'],
                'reason' => $validated['reason'],
                'total_refund_amount' => $totalRefundAmount,
                'status' => $validated['status']
            ]);

            foreach ($validated['details'] as $item) {
                $product = Product::lockForUpdate()->find($item['product_id']);

                ProductReturnDetail::create([
                    'product_return_id' => $return->id,
                    'product_id' => $product->id,
                    'product_name' => $product->name,
                    'quantity' => $item['quantity'],
                    'refund_price' => $item['refund_price'],
                ]);

                // Increment stock
                $product->quantity += $item['quantity'];
                $product->save();
            }

            DB::commit();

            return response()->json([
                'success' => true,
                'message' => 'Tạo đơn trả hàng thành công!',
                'return' => $return
            ]);

        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json([
                'success' => false,
                'message' => 'Lỗi: ' . $e->getMessage()
            ], 400);
        }
    }

    public function destroy($id)
    {
        try {
            DB::beginTransaction();
            $return = ProductReturn::with('details')->findOrFail($id);

            // When deleting a return order, should we deduct stock back? 
            // Usually yes, if it was a mistake. 
            foreach ($return->details as $item) {
                if ($item->product_id) {
                    $product = Product::lockForUpdate()->find($item->product_id);
                    if ($product) {
                        $product->quantity -= $item->quantity;
                        $product->save();
                    }
                }
            }

            $return->delete(); // Cascades to details if set in migration

            DB::commit();

            return response()->json([
                'success' => true,
                'message' => 'Xóa đơn trả hàng thành công!'
            ]);
        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json([
                'success' => false,
                'message' => 'Lỗi: ' . $e->getMessage()
            ], 400);
        }
    }
    public function show($id)
    {
        $return = ProductReturn::with(['customer', 'details.product'])->findOrFail($id);
        return response()->json($return);
    }

    public function update(Request $request, $id)
    {
        $validated = $request->validate([
            'customer_id' => 'required_if:status,khách trả|nullable|exists:customers,id',
            'return_date' => 'required|date',
            'reason' => 'nullable|string',
            'status' => 'required|string',
            'details' => 'required|array|min:1',
            'details.*.product_id' => 'required|integer|exists:products,id',
            'details.*.quantity' => 'required|integer|min:1',
            'details.*.refund_price' => 'required|numeric|min:0',
        ]);

        try {
            DB::beginTransaction();

            $return = ProductReturn::with('details')->findOrFail($id);

            // 1. Revert old stock changes (Subtract because they were added)
            foreach ($return->details as $oldDetail) {
                if ($oldDetail->product_id) {
                    $product = Product::lockForUpdate()->find($oldDetail->product_id);
                    if ($product) {
                        $product->quantity -= $oldDetail->quantity;
                        $product->save();
                    }
                }
            }

            // 2. Clear old details
            $return->details()->delete();

            // 3. Update master record
            $totalRefundAmount = 0;
            foreach ($validated['details'] as $item) {
                $totalRefundAmount += $item['quantity'] * $item['refund_price'];
            }

            $return->update([
                'customer_id' => $validated['customer_id'],
                'return_date' => $validated['return_date'],
                'reason' => $validated['reason'],
                'total_refund_amount' => $totalRefundAmount,
                'status' => $validated['status']
            ]);

            // 4. Create new details and Apply new stock changes (Increment)
            foreach ($validated['details'] as $item) {
                $product = Product::lockForUpdate()->find($item['product_id']);

                ProductReturnDetail::create([
                    'product_return_id' => $return->id,
                    'product_id' => $product->id,
                    'product_name' => $product->name,
                    'quantity' => $item['quantity'],
                    'refund_price' => $item['refund_price'],
                ]);

                // Increment stock
                $product->quantity += $item['quantity'];
                $product->save();
            }

            DB::commit();

            return response()->json([
                'success' => true,
                'message' => 'Cập nhật đơn trả hàng thành công!',
                'return' => $return
            ]);

        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json([
                'success' => false,
                'message' => 'Lỗi: ' . $e->getMessage()
            ], 400);
        }
    }
}
