<?php
namespace App\Providers;

use Illuminate\Support\Facades\View; // Yeh line add karein
use Illuminate\Support\ServiceProvider;
// Yeh line add karein

class AppServiceProvider extends ServiceProvider
{
    public function register(): void
    {}

    public function boot()
    {
        // Ye code ensure karega ke 'siteSettings' variable har sidebar ko mile
        View::composer('includes.sidebar', function ($view) {
            try {
                $settings = \App\Models\Setting::first();
                $view->with('siteSettings', $settings);
            } catch (\Exception $e) {
                $view->with('siteSettings', null);
            }
        });
    }
}
