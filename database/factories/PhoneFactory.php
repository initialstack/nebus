<?php declare(strict_types=1);

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\Phone;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Phone>
 */
final class PhoneFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var class-string<Phone>
     */
    protected $model = Phone::class;

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'number' => $this->generateFormat8(),
        ];
    }

    /**
     * Generate a phone number in custom format:
     * Examples: 8-888-888 and 8-888-888-88-88
     *
     * @return string
     */
    public function generateFormat2(): string
    {
        return sprintf(
            '2-%03d-%03d',
            $this->faker->numberBetween(100, 999),
            $this->faker->numberBetween(100, 999)
        );
    }

    // Генерация номера формата 8-xxx-xxx-xx-xx
    public function generateFormat8(): string
    {
        return sprintf(
            '8-%03d-%03d-%02d-%02d',
            $this->faker->numberBetween(900, 999),
            $this->faker->numberBetween(100, 999),
            $this->faker->numberBetween(10, 99),
            $this->faker->numberBetween(10, 99)
        );
    }
}