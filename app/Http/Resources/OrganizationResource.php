<?php declare(strict_types=1);

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Http\Request;

/**
 * @property \App\Models\Organization $resource
 */
final class OrganizationResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->resource->id,
            'name' => $this->resource->name,
            'datetime' => [
                'created_at' => $this->resource->created_at->format('Y-m-d H:i:s'),
                'updated_at' => $this->resource->updated_at->format('Y-m-d H:i:s'),
            ],
            'building' => new BuildingResource(
                resource: $this->whenLoaded('building')
            ),
            'phones' => PhoneResource::collection(
                resource: $this->whenLoaded('phones')
            ),
        ];
    }
}
