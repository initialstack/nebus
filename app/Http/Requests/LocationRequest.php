<?php declare(strict_types=1);

namespace App\Http\Requests;

use App\Shared\Request;

/**
 * @property float $min_lng
 * @property float $min_lat
 * @property float $max_lng
 * @property float $max_lat
 */
final class LocationRequest extends Request
{
    /**
     * Returns validation rules depending on HTTP method.
     * 
     * @return array<string, list<string>>
     */
    public function rules(): array
    {
        return match ($this->method()) {
            'GET' => [
                'min_lng' => [
                    'bail', 'required', 'numeric', 'between:-180,180'
                ],
                'min_lat' => [
                    'bail', 'required', 'numeric', 'between:-90,90'
                ],
                'max_lng' => [
                    'bail', 'required', 'numeric', 'between:-180,180'
                ],
                'max_lat' => [
                    'bail', 'required', 'numeric', 'between:-90,90'
                ],
            ],
            default => []
        };
    }
}
