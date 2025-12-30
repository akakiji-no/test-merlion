<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\App;

class SetLocale
{
    public function handle(Request $request, Closure $next)
    {
        $locale = $request->cookie('locale', config('app.locale', 'en'));

        if (in_array($locale, ['en', 'zh_CN'])) {
            App::setLocale($locale);
            config(['app.locale' => $locale]);

            // 加载 Merlion 翻译文件
            $langPath = resource_path('lang/vendor/merlion');
            if (is_dir($langPath)) {
                app('translator')->addNamespace('merlion', $langPath);
            }
        }

        return $next($request);
    }
}
