<?php

namespace App\Http\Controllers;

use App\Models\Customer;
use Illuminate\Http\Request;

class CustomerController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show customers management page
     */
    public function index()
    {
        return view('customers');
    }

    /**
     * Check if phone number exists
     */
    public function checkPhone(Request $request)
    {
        $phone = $request->query('phone');
        $customerId = $request->query('customer_id');

        $query = Customer::where('phone', $phone);

        if ($customerId) {
            $query->where('id', '!=', $customerId);
        }

        $exists = $query->exists();

        return response()->json([
            'exists' => $exists,
            'message' => $exists ? 'Số điện thoại này đã tồn tại trong hệ thống' : 'OK'
        ]);
    }

    /**
     * Get customers data with filters
     */
    public function getData(Request $request)
    {
        $query = Customer::query();

        if ($request->filled('name')) {
            $query->where('name', 'like', '%' . $request->name . '%');
        }

        if ($request->filled('phone')) {
            $query->where('phone', 'like', '%' . $request->phone . '%');
        }

        $customers = $query->withCount('invoices')->latest()->get();

        return response()->json($customers->map(function ($customer) {
            return [
                'id' => $customer->id,
                'name' => $customer->name,
                'phone' => $customer->phone,
                'address' => $customer->address,
                'invoices_count' => $customer->invoices_count,
            ];
        }));
    }

    /**
     * Get single customer
     */
    public function show($id)
    {
        $customer = Customer::findOrFail($id);
        return response()->json($customer);
    }

    /**
     * Store new customer
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'phone' => 'nullable|string|max:20|unique:customers,phone',
            'address' => 'nullable|string|max:255',
        ]);

        $customer = Customer::create($validated);

        return response()->json([
            'success' => true,
            'customer' => $customer
        ]);
    }

    /**
     * Update customer
     */
    public function update(Request $request, $id)
    {
        $customer = Customer::findOrFail($id);

        $validated = $request->validate([
            'name' => 'sometimes|required|string|max:255',
            'phone' => 'nullable|string|max:20|unique:customers,phone,' . $id,
            'address' => 'nullable|string|max:255',
        ]);

        $customer->update($validated);

        return response()->json([
            'success' => true,
            'customer' => $customer
        ]);
    }

    /**
     * Delete customer
     */
    public function destroy($id)
    {
        $customer = Customer::findOrFail($id);

        // Check if customer has invoices
        if ($customer->invoices()->count() > 0) {
            return response()->json([
                'success' => false,
                'message' => 'Không thể xóa khách hàng đã có hóa đơn'
            ], 400);
        }

        $customer->delete();

        return response()->json(['success' => true]);
    }
}
