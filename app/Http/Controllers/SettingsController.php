<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class SettingsController extends Controller
{

    public function changeLanguage($language)
    {
        if ($language === 'en' || $language === 'ru') {
            return redirect()->back()->withCookie(cookie()->forever('language', $language));
        }

        // Redirect to the page the user was on
        return redirect()->back();
    }
}
