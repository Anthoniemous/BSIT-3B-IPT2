<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ActivityLogController extends Controller
{
    public function index(Request $request)
    {
        if (session('role') !== 'admin') abort(403);

        $logs = DB::table('activity_logs')
            ->orderByDesc('id')
            ->paginate(25);

        return view('admin_activity_logs', compact('logs'));
    }
}
