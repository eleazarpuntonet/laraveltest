<?php

namespace FmTod\Quotes;

use Spatie\LaravelPackageTools\Package;
use Spatie\LaravelPackageTools\PackageServiceProvider;

class QuotesServiceProvider extends PackageServiceProvider
{
    public function boot()
    {
        $this->loadMigrationsFrom(__DIR__.'/database/migrations');
        $this->publishes([
            __DIR__.'/js/Pages' => resource_path('js/Pages/quotes'),
        ], 'quotes-views');
        
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
