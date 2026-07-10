<?php

namespace App\Http\Controllers;

use App\Models\Order;
use Illuminate\Http\Request;

class StaffController extends Controller
{
    /**
     * Kasir: Show all active orders.
     */
    public function kasirOrders()
    {
        $orders = Order::with(['user', 'orderItems.menu'])
            ->whereIn('status', ['pending', 'preparing', 'ready'])
            ->latest()
            ->get();

        return view('staff.kasir-orders', compact('orders'));
    }

    /**
     * Kasir: Verify cash payment.
     */
    public function verifyPayment(Order $order)
    {
        $order->update(['payment_status' => 'paid']);

        if ($order->payment) {
            $order->payment->update(['status' => 'success']);
        }

        return back()->with('success', 'Pembayaran untuk pesanan ' . $order->queue_number . ' berhasil diverifikasi.');
    }

    /**
     * Kasir: Update order status.
     */
    public function updateOrderStatus(Request $request, Order $order)
    {
        $request->validate([
            'status' => 'required|in:pending,preparing,ready,completed',
        ]);

        $order->update(['status' => $request->status]);

        $statusLabels = [
            'preparing' => 'dikirim ke dapur',
            'ready' => 'siap diambil',
            'completed' => 'selesai',
        ];

        return back()->with('success', 'Pesanan ' . $order->queue_number . ' telah ' . ($statusLabels[$request->status] ?? $request->status) . '.');
    }

    /**
     * Barista: Show kitchen orders.
     */
    public function baristaOrders()
    {
        $activeOrders = Order::with(['orderItems.menu'])
            ->where('status', 'preparing')
            ->orderBy('created_at', 'asc')
            ->get();

        $readyOrders = Order::with(['orderItems.menu'])
            ->where('status', 'ready')
            ->latest()
            ->get();

        return view('staff.barista-orders', compact('activeOrders', 'readyOrders'));
    }

    /**
     * Barista: Update order status.
     */
    public function baristaUpdateStatus(Request $request, Order $order)
    {
        $request->validate([
            'status' => 'required|in:ready,completed',
        ]);

        $order->update(['status' => $request->status]);

        return back()->with('success', 'Pesanan ' . $order->queue_number . ' telah ditandai siap diambil.');
    }
}
