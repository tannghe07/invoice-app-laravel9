<?php

namespace App\Http\Controllers;

use App\Models\Transaction;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class TransactionController extends Controller
{
    public function index(Request $request)
    {
        return view('transactions.index');
    }

    public function getData(Request $request)
    {
        $query = Transaction::query();

        // Filter by type (income or expense)
        if ($request->has('type') && $request->type != 'all') {
            $query->where('type', $request->type);
        }

        // Filter by content (description)
        if ($request->filled('description')) {
            $query->where('description', 'like', '%' . $request->description . '%');
        }

        // Filter by date range
        if ($request->filled('from_date')) {
            $query->whereDate('transaction_date', '>=', $request->from_date);
        }
        if ($request->filled('to_date')) {
            $query->whereDate('transaction_date', '<=', $request->to_date);
        }

        // Filter by predefined periods
        if ($request->has('filter') && $request->filter != 'all') {
            $now = Carbon::now();

            switch ($request->filter) {
                case 'day':
                    $query->whereDate('transaction_date', $now->toDateString());
                    break;
                case 'week':
                    $query->whereBetween('transaction_date', [
                        $now->startOfWeek()->toDateString(),
                        $now->endOfWeek()->toDateString()
                    ]);
                    break;
                case 'month':
                    $query->whereMonth('transaction_date', $now->month)
                        ->whereYear('transaction_date', $now->year);
                    break;
            }
        }

        // Get paginated data
        $transactions = $query->orderBy('transaction_date', 'desc')
            ->orderBy('created_at', 'desc')
            ->paginate(10);

        // Calculate totals
        $totalIncome = Transaction::where('type', 'income');
        $totalExpense = Transaction::where('type', 'expense');

        // Apply same filters to totals
        if ($request->filled('description')) {
            $totalIncome->where('description', 'like', '%' . $request->description . '%');
            $totalExpense->where('description', 'like', '%' . $request->description . '%');
        }

        if ($request->has('type') && $request->type != 'all') {
            if ($request->type == 'income') {
                $totalExpense->where('id', 0); // No expenses
            } else {
                $totalIncome->where('id', 0); // No income
            }
        }

        if ($request->filled('from_date')) {
            $totalIncome->whereDate('transaction_date', '>=', $request->from_date);
            $totalExpense->whereDate('transaction_date', '>=', $request->from_date);
        }
        if ($request->filled('to_date')) {
            $totalIncome->whereDate('transaction_date', '<=', $request->to_date);
            $totalExpense->whereDate('transaction_date', '<=', $request->to_date);
        }

        if ($request->has('filter') && $request->filter != 'all') {
            $now = Carbon::now();

            switch ($request->filter) {
                case 'day':
                    $totalIncome->whereDate('transaction_date', $now->toDateString());
                    $totalExpense->whereDate('transaction_date', $now->toDateString());
                    break;
                case 'week':
                    $totalIncome->whereBetween('transaction_date', [
                        $now->startOfWeek()->toDateString(),
                        $now->endOfWeek()->toDateString()
                    ]);
                    $totalExpense->whereBetween('transaction_date', [
                        $now->startOfWeek()->toDateString(),
                        $now->endOfWeek()->toDateString()
                    ]);
                    break;
                case 'month':
                    $totalIncome->whereMonth('transaction_date', $now->month)
                        ->whereYear('transaction_date', $now->year);
                    $totalExpense->whereMonth('transaction_date', $now->month)
                        ->whereYear('transaction_date', $now->year);
                    break;
            }
        }

        $totalIncome = $totalIncome->sum('amount');
        $totalExpense = $totalExpense->sum('amount');

        return response()->json([
            'transactions' => $transactions,
            'totalIncome' => $totalIncome,
            'totalExpense' => $totalExpense,
        ]);
    }

    public function store(Request $request)
    {
        $request->validate([
            'amount' => 'required|numeric|min:0',
            'description' => 'required|string|max:1000',
            'transaction_date' => 'required|date',
            'type' => 'required|in:income,expense',
        ]);

        $transaction = Transaction::create([
            'amount' => $request->amount,
            'description' => $request->description,
            'transaction_date' => $request->transaction_date,
            'type' => $request->type,
        ]);

        return response()->json([
            'success' => true,
            'message' => 'Giao dịch đã được tạo thành công!',
            'transaction' => $transaction
        ]);
    }

    public function show($id)
    {
        $transaction = Transaction::findOrFail($id);
        return response()->json($transaction);
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'amount' => 'required|numeric|min:0',
            'description' => 'required|string|max:1000',
            'transaction_date' => 'required|date',
            'type' => 'required|in:income,expense',
        ]);

        $transaction = Transaction::findOrFail($id);

        if ($transaction->invoice_id) {
            return response()->json([
                'success' => false,
                'message' => 'Không thể sửa giao dịch liên kết với hóa đơn!'
            ], 400);
        }

        $transaction->update([
            'amount' => $request->amount,
            'description' => $request->description,
            'transaction_date' => $request->transaction_date,
            'type' => $request->type,
        ]);

        return response()->json([
            'success' => true,
            'message' => 'Giao dịch đã được cập nhật thành công!',
            'transaction' => $transaction
        ]);
    }
    public function destroy($id)
    {
        $transaction = Transaction::findOrFail($id);

        // Don't allow deleting transactions linked to invoices
        if ($transaction->invoice_id) {
            return response()->json([
                'success' => false,
                'message' => 'Không thể xóa giao dịch liên kết với hóa đơn!'
            ], 400);
        }

        $transaction->delete();

        return response()->json([
            'success' => true,
            'message' => 'Giao dịch đã được xóa thành công!'
        ]);
    }
}
