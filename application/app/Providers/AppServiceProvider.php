<?php

namespace App\Providers;

use App\Contracts\StreamContract;
use App\Contracts\TokenContract;
use App\Services\Stream\StreamServices;
use App\Services\Token\TokenServices;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->bind(StreamContract::class,StreamServices::class);
        $this->app->bind(TokenContract::class,TokenServices::class);
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        //
    }
}
