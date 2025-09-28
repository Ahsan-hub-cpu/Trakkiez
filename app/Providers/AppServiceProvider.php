<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use App\Models\Category;

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
       view()->composer('*', function ($view) {

            if (str_starts_with($view->getName(), 'admin.')) {
                return;
            }

            $categories = Category::with('subcategories')->orderBy('name')->get();
            $view->with('categories', $categories);
        });
    }
}
