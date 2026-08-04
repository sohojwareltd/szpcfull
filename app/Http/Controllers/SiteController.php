<?php

namespace App\Http\Controllers;

use Illuminate\View\View;

class SiteController extends Controller
{
    public function home(): View
    {
        return view('home', [
            'seoPage' => 'home',
        ]);
    }

    public function segment(): View
    {
        return view('segment', [
            'seoPage' => 'home',
            'seoTitle' => request()->query('s') === 'jpc'
                ? "JPC-2026 — Junior Programming Contest | SZPC '26"
                : (request()->query('s') === 'ithq'
                    ? "ITHQ-2026 — ICT Talent Hunt | SZPC '26"
                    : "SZPC-2026 — University Programming Contest | SZPC '26"),
        ]);
    }
}
