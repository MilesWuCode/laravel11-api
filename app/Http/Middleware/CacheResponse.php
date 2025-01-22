<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;
use Symfony\Component\HttpFoundation\Response;

class CacheResponse
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next, int $minutes = 5): Response
    {
        if (app()->environment('local')) {
            return $next($request);
        }

        if ($request->method() !== 'GET') {
            return $next($request);
        }

        // 根據請求 URL 或其他參數生成緩存鍵
        $cacheKey = $this->generateCacheKey($request);

        // 如果緩存中已存在響應數據，直接返回
        if (Cache::has($cacheKey)) {
            return response(Cache::get($cacheKey));
        }

        // 繼續處理請求
        $response = $next($request);

        // 將響應數據存入緩存
        if ($response->isSuccessful()) {
            Cache::put($cacheKey, $response->getContent(), now()->addMinutes($minutes));
        }

        return $response;
    }

    /**
     * Generate a unique cache key for the request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return string
     */
    protected function generateCacheKey($request)
    {
        return 'response_'.md5($request->fullUrl());
    }
}
