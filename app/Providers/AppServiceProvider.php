<?php

namespace App\Providers;


use App\Models\Menu;
use Illuminate\Support\Facades\View;
use Illuminate\Support\ServiceProvider;

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
        View::composer('layouts.sidebar', function ($view) {
            if (!auth()->check()) return;
            $role = auth()->user()->role->slug;
            $menus = Menu::where('role_slug', $role)
                ->where('is_active', 1)
                ->orderBy('sort_order')
                ->get();

            $view->with('menus', $menus);
        });
        View::composer(
            'public.reviews._reviews_section',
            \App\Http\View\Composers\ReviewComposer::class
        );
    }
}
