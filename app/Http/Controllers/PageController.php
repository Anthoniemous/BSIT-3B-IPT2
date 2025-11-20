<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Product;

class PageController extends Controller
{
    public function home()
    {
        return view('home');
    }

    public function about()
    {
        return view('about');
    }

    public function contact()
    {
        return view('contact');
    }

    public function sendContact(Request $request)
    {
        // your contact form logic here
    }

    // ⭐ PUBLIC PRODUCTS PAGE (USER SIDE)
    public function products(Request $request)
    {
        $sort = $request->query('sort');

        $query = Product::query();

        // ⭐ Sorting Options
        if ($sort === 'name_asc') {
            $query->orderBy('name', 'asc');
        } elseif ($sort === 'name_desc') {
            $query->orderBy('name', 'desc');
        } elseif ($sort === 'price_low_high') {
            $query->orderBy('price', 'asc');
        } elseif ($sort === 'price_high_low') {
            $query->orderBy('price', 'desc');
        }

        $products = $query->get();

        return view('products', compact('products'));
    }

    public function singleProduct($id)
    {
        $product = Product::findOrFail($id);
        return view('single-product', compact('product'));
    }
}
