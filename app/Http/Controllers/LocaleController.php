<?php

namespace App\Http\Controllers;

use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Session;

class LocaleController extends Controller
{
    /**
     * Switch application locale.
     */
    public function switch(string $locale): RedirectResponse
    {
        if (in_array($locale, ['en', 'ar'])) {
            Session::put('locale', $locale);
        }
        // إعادة توجيه المستخدم للصفحة السابقة التي كان يتصفحها
        return redirect()->back();
    }
}
