<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     */
    public function __construct()
    {
        $this->middleware('auth'); // Protect home page
    }

    /**
     * Show the Gym homepage.
     */
    public function index()
    {
        return view('home'); // this will load resources/views/home.blade.php
    }
}
