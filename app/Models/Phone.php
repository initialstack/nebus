<?php declare(strict_types=1);

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @property string $id
 * @property string $number
 * @property string $organization_id
 * @property \Carbon\CarbonImmutable $created_at
 * @property \Carbon\CarbonImmutable $updated_at
 */
final class Phone extends Model
{
    use HasFactory, HasUuids;

    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'phones';

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
        'number',
        'organization_id',
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
            'number' => 'string',
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
        return \Database\Factories\PhoneFactory::new();
    }

    /**
     * Get the organization that this phone number belongs to.
     *
     * @return BelongsTo<Organization, Phone>
     */
    public function organization(): BelongsTo
    {
        return $this->belongsTo(
            related: Organization::class,
            foreignKey: 'organization_id',
            ownerKey: 'id'
        );
    }
}
