<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Redirect;

class LanguageController extends Controller
{
  public function switchLang($lang)
{
    if (array_key_exists($lang, config('languages'))) {
        session()->put('applocale', $lang);
    }

    return redirect()->back(); // Go back to previous page
}

}
