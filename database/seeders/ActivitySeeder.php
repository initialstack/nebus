<?php declare(strict_types=1);

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Activity;

final class ActivitySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $roots = Activity::factory()->count(count: 10)->create(
            attributes: ['parent_id' => null]
        );

        $roots->each(function (Activity $root): void {
            $children = Activity::factory()->count(
                count: rand(min: 1, max: 3)
            )->create(
                attributes: ['parent_id' => $root->id]
            );

            $children->each(
                callback: function (Activity $child): void {
                    Activity::factory()->count(
                        count: rand(min: 1, max: 2)
                    )->create(
                        attributes: ['parent_id' => $child->id]
                    );
                }
            );
        });
    }
}
