<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Menu;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    /**
     * Show the customer-facing menu page.
     */
    public function index(Request $request)
    {
        $categories = Category::withCount('menus')->get();

        $query = Menu::with('category')->where('is_sold_out', false);

        if ($request->has('category') && $request->category !== 'all') {
            $query->whereHas('category', function ($q) use ($request) {
                $q->where('slug', $request->category);
            });
        }

        if ($request->has('search') && $request->search) {
            $query->where('name', 'like', '%' . $request->search . '%');
        }

        $menus = $query->orderBy('name')->get();

        return view('home', compact('categories', 'menus'));
    }
}
