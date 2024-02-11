<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Log\Logger;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Log;
use JsonException;
use Symfony\Component\HttpFoundation\Response;

class CacheApiResponse
{
    public const API_CACHE_TAG = 'full_page';

    public function handle(Request $request, Closure $next, int $ttl = 604800): Response
    {
        if ($request->isMethod('get') && empty($request->query())) {
            $cacheKey = md5($request->url());
            $cache = Cache::tags([self::API_CACHE_TAG]);

            if ($cache->has($cacheKey)) {
                try {
                    return response()->json(
                        json_decode($cache->get($cacheKey), true, 512, JSON_THROW_ON_ERROR)
                    );
                } catch (JsonException $e) {
                    Log::critical($e->getMessage());

                    return $next($request);
                }
            }

            $response = $next($request);

            $cache->put($cacheKey, $response->getContent(), $ttl);

            return $response;
        }

        return $next($request);
    }
}
