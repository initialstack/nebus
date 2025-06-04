<?php declare(strict_types=1);

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Clickbar\Magellan\Data\Geometries\Point;
use Clickbar\Magellan\Database\PostgisFunctions\ST;
use App\Models\Building;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Building>
 */
final class BuildingFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var class-string<Building>
     */
    protected $model = Building::class;

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'address' => $this->faker->address,
            'location' => Point::make(
                x: $this->faker->longitude(-8.6, 1.8),
                y: $this->faker->latitude(49.9, 58.7),
                srid: 4326
            ),
        ];
    }
}
