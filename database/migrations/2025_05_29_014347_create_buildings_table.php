<?php declare(strict_types=1);

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create(table: 'buildings',
            callback: function (Blueprint $table): void {
                $table->comment(comment: 'Здания');

                $table->uuid(column: 'id')->primary();

                $table->string(column: 'address', length: 100);
                $table->magellanPoint(column: 'location', srid: 4326);

                $table->timestamps(precision: 6);
            }
        );

        Schema::table(table: 'buildings',
            callback: function (Blueprint $table): void {
                $table->spatialIndex(columns: 'location');
                $table->index(columns: 'created_at');
            }
        );
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists(table: 'buildings');
    }
};
