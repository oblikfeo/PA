<?php

namespace App\Providers;

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
        View::prependNamespace('platform', resource_path('views/vendor/platform'));

        // Только иконки для кнопок «Просмотреть» и «Редактировать» в CRUD (ключ с точкой для addLines)
        $this->app['translator']->addLines([
            '*.View' => ' ',
            '*.Edit' => ' ',
        ], 'ru');
    }
}
