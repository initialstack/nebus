<?php declare(strict_types=1);

namespace App\Repositories;

use Illuminate\Pagination\LengthAwarePaginator;
use App\Models\Organization;

interface OrganizationRepositoryInterface
{
	/**
     * Find an organization by its unique identifier.
     *
     * @param string $id
     * @return Organization|null
     */
    public function findById(string $id): ?Organization;

    /**
     * Retrieve organizations associated with a specific building.
     *
     * @param string $id
     * @return LengthAwarePaginator
     */
    public function getByBuilding(string $id): LengthAwarePaginator;

    /**
     * Retrieve organizations associated with a specific activity.
     *
     * @param string $id
     * @return LengthAwarePaginator
     */
    public function getByActivity(string $id): LengthAwarePaginator;

    /**
     * Retrieve organizations located within a specified geographic bounding box.
     *
     * @param array $data
     * @return LengthAwarePaginator
     */
    public function getByLocation(array $data): LengthAwarePaginator;

    /**
     * Search organizations by activity name or keyword.
     *
     * @param string $query
     * @return LengthAwarePaginator
     */
    public function searchByActivity(string $query): LengthAwarePaginator;

    /**
     * Search organizations by their name.
     *
     * @param string $query
     * @return LengthAwarePaginator
     */
    public function searchByName(string $query): LengthAwarePaginator;
}
