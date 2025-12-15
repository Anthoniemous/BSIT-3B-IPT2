<?php

namespace App\Helpers;

use App\Models\ActivityLog;
use Illuminate\Support\Facades\Auth;

class Logger
{
    public static function log(string $module, string $action, ?string $description = null): void
    {
        ActivityLog::create([
            'user_id' => Auth::id(),
            'role' => Auth::user()->role ?? null,
            'module' => $module,
            'action' => $action,
            'description' => $description,
        ]);
    }
}
