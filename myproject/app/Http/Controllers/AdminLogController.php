<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\ActivityLog;

class AdminLogController extends Controller
{
   public function index()
    {
        $logs = ActivityLog::latest()->paginate(25);
        return view('admin.logs.index', compact('logs'));
        
    }
    

    
}
