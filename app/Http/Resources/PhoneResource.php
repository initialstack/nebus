<?php declare(strict_types=1);

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Http\Request;

/**
 * @property \App\Models\Phone $resource
 */
final class PhoneResource extends JsonResource
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
            'number' => $this->resource->number,
            'datetime' => [
                'created_at' => $this->resource->created_at->format(
                    format: 'Y-m-d H:i:s'
                ),
                'updated_at' => $this->resource->updated_at->format(
                    format: 'Y-m-d H:i:s'
                ),
            ],
        ];
    }
}
