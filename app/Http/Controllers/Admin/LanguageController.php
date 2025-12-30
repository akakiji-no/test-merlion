<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Cookie;

class LanguageController extends Controller
{
    public function switch(Request $request, string $locale)
    {
        if (in_array($locale, ['en', 'zh_CN'])) {
            Cookie::queue('locale', $locale, 60 * 24 * 365);
        }

        return redirect()->back();
    }
}
