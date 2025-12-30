<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class CheckPermission
{
    public function handle(Request $request, Closure $next, string ...$permissions): Response
    {
        $user = auth()->user();

        if (! $user) {
            return response()->view('errors.403', [], 403);
        }

        // 如果用户是 admin 角色，允许所有操作
        if ($user->hasRole('admin')) {
            return $next($request);
        }

        // 检查是否有任意一个权限
        if (! empty($permissions) && ! $user->hasAnyPermission($permissions)) {
            return response()->view('errors.403', [], 403);
        }

        return $next($request);
    }
}
