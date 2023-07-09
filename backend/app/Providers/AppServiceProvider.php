<?php

namespace App\Providers;

use App\Http\Controllers\MailController;
use App\Http\Controllers\SeatController;
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
        $this->app->bind(SeatController::class, function ($app) {
            return new SeatController();
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
