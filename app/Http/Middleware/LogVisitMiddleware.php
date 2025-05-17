<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class LogVisitMiddleware
{
    public function handle(Request $request, Closure $next)
    {
        $url = $request->fullUrl();
        $path = $request->path(); // contoh: "admin", "storage/thumbnails/image.jpg"

        // Jangan log visit untuk request ke /storage/thumbnails
        if (str_starts_with($path, 'storage/thumbnails')) {
            return $next($request);
        }

        // Jangan log visit untuk halaman admin
        if (str_starts_with($path, 'admin')) {
            return $next($request);
        }

        $ip = $request->ip();
        $userAgent = $request->userAgent();

        $recentVisit = DB::table('visits')
            ->where('ip_address', $ip)
            ->where('url', $url)
            ->where('visited_at', '>=', Carbon::now()->subMinutes(6))
            ->exists();

        if (!$recentVisit) {
            DB::table('visits')->insert([
                'ip_address' => $ip,
                'url' => $url,
                'user_agent' => $userAgent,
                'visited_at' => now(),
            ]);
        }

        return $next($request);
    }
}
