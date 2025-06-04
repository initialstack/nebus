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
                'created_at' => $this->resource->created_at->format(
                    format: 'Y-m-d H:i:s'
                ),
                'updated_at' => $this->resource->updated_at->format(
                    format: 'Y-m-d H:i:s'
                ),
            ],
            'activities' => ActivityResource::collection(
                resource: $this->whenLoaded(relationship: 'activities')
            ),
            'building' => new BuildingResource(
                resource: $this->whenLoaded(relationship: 'building')
            ),
            'phones' => PhoneResource::collection(
                resource: $this->whenLoaded(relationship: 'phones')
            ),
        ];
    }
}
