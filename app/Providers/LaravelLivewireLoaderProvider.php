<?php

namespace App\Providers;

use App\Livewire\LoadingIndicator;
use Illuminate\Support\ServiceProvider;
use Livewire\Livewire;

class LaravelLivewireLoaderProvider extends ServiceProvider
{
    /**
     * Register services.
     */
    public function register(): void
    {
        $this->mergeConfigFrom(__DIR__ . '/../../config/laravel-livewire-loader.php', 'laravel-livewire-loader');
    }

    /**
     * Bootstrap services.
     */
    public function boot(): void
    {
        // Load views from the 'resources/views/livewire' directory
        $this->loadViewsFrom(__DIR__ . '/../../resources/views/livewire', 'laravel-livewire-loader');

        // // Publishing configuration and views without specific tags
        // $this->publishes([
        //     __DIR__ . '/../../config/laravel-livewire-loader.php' => config_path('laravel-livewire-loader.php'),
        // ], 'laravel-livewire-loader');


        // $this->publishes([
        //     __DIR__ . '/../../resources/views' => resource_path('views/livewire/loading-indicator'),
        // ],'laravel-livewire-loader-views');

        // Register the Livewire component
        Livewire::component('loading-indicator', LoadingIndicator::class);
    }
}
