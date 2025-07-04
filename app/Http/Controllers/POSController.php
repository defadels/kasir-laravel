<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Product;
use App\Models\Category;
use App\Models\Transaction;
use App\Models\TransactionDetail;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;

class POSController extends Controller
{
    public function __construct()
    {
        // Middleware permissions are handled in routes/web.php
    }

    /**
     * Display POS interface
     */
    public function index(Request $request)
    {
        $categories = Category::active()->get();
        $products = Product::with('category')->active();

        // Search functionality
        if ($request->has('search') && $request->search) {
            $search = $request->search;
            $products->where(function($query) use ($search) {
                $query->where('name', 'like', "%{$search}%")
                      ->orWhere('sku', 'like', "%{$search}%")
                      ->orWhereHas('category', function($cat) use ($search) {
                          $cat->where('name', 'like', "%{$search}%");
                      });
            });
        }

        // Filter by category
        if ($request->has('category_id') && $request->category_id) {
            $products->where('category_id', $request->category_id);
        }

        $products = $products->paginate(12);
        $cart = Session::get('pos_cart', []);

        return view('pos.index', compact('categories', 'products', 'cart'));
    }

    /**
     * Search products for POS
     */
    public function searchProduct(Request $request)
    {
        $search = $request->search;
        
        $products = Product::with('category')
            ->active()
            ->where(function($query) use ($search) {
                $query->where('name', 'like', "%{$search}%")
                      ->orWhere('sku', 'like', "%{$search}%");
            })
            ->limit(10)
            ->get();

        return response()->json($products);
    }

    /**
     * Add product to cart
     */
    public function addToCart(Request $request)
    {
        $request->validate([
            'product_id' => 'required|exists:products,id',
            'quantity' => 'required|integer|min:1'
        ]);

        $product = Product::findOrFail($request->product_id);
        
        // Check stock for tracked products
        if ($product->track_stock && $product->stock < $request->quantity) {
            return response()->json([
                'success' => false,
                'message' => 'Stok tidak mencukupi. Stok tersedia: ' . $product->stock
            ]);
        }

        $cart = Session::get('pos_cart', []);
        $productId = $product->id;

        if (isset($cart[$productId])) {
            // If product already in cart, update quantity
            $newQuantity = $cart[$productId]['quantity'] + $request->quantity;
            
            // Check stock again for updated quantity
            if ($product->track_stock && $product->stock < $newQuantity) {
                return response()->json([
                    'success' => false,
                    'message' => 'Total quantity melebihi stok. Stok tersedia: ' . $product->stock
                ]);
            }
            
            $cart[$productId]['quantity'] = $newQuantity;
            $cart[$productId]['subtotal'] = $cart[$productId]['quantity'] * $cart[$productId]['price'];
        } else {
            // Add new product to cart
            $cart[$productId] = [
                'id' => $product->id,
                'name' => $product->name,
                'sku' => $product->sku,
                'price' => $product->price,
                'quantity' => $request->quantity,
                'subtotal' => $product->price * $request->quantity,
                'unit' => $product->unit,
                'track_stock' => $product->track_stock,
                'available_stock' => $product->stock
            ];
        }

        Session::put('pos_cart', $cart);

        return response()->json([
            'success' => true,
            'message' => 'Produk berhasil ditambahkan ke keranjang',
            'cart' => $cart,
            'cart_count' => count($cart),
            'cart_total' => $this->calculateCartTotal($cart)
        ]);
    }

    /**
     * Update cart item quantity
     */
    public function updateCart(Request $request)
    {
        $request->validate([
            'product_id' => 'required',
            'quantity' => 'required|integer|min:1'
        ]);

        $cart = Session::get('pos_cart', []);
        $productId = $request->product_id;

        if (isset($cart[$productId])) {
            $product = Product::find($productId);
            
            // Check stock for tracked products
            if ($product && $product->track_stock && $product->stock < $request->quantity) {
                return response()->json([
                    'success' => false,
                    'message' => 'Stok tidak mencukupi. Stok tersedia: ' . $product->stock
                ]);
            }

            $cart[$productId]['quantity'] = $request->quantity;
            $cart[$productId]['subtotal'] = $cart[$productId]['quantity'] * $cart[$productId]['price'];
            
            Session::put('pos_cart', $cart);

            return response()->json([
                'success' => true,
                'cart' => $cart,
                'cart_total' => $this->calculateCartTotal($cart)
            ]);
        }

        return response()->json([
            'success' => false,
            'message' => 'Produk tidak ditemukan di keranjang'
        ]);
    }

    /**
     * Remove item from cart
     */
    public function removeFromCart(Request $request)
    {
        $productId = $request->product_id;
        $cart = Session::get('pos_cart', []);

        if (isset($cart[$productId])) {
            unset($cart[$productId]);
            Session::put('pos_cart', $cart);

            return response()->json([
                'success' => true,
                'cart' => $cart,
                'cart_count' => count($cart),
                'cart_total' => $this->calculateCartTotal($cart)
            ]);
        }

        return response()->json([
            'success' => false,
            'message' => 'Produk tidak ditemukan di keranjang'
        ]);
    }

    /**
     * Clear entire cart
     */
    public function clearCart()
    {
        Session::forget('pos_cart');
        
        return response()->json([
            'success' => true,
            'message' => 'Keranjang berhasil dikosongkan'
        ]);
    }

    /**
     * Process checkout
     */
    public function checkout(Request $request)
    {
        $request->validate([
            'customer_name' => 'nullable|string|max:255',
            'customer_phone' => 'nullable|string|max:20',
            'payment_method' => 'required|in:cash,card,qris,transfer',
            'paid_amount' => 'required|numeric|min:0',
            'discount_amount' => 'nullable|numeric|min:0',
            'tax_amount' => 'nullable|numeric|min:0',
            'notes' => 'nullable|string'
        ]);

        $cart = Session::get('pos_cart', []);
        
        if (empty($cart)) {
            return response()->json([
                'success' => false,
                'message' => 'Keranjang kosong'
            ]);
        }

        try {
            DB::beginTransaction();

            // Calculate totals
            $subtotal = $this->calculateCartTotal($cart);
            $discountAmount = $request->discount_amount ?? 0;
            $taxAmount = $request->tax_amount ?? 0;
            $totalAmount = $subtotal - $discountAmount + $taxAmount;

            // Validate payment
            if ($request->paid_amount < $totalAmount) {
                return response()->json([
                    'success' => false,
                    'message' => 'Jumlah pembayaran kurang dari total'
                ]);
            }

            $changeAmount = $request->paid_amount - $totalAmount;

            // Create transaction
            $transaction = Transaction::create([
                'user_id' => auth()->id(),
                'customer_name' => $request->customer_name,
                'customer_phone' => $request->customer_phone,
                'subtotal' => $subtotal,
                'tax_amount' => $taxAmount,
                'discount_amount' => $discountAmount,
                'total_amount' => $totalAmount,
                'paid_amount' => $request->paid_amount,
                'change_amount' => $changeAmount,
                'payment_method' => $request->payment_method,
                'status' => 'completed',
                'notes' => $request->notes,
                'transaction_date' => now()
            ]);

            // Create transaction details and update stock
            foreach ($cart as $item) {
                TransactionDetail::create([
                    'transaction_id' => $transaction->id,
                    'product_id' => $item['id'],
                    'product_name' => $item['name'],
                    'product_sku' => $item['sku'],
                    'unit_price' => $item['price'],
                    'quantity' => $item['quantity'],
                    'discount_per_item' => 0,
                    'subtotal' => $item['subtotal']
                ]);

                // Update product stock
                $product = Product::find($item['id']);
                if ($product && $product->track_stock) {
                    $product->reduceStock($item['quantity']);
                }
            }

            DB::commit();

            // Clear cart
            Session::forget('pos_cart');

            return response()->json([
                'success' => true,
                'message' => 'Transaksi berhasil diproses',
                'transaction_id' => $transaction->id,
                'transaction_code' => $transaction->transaction_code,
                'total_amount' => $totalAmount,
                'paid_amount' => $request->paid_amount,
                'change_amount' => $changeAmount
            ]);

        } catch (\Exception $e) {
            DB::rollBack();
            
            return response()->json([
                'success' => false,
                'message' => 'Terjadi kesalahan saat memproses transaksi: ' . $e->getMessage()
            ]);
        }
    }

    /**
     * Calculate cart total
     */
    private function calculateCartTotal($cart)
    {
        return collect($cart)->sum('subtotal');
    }

    /**
     * Get cart data
     */
    public function getCart()
    {
        $cart = Session::get('pos_cart', []);
        
        return response()->json([
            'cart' => $cart,
            'cart_count' => count($cart),
            'cart_total' => $this->calculateCartTotal($cart)
        ]);
    }
}
