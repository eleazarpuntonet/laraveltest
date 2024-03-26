<?php

namespace FmTod\Quotes;

use Spatie\LaravelPackageTools\Package;
use Spatie\LaravelPackageTools\PackageServiceProvider;
use Illuminate\Support\Facades\Route;
use FmTod\Quotes\Quotes;
use FmTod\Quotes\FavoritesQuotes;

class QuotesServiceProvider extends PackageServiceProvider
{
    public function boot()
    {
        $this->loadMigrationsFrom(__DIR__.'/database/migrations');

        $this->registerApiRoutes();
        $this->registerWebRoutes();

        $this->publishes([
            __DIR__.'/js/Pages' => resource_path('js/Pages/quotes'),
        ], 'quotes-views');
        
        $this->publishes([
            __DIR__.'/../config/quotes.php' => config_path('quotes.php'),
        ], 'config');
        
    }

    private function registerApiRoutes()
    {
        Route::prefix(config('quotes.api_prefix'))
            ->middleware(config('quotes.api_middleware'))
            ->group(function () {
                Route::get('/quotes', [Quotes::class, 'index']);
                Route::get('/favorite-quotes', [FavoritesQuotes::class, 'index']);
                Route::post('/favorite-quotes', [FavoritesQuotes::class, 'store']);
                Route::delete('/favorite-quotes', [FavoritesQuotes::class, 'destroy']);
            });
    }

    private function registerWebRoutes()
    {
        Route::middleware(config('quotes.web_middleware'))
            ->group(function () {
                Route::get('/quotes', [Quotes::class, 'index']);
                Route::get('/favorite-quotes', [FavoritesQuotes::class, 'index'])->name('favorite-quotes');
                Route::post('/favorite-quotes', [FavoritesQuotes::class, 'store']);
                Route::delete('/favorite-quotes', [FavoritesQuotes::class, 'destroy']); 
            });
    }

    public function configurePackage(Package $package): void
    {
        /*
         * This class is a Package Service Provider
         *
         * More info: https://github.com/spatie/laravel-package-tools
         */
        $package
            ->name('quotes')
            ->hasConfigFile()
            ->hasMigration('create_favorite_quotes_table');
    }
}
