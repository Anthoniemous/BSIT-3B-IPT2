<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Product; // ✅ Import Product model

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

    public function products()
    {
        // ✅ Fetch all products from database (latest first)
        $products = Product::latest()->get();

        return view('products', compact('products'));
    }

    public function singleProduct($id = null)
    {
        $product = \App\Models\Product::find($id);
        return view('single-product', compact('product'));
    }


    public function contact()
    {
        return view('contact');
    }

    public function sendContact(Request $request)
    {
        // For demo purposes
        return back()->with('success', 'Your message has been sent!');
    }
}
