<?php

namespace App\Providers;

use App\Core\StatusCodeObject;
use Illuminate\Auth\Notifications\ResetPassword;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
        $this->app->singleton('StatusCodeObjectClass', function ($app) {
            return new StatusCodeObject;
        });
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        //
        require __DIR__ . '/../Helpers/Helper.php';
        
        ResetPassword::createUrlUsing(function (object $notifiable, string $token) {
            return config('app.frontend_url')."/password-reset/$token?email={$notifiable->getEmailForPasswordReset()}";
        });
    }
}
