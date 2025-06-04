<?php declare(strict_types=1);

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\{Organization, Building, Phone, Activity};

final class OrganizationSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $buildings = Building::all();
        $activities = Activity::all();

        if ($buildings->isEmpty() || $activities->isEmpty()) {
            $this->command->error(
                message: 'Buildings or Activities are missing.'
            );

            return;
        }

        Organization::factory()->count(count: 100)->create()->each(
            callback: function (Organization $organization) use ($buildings, $activities) {
                $organization->building_id = $buildings->random()->id;
                $organization->save();

                $phoneFactory = Phone::factory();

                $phoneCount = rand(min: 1, max: 2);
                $numbers = [];

                if ($phoneCount === 1) {
                    $formatMethods = ['generateFormat2', 'generateFormat8'];
                    $formatMethod = $formatMethods[array_rand(array: $formatMethods)];

                    do {
                        $number = $phoneFactory->$formatMethod();
                    } while (in_array(needle: $number, haystack: $numbers));

                    $numbers[] = $number;
                }

                if ($phoneCount === 2) {
                    do {
                        $num2 = $phoneFactory->generateFormat2();
                    } while (in_array(needle: $num2, haystack: $numbers));

                    $numbers[] = $num2;

                    do {
                        $num8 = $phoneFactory->generateFormat8();
                    } while (in_array(needle: $num8, haystack: $numbers));

                    $numbers[] = $num8;
                }

                foreach ($numbers as $number) {
                    Phone::create(
                        attributes: [
                            'organization_id' => $organization->id,
                            'number' => $number,
                        ]
                    );
                }

                $organization->activities()->attach(
                    $activities->random(rand(min: 1, max: 3))->pluck('id')->toArray()
                );
            }
        );
    }
}
