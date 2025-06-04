<?php declare(strict_types=1);

namespace App\Http\Collections;

use App\Http\Resources\OrganizationResource;
use App\Shared\Collection;

final class PaginationCollection extends Collection
{
    /**
     * The resource class to be used for transforming each item in the collection.
     *
     * @var string
     */
    public $collects = OrganizationResource::class;
}
