<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class LogActivity
{
    public function handle(Request $request, Closure $next)
    {
        $response = $next($request);

        // Skip assets
        $path = $request->path();
        if (
            str_starts_with($path, 'css') ||
            str_starts_with($path, 'js') ||
            str_starts_with($path, 'img') ||
            str_starts_with($path, 'storage') ||
            str_starts_with($path, 'vendor') ||
            str_starts_with($path, 'build')
        ) {
            return $response;
        }

        // Identify actor
        $actorType = 'guest';
        $actorId = null;

        // admin session (based on your AdminController)
        if (session('role') === 'admin' && session('admin_id')) {
            $actorType = 'admin';
            $actorId = (int) session('admin_id');
        }
        // customer guard
        elseif (Auth::guard('customer')->check()) {
            $actorType = 'customer';
            $actorId = (int) Auth::guard('customer')->id();
        }

        // Decide module based on route name or url
        $routeName = optional($request->route())->getName();
        $module = $this->guessModule($routeName, $request->path());

        // Action: visit for GET, otherwise use method
        $action = $request->isMethod('get') ? 'visit' : strtolower($request->method());

        // Payload (sanitize passwords)
        $payload = $request->all();
        foreach (['password', 'password_confirmation'] as $k) {
            if (isset($payload[$k])) $payload[$k] = '[HIDDEN]';
        }

        DB::table('activity_logs')->insert([
            'actor_type' => $actorType,
            'actor_id' => $actorId,
            'module' => $module,
            'action' => $action,
            'description' => $this->makeDescription($routeName, $request),
            'method' => $request->method(),
            'url' => $request->fullUrl(),
            'route_name' => $routeName,
            'ip_address' => $request->ip(),
            'user_agent' => substr((string) $request->userAgent(), 0, 1000),
            'payload' => json_encode($payload, JSON_UNESCAPED_UNICODE),
            'created_at' => now(),
        ]);

        return $response;
    }

    private function guessModule(?string $routeName, string $path): string
    {
        $r = $routeName ?? '';

        if (str_contains($r, 'admin.dashboard') || str_contains($path, 'admin/dashboard')) return 'Dashboard';
        if (str_contains($r, 'admin.orders') || str_contains($path, 'admin/orders')) return 'Orders';
        if (str_contains($r, 'admin.products') || str_contains($path, 'admin/products')) return 'Products';
        if (str_contains($r, 'product.')) return 'Products';
        if (str_contains($r, 'login') || str_contains($r, 'logout') || str_contains($path, 'login')) return 'Auth';
        if (str_contains($r, 'checkout') || str_contains($path, 'checkout')) return 'Checkout';

        return 'General';
    }

    private function makeDescription(?string $routeName, Request $request): string
    {
        $r = $routeName ?? 'no-route-name';
        return "{$request->method()} {$r}";
    }
}
