<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Product; // Make sure this model exists

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     */
    public function __construct()
    {
        // Remove auth middleware if you want guests to see homepage
        // $this->middleware('auth'); 
    }

    /** 
     * Show the Gym homepage.
     */
    public function index()
    {
        // Fetch all products from the database
        $dynamicProducts = Product::all(); // or add ->latest() if you want newest first

        // Pass products to the home view
        return view('home', compact('dynamicProducts'));
    }
}
