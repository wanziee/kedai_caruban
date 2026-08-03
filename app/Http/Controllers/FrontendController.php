<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\MenuCategory;
use App\Models\MenuItem;

class FrontendController extends Controller
{
    public function home()
    {
        $categories = MenuCategory::all();
        $menuItems = MenuItem::with('category')->get();
        return view('frontend.home', compact('categories', 'menuItems'));
    }

    public function company()
    {
        return view('frontend.company');
    }

    public function order()
    {
        return view('frontend.order');
    }

    public function search(Request $request)
    {
        $query = $request->input('q', '');
        $menuItems = [];
        $categories = MenuCategory::all();

        if ($query) {
            $menuItems = MenuItem::where('is_available', true)
                ->where(function ($q) use ($query) {
                    $q->where('name', 'like', "%{$query}%")
                        ->orWhere('description', 'like', "%{$query}%");
                })
                ->with('category')
                ->get();
        }

        return view('frontend.search', compact('query', 'menuItems', 'categories'));
    }
}

