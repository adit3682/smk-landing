<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Pagination\Paginator;
use Illuminate\Support\Facades\View;
use App\Models\ProfilSekolah;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        Paginator::defaultView('vendor.pagination.tailwind');

        View::composer('layouts.app', function ($view) {
            $view->with('navProfil', ProfilSekolah::first());
            $view->with('sponsors', \App\Models\Sponsor::orderBy('urutan')->get());
        });
    }
}