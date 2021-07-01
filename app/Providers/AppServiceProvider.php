<?php

namespace App\Providers;

use App\Models\Offer;
use App\Repositories\OfferRepository;
use App\Services\CartService;
use App\Services\OfferService;
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
        $this->app->singleton(CartService::class, function($app) {
            return new CartService(new OfferService(new OfferRepository(new Offer())));
        });
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
