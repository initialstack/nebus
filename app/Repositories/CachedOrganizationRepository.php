<?php declare(strict_types=1);

namespace App\Repositories;

use Illuminate\Support\Facades\Cache;
use Illuminate\Pagination\LengthAwarePaginator;
use App\Models\Organization;

final class CachedOrganizationRepository implements OrganizationRepositoryInterface
{
    /**
     * Cache time-to-live in seconds.
     *
     * This constant defines how long cached organization query results are stored.
     * Currently set to 900 seconds (15 minutes).
     */
    private const CACHE_TTL_SECONDS = 900;

    /**
     * Constructs a new CachedOrganizationRepository instance.
     * 
     * @param OrganizationRepositoryInterface $organization
     */
    public function __construct(
        private OrganizationRepositoryInterface $organization
    ) {}

    /**
     * Generates a cache key based on method name, page number, and parameters.
     *
     * @param string $method
     * @param array<string, mixed> $params
     * 
     * @return string
     */
    private function makeCacheKey(string $method, array $params = []): string
    {
        $page = request()->query(key: 'page', default: 1);
        $key = 'organization:' . $method . ':page:' . $page;

        if ($params !== []) {
            $key .= ':' . md5(string: json_encode(value: $params));
        }

        return $key;
    }

    /**
     * Find an organization by its ID.
     *
     * This method does not cache the result.
     *
     * @param string $id
     * @return Organization|null
     */
    public function findById(string $id): ?Organization
    {
        return $this->organization->findById(id: $id);
    }

    /**
     * Get organizations by building ID with caching.
     *
     * @param string $id
     * @return LengthAwarePaginator
     */
    public function getByBuilding(string $id): LengthAwarePaginator
    {
        $cacheKey = $this->makeCacheKey(
            method: 'getByBuilding',
            params: ['buildingId' => $id]
        );

        return Cache::remember(
            key: $cacheKey,
            ttl: self::CACHE_TTL_SECONDS,
            callback: fn () => $this->organization->getByBuilding(id: $id)
        );
    }

    /**
     * Get organizations by activity ID with caching.
     *
     * @param string $id
     * @return LengthAwarePaginator
     */
    public function getByActivity(string $id): LengthAwarePaginator
    {
        $cacheKey = $this->makeCacheKey(
            method: 'getByActivity',
            params: ['activityId' => $id]
        );

        return Cache::remember(
            key: $cacheKey,
            ttl: self::CACHE_TTL_SECONDS,
            callback: fn () => $this->organization->getByActivity(id: $id)
        );
    }

    /**
     * Get organizations by geographic location with caching.
     *
     * @param array<string, mixed> $data
     * @return LengthAwarePaginator
     */
    public function getByLocation(array $data): LengthAwarePaginator
    {
        $cacheKey = $this->makeCacheKey(
            method: 'getByLocation',
            params: $data
        );

        return Cache::remember(
            key: $cacheKey,
            ttl: self::CACHE_TTL_SECONDS,
            callback: fn () => $this->organization->getByLocation(data: $data)
        );
    }

    /**
     * Search organizations by activity with caching.
     *
     * @param string $query
     * @return LengthAwarePaginator
     */
    public function searchByActivity(string $query): LengthAwarePaginator
    {
        $cacheKey = $this->makeCacheKey(
            method: 'searchByActivity',
            params: ['activity' => $query]
        );

        return Cache::remember(
            key: $cacheKey,
            ttl: self::CACHE_TTL_SECONDS,
            callback: fn () => $this->organization->searchByActivity(query: $query)
        );
    }

    /**
     * Search organizations by name with caching.
     *
     * @param string $query
     * @return LengthAwarePaginator
     */
    public function searchByName(string $query): LengthAwarePaginator
    {
        $cacheKey = $this->makeCacheKey(
            method: 'searchByName',
            params: ['name' => $query]
        );

        return Cache::remember(
            key: $cacheKey,
            ttl: self::CACHE_TTL_SECONDS,
            callback: fn () => $this->organization->searchByName(query: $query)
        );
    }
}
