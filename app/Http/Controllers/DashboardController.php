<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Product;
use App\Models\Category;
use App\Models\Transaction;
use App\Models\TransactionDetail;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;

class DashboardController extends Controller
{
    public function __construct()
    {
        $this->middleware('permission:view-dashboard');
    }

    /**
     * Display dashboard with required information
     */
    public function index()
    {
        // Get summary statistics
        $today = Carbon::today();
        $thisWeek = Carbon::now()->startOfWeek();
        $thisMonth = Carbon::now()->startOfMonth();

        // Sales summary
        $salesSummary = [
            'today' => [
                'sales' => Transaction::whereDate('transaction_date', $today)->sum('total_amount'),
                'transactions' => Transaction::whereDate('transaction_date', $today)->count(),
                'items_sold' => $this->getItemsSold($today, 'day')
            ],
            'this_week' => [
                'sales' => Transaction::where('transaction_date', '>=', $thisWeek)->sum('total_amount'),
                'transactions' => Transaction::where('transaction_date', '>=', $thisWeek)->count(),
                'items_sold' => $this->getItemsSold($thisWeek, 'week')
            ],
            'this_month' => [
                'sales' => Transaction::where('transaction_date', '>=', $thisMonth)->sum('total_amount'),
                'transactions' => Transaction::where('transaction_date', '>=', $thisMonth)->count(),
                'items_sold' => $this->getItemsSold($thisMonth, 'month')
            ]
        ];

        // Recent transactions (last 5)
        $recentTransactions = Transaction::with(['user', 'details'])
            ->latest('transaction_date')
            ->limit(5)
            ->get();

        // Low stock products (stock <= min_stock)
        $lowStockProducts = Product::with('category')
            ->lowStock()
            ->active()
            ->limit(10)
            ->get();

        // Top selling products (this month)
        $topProducts = $this->getTopSellingProducts($thisMonth);

        // Product stock overview
        $stockOverview = [
            'total_products' => Product::active()->count(),
            'out_of_stock' => Product::active()->where('stock', 0)->where('track_stock', true)->count(),
            'low_stock' => Product::lowStock()->active()->count(),
            'categories' => Category::active()->count()
        ];

        // Chart data for sales trend (last 7 days)
        $salesTrend = $this->getSalesTrend();

        return view('dashboard', compact(
            'salesSummary',
            'recentTransactions', 
            'lowStockProducts',
            'topProducts',
            'stockOverview',
            'salesTrend'
        ));
    }

    /**
     * Get items sold count for specified period
     */
    private function getItemsSold($date, $period)
    {
        $query = TransactionDetail::whereHas('transaction', function($q) use ($date, $period) {
            if ($period === 'day') {
                $q->whereDate('transaction_date', $date);
            } else {
                $q->where('transaction_date', '>=', $date);
            }
        });

        return $query->sum('quantity');
    }

    /**
     * Get top selling products for specified period
     */
    private function getTopSellingProducts($since)
    {
        return TransactionDetail::select('product_id', 'product_name', DB::raw('SUM(quantity) as total_sold'))
            ->whereHas('transaction', function($q) use ($since) {
                $q->where('transaction_date', '>=', $since);
            })
            ->groupBy('product_id', 'product_name')
            ->orderBy('total_sold', 'desc')
            ->limit(5)
            ->get();
    }

    /**
     * Get sales trend for last 7 days
     */
    private function getSalesTrend()
    {
        $trend = [];
        
        for ($i = 6; $i >= 0; $i--) {
            $date = Carbon::now()->subDays($i);
            $sales = Transaction::whereDate('transaction_date', $date->toDateString())
                               ->sum('total_amount');
            
            $trend[] = [
                'date' => $date->format('M d'),
                'sales' => $sales
            ];
        }

        return $trend;
    }

    /**
     * Get stock alerts for AJAX requests
     */
    public function getStockAlerts()
    {
        $alerts = Product::with('category')
            ->where(function($query) {
                $query->where('stock', 0)
                      ->orWhereColumn('stock', '<=', 'min_stock');
            })
            ->where('track_stock', true)
            ->where('is_active', true)
            ->get()
            ->map(function($product) {
                return [
                    'id' => $product->id,
                    'name' => $product->name,
                    'sku' => $product->sku,
                    'category' => $product->category->name,
                    'current_stock' => $product->stock,
                    'min_stock' => $product->min_stock,
                    'status' => $product->stock === 0 ? 'out_of_stock' : 'low_stock'
                ];
            });

        return response()->json($alerts);
    }

    /**
     * Get real-time dashboard data for AJAX updates
     */
    public function getDashboardData()
    {
        $today = Carbon::today();
        
        $data = [
            'today_sales' => Transaction::whereDate('transaction_date', $today)->sum('total_amount'),
            'today_transactions' => Transaction::whereDate('transaction_date', $today)->count(),
            'pending_transactions' => Transaction::where('status', 'pending')->count(),
            'low_stock_count' => Product::lowStock()->active()->count(),
            'out_of_stock_count' => Product::active()->where('stock', 0)->where('track_stock', true)->count(),
        ];

        return response()->json($data);
    }
}
