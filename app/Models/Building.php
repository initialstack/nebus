<?php declare(strict_types=1);

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Clickbar\Magellan\Data\Geometries\Point;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @property string $id
 * @property string $address
 * @property \Clickbar\Magellan\Data\Geometries\Point|null $location
 * @property \Carbon\CarbonImmutable $created_at
 * @property \Carbon\CarbonImmutable $updated_at
 */
final class Building extends Model
{
    use HasFactory, HasUuids;

    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'buildings';

    /**
     * The "type" of the primary key ID.
     *
     * @var string
     */
    protected $keyType = 'string';

    /**
     * Indicates if the IDs are auto-incrementing.
     *
     * @var bool
     */
    public $incrementing = false;

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'address',
        'location',
    ];

    /**
     * Get the attributes that should be cast to native types.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'id' => 'string',
            'address' => 'string',
            'location' => Point::class,
            'created_at' => 'immutable_datetime',
            'updated_at' => 'immutable_datetime',
        ];
    }

    /**
     * Create a new factory instance for the model.
     *
     * @return Factory
     */
    protected static function newFactory(): Factory
    {
        return \Database\Factories\BuildingFactory::new();
    }

    /**
     * Get the organizations associated with the building.
     *
     * @return HasMany<Organization, Building>
     */
    public function organizations(): HasMany
    {
        return $this->hasMany(
            related: Organization::class,
            foreignKey: 'building_id',
            localKey: 'id'
        );
    }
}
