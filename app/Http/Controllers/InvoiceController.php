<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Invoice;
use App\Models\Customer;
use App\Models\InvoiceDetail;
use App\Models\Product;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;

class InvoiceController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function dashboard()
    {
        $customers = Customer::all();
        $products = Product::all();
        return view('dashboard', compact('customers', 'products'));
    }

    public function getInvoices(Request $request)
    {
        $query = Invoice::with(['customer', 'details']);

        if ($request->get('show_trashed') === 'true') {
            $query->onlyTrashed();
        }

        // Filter by customer id
        if ($request->filled('customer_id')) {
            $query->where('customer_id', $request->customer_id);
        }

        // Filter by date range
        if ($request->filled('from_date')) {
            $query->where('invoice_date', '>=', $request->from_date);
        }
        if ($request->filled('to_date')) {
            $query->where('invoice_date', '<=', $request->to_date);
        }

        $invoices = $query->latest()->get();

        // Calculate totals - decide if trashed should be included.
        // If users says "don't affect revenue", we should probably sum over withTrashed() in dashboard 
        // but for the current filtered list, we sum what's visible.
        $totalRevenue = $invoices->sum('total_amount');
        $totalCount = $invoices->count();

        return response()->json([
            'invoices' => $invoices->map(function ($invoice) {
                return [
                    'id' => $invoice->id,
                    'customer_name' => $invoice->customer->name,
                    'customer_phone' => $invoice->customer->phone,
                    'product_name' => $invoice->details->map(function ($d) {
                        return $d->product_name . ' (x' . $d->quantity . ')';
                    })->implode(', '),
                    'total_amount' => (float) $invoice->total_amount,
                    'invoice_date' => $invoice->invoice_date->format('Y-m-d'),
                    'is_trashed' => $invoice->trashed(),
                ];
            }),
            'totalRevenue' => $totalRevenue,
            'totalCount' => $totalCount,
        ]);
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'customer_id' => 'required|integer|exists:customers,id',
            'invoice_date' => 'required|date',
            'details' => 'required|array|min:1',
            'details.*.product_id' => 'required|integer|exists:products,id',
            'details.*.quantity' => 'required|integer|min:1',
            'details.*.price' => 'required|numeric|min:0',
            // Total amount is calculated on backend for security, but allow parsing if needed
        ]);

        try {
            DB::beginTransaction();

            $customer = Customer::findOrFail($validated['customer_id']);

            // Calculate total amount
            $totalAmount = 0;
            foreach ($validated['details'] as $item) {
                $totalAmount += $item['quantity'] * $item['price'];
            }

            // Create invoice (removed paid_amount, debt, status -> treating as simple record)
            $invoice = Invoice::create([
                'customer_id' => $customer->id,
                'invoice_date' => $validated['invoice_date'],
                'total_amount' => $totalAmount,
                'paid_amount' => $totalAmount, // Assuming fully paid as we removed debt tracking
                'debt_amount' => 0,
                'change_amount' => 0,
                'status' => 'paid',
            ]);

            // Create details and update stock
            foreach ($validated['details'] as $item) {
                $product = Product::lockForUpdate()->find($item['product_id']);

                InvoiceDetail::create([
                    'invoice_id' => $invoice->id,
                    'product_id' => $product->id,
                    'product_name' => $product->name,
                    'quantity' => $item['quantity'],
                    'price' => $item['price'],
                ]);

                // Deduct stock
                $product->quantity -= $item['quantity'];
                $product->save();
            }

            DB::commit();

            return response()->json([
                'success' => true,
                'message' => 'Tạo hóa đơn thành công!',
                'invoice' => $invoice
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
        $invoice = Invoice::with(['customer', 'details.product'])->findOrFail($id);

        // Prepare detailed response
        $data = $invoice->toArray();
        $data['details'] = $invoice->details->map(function ($detail) {
            return [
                'product_id' => $detail->product_id,
                'product_code' => $detail->product ? $detail->product->code : '-',
                'product_name' => $detail->product_name,
                'quantity' => $detail->quantity,
                'price' => $detail->price,
                'total' => $detail->quantity * $detail->price
            ];
        });

        return response()->json($data);
    }

    public function update(Request $request, $id)
    {
        $validated = $request->validate([
            'customer_id' => 'required|integer|exists:customers,id',
            'invoice_date' => 'required|date',
            'details' => 'required|array|min:1',
            'details.*.product_id' => 'required|integer|exists:products,id',
            'details.*.quantity' => 'required|integer|min:1',
            'details.*.price' => 'required|numeric|min:0',
        ]);

        try {
            DB::beginTransaction();

            $invoice = Invoice::with('details')->findOrFail($id);

            // 1. Restore stock from old details
            foreach ($invoice->details as $detail) {
                if ($detail->product_id) {
                    $product = Product::lockForUpdate()->find($detail->product_id);
                    if ($product) {
                        $product->quantity += $detail->quantity;
                        $product->save();
                    }
                }
                $detail->delete(); // Remove old detail
            }

            // 2. Calculate new total
            $totalAmount = 0;
            foreach ($validated['details'] as $item) {
                $totalAmount += $item['quantity'] * $item['price'];
            }

            // 3. Update Invoice
            $invoice->update([
                'customer_id' => $validated['customer_id'],
                'invoice_date' => $validated['invoice_date'],
                'total_amount' => $totalAmount,
                'paid_amount' => $totalAmount, // Assuming fully paid
            ]);

            // 4. Create new details and deduct stock
            foreach ($validated['details'] as $item) {
                $product = Product::lockForUpdate()->find($item['product_id']);

                InvoiceDetail::create([
                    'invoice_id' => $invoice->id,
                    'product_id' => $product->id,
                    'product_name' => $product->name,
                    'quantity' => $item['quantity'],
                    'price' => $item['price'],
                ]);

                $product->quantity -= $item['quantity'];
                $product->save();
            }

            DB::commit();

            return response()->json([
                'success' => true,
                'message' => 'Cập nhật hóa đơn thành công!',
                'invoice' => $invoice
            ]);

        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json([
                'success' => false,
                'message' => 'Lỗi: ' . $e->getMessage()
            ], 400);
        }
    }

    public function getCustomers()
    {
        $customers = Customer::all();
        return response()->json($customers);
    }

    public function destroy($id)
    {
        $invoice = Invoice::findOrFail($id);
        $invoice->delete();

        return response()->json([
            'success' => true,
            'message' => 'Hóa đơn đã được đưa vào thùng rác.'
        ]);
    }

    public function restore($id)
    {
        $invoice = Invoice::onlyTrashed()->findOrFail($id);
        $invoice->restore();

        return response()->json([
            'success' => true,
            'message' => 'Hóa đơn đã được khôi phục.'
        ]);
    }
}
