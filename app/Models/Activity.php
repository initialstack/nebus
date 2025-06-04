<?php declare(strict_types=1);

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\Factory;

final class Activity extends Model
{
    use HasFactory, HasUuids;

    /**
     * The database table used by the model.
     *
     * @var string|null
     */
    protected $table = 'activities';

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
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'parent_id',
        'level',
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
     * @return \Illuminate\Database\Eloquent\Factories\Factory<self>
     */
    protected static function newFactory(): Factory
    {
        return \Database\Factories\ActivityFactory::new();
    }

    /**
     * Get the parent activity of this activity.
     *
     * @return BelongsTo<Activity, Activity>
     * @phpstan-return BelongsTo<Activity, Activity>
     */
    public function parent(): BelongsTo
    {
        return $this->belongsTo(
            related: self::class,
            foreignKey: 'parent_id',
            ownerKey: 'id'
        );
    }

    /**
     * Get the child activities of this activity.
     *
     * @return HasMany<Activity, Activity>
     * @phpstan-return HasMany<Activity, Activity>
     */
    public function children(): HasMany
    {
        return $this->hasMany(
            related: self::class,
            foreignKey: 'parent_id',
            localKey: 'id'
        );
    }

    /**
     * Get the organizations associated with this activity.
     *
     * @return BelongsToMany<Organization, \Illuminate\Database\Eloquent\Relations\Pivot>
     * @phpstan-return BelongsToMany<Organization, \Illuminate\Database\Eloquent\Relations\Pivot>
     */
    public function organizations(): BelongsToMany
    {
        return $this->belongsToMany(
            related: Organization::class,
            table: 'activity_organization',
            foreignPivotKey: 'activity_id',
            relatedPivotKey: 'organization_id'
        );
    }
}