<?php

namespace App\Providers;

use App\Http\Controllers\MailController;
use App\Models\Seat;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        $this->app->bind(MailController::class, function ($app) {
            return new MailController();
        });
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        date_default_timezone_set('Europe/Budapest');
        Schema::defaultStringLength(191);
    }
}
