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
        $menuItems = MenuItem::with('category')->where('is_available', true)->get();
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
}
