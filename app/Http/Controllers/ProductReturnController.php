<?php

namespace App\Http\Controllers;

use App\Models\ProductReturn;
use App\Models\Customer;
use Illuminate\Http\Request;
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
        return view('returns.index', compact('customers'));
    }

    public function getData(Request $request)
    {
        $query = ProductReturn::with('customer');

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
        } else {
            // Default to 'khách trả' if no filter applied but we want to show all initially?
            // User said "status (mặc định là khách trả)" for filters, but usually 
            // you want to see all or filter. Let's see. 
            // "bộ lọc: ... status (mặc định là khách trả)"
            // I'll apply it as a default filter value in JS if needed.
        }

        $returns = $query->latest('return_date')->get();

        // Calculate totals
        $totalCount = $returns->count();
        $totalRefund = $returns->sum('refund_amount');

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
            'product_name' => 'required|string',
            'quantity' => 'required|integer|min:1',
            'return_date' => 'required|date',
            'reason' => 'nullable|string',
            'refund_amount' => 'nullable|numeric|min:0',
            'status' => 'required|string'
        ]);

        $validated['refund_amount'] = $validated['refund_amount'] ?? 0;

        $return = ProductReturn::create($validated);

        return response()->json([
            'success' => true,
            'message' => 'Lưu đơn trả hàng thành công!',
            'return' => $return
        ]);
    }

    public function destroy($id)
    {
        $return = ProductReturn::findOrFail($id);
        $return->delete();

        return response()->json([
            'success' => true,
            'message' => 'Xóa đơn trả hàng thành công!'
        ]);
    }
}
