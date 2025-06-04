<?php declare(strict_types=1);

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

/**
 * @property \App\Models\Building $resource
 */
final class ActivityResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  Request  $request
     * @return array<string, mixed>
     */
    public function toArray($request): array
    {
        return [
            'id' => $this->id,
            'name' => $this->name,
            'datetime' => [
                'created_at' => $this->resource->created_at->format(
                    format: 'Y-m-d H:i:s'
                ),
                'updated_at' => $this->resource->updated_at->format(
                    format: 'Y-m-d H:i:s'
                ),
            ],
            'parent' => $this->when(
                condition: $this->parent,
                value: function () {
                    return [
                        'id' => $this->parent->id,
                        'name' => $this->parent->name,
                        'datetime' => [
                            'created_at' => $this->parent->created_at->format(
                                format: 'Y-m-d H:i:s'
                            ),
                            'updated_at' => $this->parent->updated_at->format(
                                format: 'Y-m-d H:i:s'
                            ),
                        ],
                    ];
                }
            )
        ];
    }
}