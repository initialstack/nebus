<?php declare(strict_types=1);

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Http\Request;
use Clickbar\Magellan\Data\Geometries\Point;

/**
 * @property \App\Models\Building $resource
 */
final class BuildingResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        $point = $this->resource->location;

        $coordinates = null;
        if ($point instanceof Point) {
            $coordinates = [
                'latitude' => $point->getY(),
                'longitude' => $point->getX(),
            ];
        }

        return [
            'id' => $this->resource->id,
            'address' => $this->resource->address,
            'coordinates' => $coordinates,
            'datetime' => [
                'created_at' => $this->resource->created_at->format('Y-m-d H:i:s'),
                'updated_at' => $this->resource->updated_at->format('Y-m-d H:i:s'),
            ],
        ];
    }
}
