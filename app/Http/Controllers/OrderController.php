<?php

namespace App\Http\Controllers;

use App\Models\Menu;
use App\Models\Order;
use App\Models\OrderItem;
use App\Models\Payment;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class OrderController extends Controller
{
    /**
     * Store a new order from the cart.
     */
    public function store(Request $request)
    {
        $request->validate([
            'order_type' => 'required|in:dine-in,takeaway',
            'payment_method' => 'required|in:qris,e-wallet,debit,tunai',
            'cart_items' => 'required|string',
        ]);

        $cartItems = json_decode($request->cart_items, true);

        if (empty($cartItems)) {
            return back()->with('error', 'Keranjang kosong.');
        }

        DB::beginTransaction();

        try {
            $totalAmount = 0;

            // Calculate total
            foreach ($cartItems as $item) {
                $menu = Menu::findOrFail($item['id']);
                $totalAmount += $menu->price * $item['quantity'];
            }

            // Create order
            $order = Order::create([
                'user_id' => Auth::id(),
                'queue_number' => Order::generateQueueNumber(),
                'order_type' => $request->order_type,
                'status' => 'pending',
                'total_amount' => $totalAmount,
                'payment_method' => $request->payment_method,
                'payment_status' => $request->payment_method === 'tunai' ? 'unpaid' : 'unpaid',
            ]);

            // Create order items
            foreach ($cartItems as $item) {
                $menu = Menu::findOrFail($item['id']);
                OrderItem::create([
                    'order_id' => $order->id,
                    'menu_id' => $menu->id,
                    'quantity' => $item['quantity'],
                    'customization_notes' => $item['notes'] ?? null,
                    'subtotal' => $menu->price * $item['quantity'],
                ]);
            }

            // Create payment record
            Payment::create([
                'order_id' => $order->id,
                'amount' => $totalAmount,
                'payment_method' => $request->payment_method,
                'status' => 'pending',
            ]);

            DB::commit();

            return redirect()->route('orders.show', $order)->with('success', 'Pesanan berhasil dibuat! Nomor antrean Anda: ' . $order->queue_number);

        } catch (\Exception $e) {
            DB::rollBack();
            return back()->with('error', 'Gagal membuat pesanan. Silakan coba lagi.');
        }
    }

    /**
     * Show order detail with tracking.
     */
    public function show(Order $order)
    {
        $order->load(['orderItems.menu', 'payment', 'user']);
        return view('orders.show', compact('order'));
    }

    /**
     * Show user's orders.
     */
    public function myOrders()
    {
        $orders = Order::where('user_id', Auth::id())
            ->with(['orderItems.menu'])
            ->latest()
            ->paginate(10);

        return view('orders.my-orders', compact('orders'));
    }

    /**
     * Cart page.
     */
    public function cart()
    {
        return view('cart.index');
    }
}
