<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\Menu;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class DashboardController extends Controller
{
    /**
     * Show the role-based dashboard.
     */
    public function index()
    {
        $user = Auth::user();

        return match ($user->role) {
            'admin' => $this->adminDashboard(),
            'kasir' => $this->kasirDashboard(),
            'barista' => $this->baristaDashboard(),
            default => redirect()->route('home'),
        };
    }

    /**
     * Admin dashboard with analytics overview.
     */
    private function adminDashboard()
    {
        $today = now()->toDateString();

        $stats = [
            'total_revenue_today' => Order::whereDate('created_at', $today)
                ->where('payment_status', 'paid')
                ->sum('total_amount'),
            'total_orders_today' => Order::whereDate('created_at', $today)->count(),
            'pending_orders' => Order::whereIn('status', ['pending', 'preparing'])->count(),
            'total_menus' => Menu::count(),
            'total_staff' => User::whereIn('role', ['kasir', 'barista'])->count(),
            'sold_out_menus' => Menu::where('is_sold_out', true)->count(),
        ];

        // Revenue last 7 days for chart
        $revenueChart = Order::where('payment_status', 'paid')
            ->where('created_at', '>=', now()->subDays(7))
            ->select(DB::raw('DATE(created_at) as date'), DB::raw('SUM(total_amount) as total'))
            ->groupBy('date')
            ->orderBy('date')
            ->get();

        // Top selling menus
        $topMenus = DB::table('order_items')
            ->join('menus', 'order_items.menu_id', '=', 'menus.id')
            ->join('orders', 'order_items.order_id', '=', 'orders.id')
            ->where('orders.payment_status', 'paid')
            ->select('menus.name', DB::raw('SUM(order_items.quantity) as total_sold'))
            ->groupBy('menus.id', 'menus.name')
            ->orderByDesc('total_sold')
            ->limit(5)
            ->get();

        // Recent orders
        $recentOrders = Order::with(['user', 'orderItems.menu'])
            ->latest()
            ->limit(10)
            ->get();

        return view('dashboard.admin', compact('stats', 'revenueChart', 'topMenus', 'recentOrders'));
    }

    /**
     * Kasir dashboard with incoming orders.
     */
    private function kasirDashboard()
    {
        $pendingOrders = Order::with(['user', 'orderItems.menu'])
            ->whereIn('status', ['pending', 'preparing', 'ready'])
            ->latest()
            ->get();

        $todayCompleted = Order::whereDate('created_at', now()->toDateString())
            ->where('status', 'completed')
            ->count();

        return view('dashboard.kasir', compact('pendingOrders', 'todayCompleted'));
    }

    /**
     * Barista dashboard with kitchen orders.
     */
    private function baristaDashboard()
    {
        $activeOrders = Order::with(['orderItems.menu'])
            ->whereIn('status', ['preparing'])
            ->orderBy('created_at', 'asc')
            ->get();

        $readyOrders = Order::with(['orderItems.menu'])
            ->where('status', 'ready')
            ->latest()
            ->get();

        return view('dashboard.barista', compact('activeOrders', 'readyOrders'));
    }
}
