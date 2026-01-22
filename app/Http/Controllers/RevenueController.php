<?php

namespace App\Http\Controllers;

use App\Models\Invoice;
use App\Models\Customer;
use Illuminate\Http\Request;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;

class RevenueController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show revenue dashboard
     */
    public function dashboard()
    {
        $customers = Customer::all();
        return view('revenue', compact('customers'));
    }

    /**
     * Get revenue data based on filters
     */
    public function getData(Request $request)
    {
        $type = $request->query('type', 'day');
        $date = $request->query('date');
        $startDate = $request->query('start_date');
        $endDate = $request->query('end_date');
        $week = $request->query('week');
        $month = $request->query('month');
        $customerId = $request->query('customer_id');

        $query = Invoice::where('status', 'paid')->with('customer', 'details');

        switch ($type) {
            case 'day':
                if ($date) {
                    $query->whereDate('invoice_date', $date);
                } else {
                    $query->whereDate('invoice_date', today());
                }
                return $this->formatDayData($query->get());

            case 'date_range':
                if ($startDate && $endDate) {
                    $query->whereBetween('invoice_date', [$startDate, $endDate]);
                }
                return $this->formatDateRangeData($query->get(), $startDate, $endDate);

            case 'week':
                if ($week) {
                    $year = $request->query('year', now()->year);
                    $startOfWeek = Carbon::now()
                        ->setISODate($year, $week)
                        ->startOfWeek();
                    $endOfWeek = $startOfWeek->copy()->endOfWeek();
                    $query->whereBetween('invoice_date', [$startOfWeek, $endOfWeek]);
                }
                return $this->formatWeekData($query->get());

            case 'month':
                if ($month) {
                    $year = $request->query('year', now()->year);
                    $query->whereMonth('invoice_date', $month)
                        ->whereYear('invoice_date', $year);
                } else {
                    $query->whereMonth('invoice_date', now()->month)
                        ->whereYear('invoice_date', now()->year);
                }
                return $this->formatMonthData($query->get(), $month ?? now()->month, $request->query('year', now()->year));

            case 'customer':
                if ($customerId) {
                    $query->where('customer_id', $customerId);
                }
                return $this->formatCustomerData($query->get(), $customerId);

            default:
                return $this->formatDayData($query->get());
        }
    }

    /**
     * Format day revenue data
     */
    private function formatDayData($invoices)
    {
        $total = $invoices->sum('total_amount');
        $count = $invoices->count();

        return response()->json([
            'type' => 'day',
            'date' => now()->toDateString(),
            'total_revenue' => (float) $total,
            'invoice_count' => $count,
            'invoices' => $invoices->map(function ($invoice) {
                return [
                    'id' => $invoice->id,
                    'customer_name' => $invoice->customer->name,
                    'customer_phone' => $invoice->customer->phone,
                    'amount' => (float) $invoice->total_amount,
                    'date' => $invoice->invoice_date->format('Y-m-d'),
                ];
            })
        ]);
    }

    /**
     * Format date range revenue data
     */
    private function formatDateRangeData($invoices, $startDate, $endDate)
    {
        $groupedByDate = $invoices->groupBy(function ($invoice) {
            return $invoice->invoice_date->format('Y-m-d');
        })->map(function ($dayInvoices) {
            return [
                'total' => $dayInvoices->sum('total_amount'),
                'count' => $dayInvoices->count(),
            ];
        });

        return response()->json([
            'type' => 'date_range',
            'start_date' => $startDate,
            'end_date' => $endDate,
            'total_revenue' => (float) $invoices->sum('total_amount'),
            'total_count' => $invoices->count(),
            'daily_data' => $groupedByDate,
        ]);
    }

    /**
     * Format week revenue data
     */
    private function formatWeekData($invoices)
    {
        $total = $invoices->sum('total_amount');
        $groupedByDay = $invoices->groupBy(function ($invoice) {
            return $invoice->invoice_date->format('l (d/m)');
        })->map(function ($dayInvoices) {
            return [
                'total' => $dayInvoices->sum('total_amount'),
                'count' => $dayInvoices->count(),
            ];
        });

        return response()->json([
            'type' => 'week',
            'total_revenue' => (float) $total,
            'invoice_count' => $invoices->count(),
            'daily_data' => $groupedByDay,
        ]);
    }

    /**
     * Format month revenue data
     */
    private function formatMonthData($invoices, $month, $year)
    {
        $total = $invoices->sum('total_amount');
        $groupedByDay = $invoices->groupBy(function ($invoice) {
            return $invoice->invoice_date->format('d');
        })->map(function ($dayInvoices) {
            return [
                'total' => $dayInvoices->sum('total_amount'),
                'count' => $dayInvoices->count(),
            ];
        })->sortKeys();

        return response()->json([
            'type' => 'month',
            'month' => $month,
            'year' => $year,
            'total_revenue' => (float) $total,
            'invoice_count' => $invoices->count(),
            'daily_data' => $groupedByDay,
        ]);
    }

    /**
     * Format customer revenue data
     */
    private function formatCustomerData($invoices, $customerId = null)
    {
        if ($customerId) {
            $customer = Customer::find($customerId);
            $total = $invoices->sum('total_amount');

            return response()->json([
                'type' => 'customer',
                'customer' => $customer,
                'total_revenue' => (float) $total,
                'invoice_count' => $invoices->count(),
                'invoices' => $invoices->map(function ($invoice) {
                    return [
                        'id' => $invoice->id,
                        'date' => $invoice->invoice_date->format('Y-m-d'),
                        'amount' => (float) $invoice->total_amount,
                    ];
                })
            ]);
        } else {
            // Get all customers with their revenue
            $customerRevenue = Invoice::where('status', 'paid')
                ->with('customer')
                ->get()
                ->groupBy('customer_id')
                ->map(function ($invoices) {
                    return [
                        'customer' => $invoices->first()->customer,
                        'total_revenue' => (float) $invoices->sum('total_amount'),
                        'invoice_count' => $invoices->count(),
                    ];
                })
                ->sortByDesc('total_revenue')
                ->values();

            return response()->json([
                'type' => 'customer',
                'total_revenue' => (float) $invoices->sum('total_amount'),
                'total_customers' => count($customerRevenue),
                'customers' => $customerRevenue,
            ]);
        }
    }

    /**
     * Get summary statistics
     */
    public function getSummary()
    {
        $today = now()->toDateString();
        $thisMonth = now()->month;
        $thisYear = now()->year;

        $totalRevenue = Invoice::where('status', 'paid')->sum('total_amount');
        $todayRevenue = Invoice::where('status', 'paid')->whereDate('invoice_date', $today)->sum('total_amount');
        $monthRevenue = Invoice::where('status', 'paid')
            ->whereMonth('invoice_date', $thisMonth)
            ->whereYear('invoice_date', $thisYear)
            ->sum('total_amount');

        $totalInvoices = Invoice::count();
        $paidInvoices = Invoice::where('status', 'paid')->count();
        $pendingInvoices = Invoice::where('status', 'pending')->count();
        $totalCustomers = Customer::count();

        return response()->json([
            'total_revenue' => (float) $totalRevenue,
            'today_revenue' => (float) $todayRevenue,
            'month_revenue' => (float) $monthRevenue,
            'total_invoices' => $totalInvoices,
            'paid_invoices' => $paidInvoices,
            'pending_invoices' => $pendingInvoices,
            'total_customers' => $totalCustomers,
        ]);
    }
}
