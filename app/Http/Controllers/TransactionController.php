<?php

namespace App\Http\Controllers;

use App\Models\Transaction;
use Illuminate\Http\Request;
use Carbon\Carbon;
use Barryvdh\DomPDF\Facade\Pdf;

class TransactionController extends Controller
{
    /**
     * Display a listing of transactions
     */
    public function index(Request $request)
    {
        $query = Transaction::with(['user', 'details.product']);

        // Filter by date range
        if ($request->has('date_from') && $request->date_from) {
            $query->whereDate('transaction_date', '>=', $request->date_from);
        }

        if ($request->has('date_to') && $request->date_to) {
            $query->whereDate('transaction_date', '<=', $request->date_to);
        }

        // Filter by today if no date specified
        if (!$request->has('date_from') && !$request->has('date_to')) {
            $query->whereDate('transaction_date', Carbon::today());
        }

        // Filter by payment method
        if ($request->has('payment_method') && $request->payment_method) {
            $query->where('payment_method', $request->payment_method);
        }

        // Filter by status
        if ($request->has('status') && $request->status) {
            $query->where('status', $request->status);
        }

        // Search by transaction code or customer name
        if ($request->has('search') && $request->search) {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->where('transaction_code', 'like', "%{$search}%")
                  ->orWhere('customer_name', 'like', "%{$search}%");
            });
        }

        // If user is not owner, only show their own transactions
        if (!auth()->user()->hasRole('owner')) {
            $query->where('user_id', auth()->id());
        }

        $transactions = $query->latest('transaction_date')->paginate(15);

        // Calculate summary based on filtered results
        $summaryQuery = clone $query;
        $summary = [
            'total_transactions' => $summaryQuery->count(),
            'total_sales' => $summaryQuery->sum('total_amount'),
            'total_items' => $summaryQuery->with('details')->get()->sum(function($transaction) {
                return $transaction->details->sum('quantity');
            })
        ];

        return view('transactions.index', compact('transactions', 'summary'));
    }

    /**
     * Display the specified transaction
     */
    public function show(Transaction $transaction)
    {
        // Check if user can view this transaction
        if (!auth()->user()->hasRole('owner') && $transaction->user_id !== auth()->id()) {
            abort(403, 'Anda tidak memiliki akses untuk melihat transaksi ini.');
        }

        $transaction->load(['user', 'details.product.category']);

        return view('transactions.show', compact('transaction'));
    }

    /**
     * Print/download receipt as PDF
     */
    public function printReceipt(Transaction $transaction)
    {
        // Check permission
        if (!auth()->user()->can('print-receipts')) {
            abort(403, 'Anda tidak memiliki izin untuk mencetak struk.');
        }
        // Pastikan user hanya bisa print transaksi miliknya jika bukan owner
        if (!auth()->user()->hasRole('owner') && $transaction->user_id !== auth()->id()) {
            abort(403, 'Anda tidak memiliki akses untuk transaksi ini.');
        }
        $transaction->load(['user', 'details.product.category']);
        $pdf = Pdf::loadView('transactions.receipt', compact('transaction'));
        $filename = 'Struk-' . $transaction->transaction_code . '.pdf';
        return $pdf->download($filename);
    }

    /**
     * Get transaction data for dashboard
     */
    public function getDashboardData()
    {
        $today = Carbon::today();
        $thisWeek = Carbon::now()->startOfWeek();
        $thisMonth = Carbon::now()->startOfMonth();

        $data = [
            'today' => [
                'sales' => Transaction::whereDate('transaction_date', $today)->sum('total_amount'),
                'transactions' => Transaction::whereDate('transaction_date', $today)->count(),
            ],
            'this_week' => [
                'sales' => Transaction::where('transaction_date', '>=', $thisWeek)->sum('total_amount'),
                'transactions' => Transaction::where('transaction_date', '>=', $thisWeek)->count(),
            ],
            'this_month' => [
                'sales' => Transaction::where('transaction_date', '>=', $thisMonth)->sum('total_amount'),
                'transactions' => Transaction::where('transaction_date', '>=', $thisMonth)->count(),
            ],
            'recent_transactions' => Transaction::with(['user', 'details'])
                ->latest('transaction_date')
                ->limit(5)
                ->get()
        ];

        return response()->json($data);
    }
}
