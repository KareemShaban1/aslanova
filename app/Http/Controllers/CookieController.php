<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cookie;

class CookieController extends Controller
{
    public function acceptCookies()
    {
        // تخزين الكوكي لمدة سنة (365 يوم)
        Cookie::queue('cookie_consent', 'accepted', 60 * 24 * 365);
        return response()->json(['message' => 'Cookie consent saved']);
    }

    // التحقق من وجود موافقة
    public function checkConsent()
    {
        $consent = Cookie::get('cookie_consent');

        if ($consent === 'accepted') {
            return response()->json(['status' => 'accepted']);
        }

        return response()->json(['status' => 'not accepted']);
    }
}
