<?php declare(strict_types=1);

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use App\Buses\QueryBusInterface;
use App\Buses\QueryBus;

final class BusServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        $this->app->singleton(
            abstract: QueryBusInterface::class,
            concrete: QueryBus::class
        );
    }
}
