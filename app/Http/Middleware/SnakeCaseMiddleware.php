<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Symfony\Component\HttpFoundation\Response;

class SnakeCaseMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        $response =  $next($request);

        $content = json_decode($response->getContent(), true, 512, JSON_THROW_ON_ERROR);

        $withSnakeKeys = $this->convert($content);

        $response->setContent(json_encode($withSnakeKeys, JSON_PRETTY_PRINT|JSON_THROW_ON_ERROR));

        return $response;
    }

    private function convert(array $data): array
    {
        $converted = [];

        foreach ($data as $key => $value) {
            if(is_array($value)) {
                $converted[Str::snake($key)] = $this->convert($value);

                continue;
            }

            $converted[Str::snake($key)] = $value;
        }

        return $converted;
    }
}
