<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class HomeController extends Controller
{
    /**
     * Show the homepage view.
     */
    public function index()
    {
        return view('home'); // Make sure resources/views/home.blade.php exists
    }
}
