<?php declare(strict_types=1);

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @property string $id
 * @property string $name
 * @property \Carbon\CarbonImmutable $created_at
 * @property \Carbon\CarbonImmutable $updated_at
 */
final class Organization extends Model
{
    use HasFactory, HasUuids;

    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'organizations';

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
        'name',
        'building_id',
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
            'name' => 'string',
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
        return \Database\Factories\OrganizationFactory::new();
    }

    /**
     * Get the building that this organization belongs to.
     *
     * @return BelongsTo<Building, Organization>
     */
    public function building(): BelongsTo
    {
        return $this->belongsTo(
            related: Building::class,
            foreignKey: 'building_id',
            ownerKey: 'id'
        );
    }

    /**
     * Get the phone numbers associated with this organization.
     *
     * @return HasMany<Phone, Organization>
     */
    public function phones(): HasMany
    {
        return $this->hasMany(
            related: Phone::class,
            foreignKey: 'organization_id',
            localKey: 'id'
        );
    }

    /**
     * Get the activities associated with this organization.
     *
     * @return BelongsToMany<Activity, \Illuminate\Database\Eloquent\Relations\Pivot>
     */
    public function activities(): BelongsToMany
    {
        return $this->belongsToMany(
            related: Activity::class,
            table: 'activity_organization',
            foreignPivotKey: 'organization_id',
            relatedPivotKey: 'activity_id'
        );
    }
}
