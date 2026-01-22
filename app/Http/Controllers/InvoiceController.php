<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Invoice;
use App\Models\Customer;
use App\Models\InvoiceDetail;
use Carbon\Carbon;

class InvoiceController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function dashboard()
    {
        $customers = Customer::all();
        return view('dashboard', compact('customers'));
    }

    public function getInvoices(Request $request)
    {
        $query = Invoice::with('customer', 'details');

        // Filter by customer name
        if ($request->filled('customer_name')) {
            $query->whereHas('customer', function ($q) use ($request) {
                $q->where('name', 'like', '%' . $request->customer_name . '%');
            });
        }

        // Filter by date range
        if ($request->filled('from_date')) {
            $query->where('invoice_date', '>=', $request->from_date);
        }
        if ($request->filled('to_date')) {
            $query->where('invoice_date', '<=', $request->to_date);
        }

        // Filter by status
        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        $invoices = $query->latest()->get();

        return response()->json($invoices->map(function ($invoice) {
            return [
                'id' => $invoice->id,
                'customer_name' => $invoice->customer->name,
                'customer_phone' => $invoice->customer->phone,
                'product_name' => $invoice->details->pluck('product_name')->implode(', '),
                'total_amount' => (float) $invoice->total_amount,
                'paid_amount' => (float) $invoice->paid_amount,
                'debt_amount' => (float) $invoice->debt_amount,
                'status' => $invoice->status,
                'invoice_date' => $invoice->invoice_date->format('Y-m-d'),
                'image_path' => $invoice->image_path,
            ];
        }));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'customer_id' => 'nullable|integer',
            'customer_name' => 'required|string',
            'customer_phone' => 'required|string',
            'customer_address' => 'nullable|string',
            'invoice_date' => 'required|date',
            'product_name' => 'required|string',
            'price' => 'required|numeric|min:0',
            'paid_amount' => 'required|numeric|min:0',
        ]);

        // Find or create customer
        $customer = null;
        if ($validated['customer_id']) {
            $customer = Customer::find($validated['customer_id']);
        } else {
            $customer = Customer::firstOrCreate(
                ['phone' => $validated['customer_phone']],
                [
                    'name' => $validated['customer_name'],
                    'address' => $validated['customer_address'] ?? null
                ]
            );
        }

        // Calculate amounts
        $total_amount = $validated['price'];
        $paid_amount = $validated['paid_amount'];
        $debt_amount = max(0, $total_amount - $paid_amount);
        $change_amount = max(0, $paid_amount - $total_amount);
        $status = $debt_amount == 0 ? 'paid' : 'pending';

        // Create invoice
        $invoice = Invoice::create([
            'customer_id' => $customer->id,
            'invoice_date' => $validated['invoice_date'],
            'total_amount' => $total_amount,
            'paid_amount' => $paid_amount,
            'debt_amount' => $debt_amount,
            'change_amount' => $change_amount,
            'status' => $status,
        ]);

        // Create invoice detail
        InvoiceDetail::create([
            'invoice_id' => $invoice->id,
            'product_name' => $validated['product_name'],
            'price' => $validated['price'],
        ]);

        return response()->json([
            'success' => true,
            'invoice' => [
                'id' => $invoice->id,
                'customer_name' => $invoice->customer->name,
                'customer_phone' => $invoice->customer->phone,
                'product_name' => $invoice->details->pluck('product_name')->implode(', '),
                'total_amount' => (float) $invoice->total_amount,
                'paid_amount' => (float) $invoice->paid_amount,
                'debt_amount' => (float) $invoice->debt_amount,
                'change_amount' => (float) $invoice->change_amount,
                'status' => $invoice->status,
                'invoice_date' => $invoice->invoice_date->format('Y-m-d'),
            ]
        ]);
    }

    public function show($id)
    {
        $invoice = Invoice::with('customer', 'details')->findOrFail($id);
        return response()->json($invoice);
    }

    public function update(Request $request, $id)
    {
        $invoice = Invoice::findOrFail($id);

        $validated = $request->validate([
            'status' => 'required|in:pending,paid',
        ]);

        $invoice->update($validated);

        return response()->json(['success' => true, 'invoice' => $invoice]);
    }

    public function destroy($id)
    {
        $invoice = Invoice::findOrFail($id);
        $invoice->delete();
        return response()->json(['success' => true]);
    }

    public function getCustomers()
    {
        $customers = Customer::all();
        return response()->json($customers);
    }
}
