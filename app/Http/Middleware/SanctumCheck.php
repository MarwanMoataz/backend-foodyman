<?php

namespace App\Http\Middleware;

use App\Helpers\ResponseError;
use App\Traits\ApiResponse;
use Closure;
use Exception;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;
use Symfony\Component\HttpFoundation\Response;

class SanctumCheck
{
    use ApiResponse;
    /**
     * Handle an incoming request.
     *
     * @param Request $request
     * @param Closure(Request): (\Illuminate\Http\Response|RedirectResponse) $next
     * @return JsonResponse
     * @throws Exception
     */
    public function handle(Request $request, Closure $next)
    {
        if (auth('sanctum')->check()) {
            return $next($request);
        }
        return $this->errorResponse('ERROR_100',  trans('errors.' . ResponseError::ERROR_100, [], request()->lang), Response::HTTP_UNAUTHORIZED);
    }
}
