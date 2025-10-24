<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Product;

class AdminController extends Controller
{
    public function dashboard()
    {
        $products = Product::all(); 
        return view('admin.dashboard', compact('products'));
    }
}
