<?php

namespace ThisIsDevelopment\LaravelFutureFactories;

use Illuminate\Support\ServiceProvider as BaseServiceProvider;

class ServiceProvider extends BaseServiceProvider
{
    public function register(): void
    {
        $this->app->singleton(\Illuminate\Database\Eloquent\Factory::class, ModelFactory::class);
    }
}
