<?php

namespace App\View\Composers;

use App\Models\SiteSetting;
use Illuminate\View\View;

class SiteComposer
{
    public function compose(View $view): void
    {
        $settings = SiteSetting::current();

        $view->with('siteSettings', $settings);
    }
}
