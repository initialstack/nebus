<?php declare(strict_types=1);

namespace App\Http\Requests;

use App\Shared\Request;

final class SearchRequest extends Request
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
                'query' => [
                    'bail',
                    'required',
                    'string',
                    'min:1',
                    'max:255',
                    'regex:/^[\pL\pN\s\-]+$/u'
                ],
            ],
            default => []
        };
    }
}
