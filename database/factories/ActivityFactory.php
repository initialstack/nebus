<?php declare(strict_types=1);

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Database\Eloquent\Builder;
use App\Models\Activity;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Activity>
 */
final class ActivityFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var class-string<Activity>
     */
    protected $model = Activity::class;

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        if ($this->shouldCreateRoot() || Activity::count() === 0) {
            return $this->definitionRoot();
        }

        $parent = $this->findSuitableParent();

        if (!$parent) {
            $parent = $this->createRootParent();
        }

        return $this->definitionChild(parentId: $parent->id);
    }

    /**
     * Determine whether to create a root activity.
     *
     * @return bool
     */
    private function shouldCreateRoot(): bool
    {
        return $this->faker->boolean(chanceOfGettingTrue: 30);
    }

    /**
     * Get the definition for a root activity (no parent).
     *
     * @return array<string, mixed>
     */
    private function definitionRoot(): array
    {
        return [
            'name' => $this->generateName(),
            'parent_id' => null,
        ];
    }

    /**
     * Get the definition for a child activity with a given parent ID.
     *
     * @param string $parentId
     * @return array<string, mixed>
     */
    private function definitionChild(string $parentId): array
    {
        return [
            'name' => $this->generateName(),
            'parent_id' => $parentId,
        ];
    }

    /**
     * Find a suitable parent activity for the new child.
     *
     * Searches for activities with no parent or whose parent has no parent,
     * effectively limiting depth to 3 levels.
     *
     * @return Activity|null
     */
    private function findSuitableParent(): ?Activity
    {
        $activity = Activity::whereNull(
            columns: 'parent_id'
        )->orWhereHas(
            relation: 'parent',
            callback: function (Builder $parentQuery): Builder {
                return $parentQuery->whereHas(
                    relation: 'parent',
                    callback: function (Builder $grandParentQuery): Builder {
                        return $grandParentQuery->whereNull(
                            columns: 'parent_id'
                        );
                    }
                );
            }
        );

        return $activity->inRandomOrder()->first();
    }

    /**
     * Create a root parent activity.
     *
     * @return Activity
     */
    private function createRootParent(): Activity
    {
        return Activity::factory()->create(
            attributes: ['parent_id' => null]
        );
    }

    /**
     * Generate a unique, capitalized name for the activity.
     *
     * @return string
     */
    private function generateName(): string
    {
        return mb_ucfirst(
            string: $this->faker->unique()->words(
                nb: mt_rand(min: 1, max: 3),
                asText: true
            )
        );
    }
}
