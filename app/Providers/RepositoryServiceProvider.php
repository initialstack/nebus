<?php declare(strict_types=1);

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use App\Repositories\OrganizationRepositoryInterface;
use App\Repositories\OrganizationRepository;

final class RepositoryServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        $this->app->bind(
            abstract: OrganizationRepositoryInterface::class,
            concrete: OrganizationRepository::class
        );
    }
}
