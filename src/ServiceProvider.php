<?php

namespace ThisIsDevelopment\LaravelFutureFactories;

use Faker\Generator as FakerGenerator;
use Illuminate\Support\ServiceProvider as BaseServiceProvider;

class ServiceProvider extends BaseServiceProvider
{
    public function register(): void
    {
        $this->app->singleton(\Illuminate\Database\Eloquent\Factory::class, function ($app) {
            return ModelFactory::construct(
                $app->make(FakerGenerator::class), $this->app->databasePath('factories')
            );
        });
    }
}
