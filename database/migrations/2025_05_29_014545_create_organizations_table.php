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
        Schema::create(table: 'organizations',
            callback: function (Blueprint $table): void {
                $table->comment(comment: 'Организации');

                $table->uuid(column: 'id')->primary();

                $table->string(column: 'name', length: 50);
                $table->foreignUuid(column: 'building_id')
                    ->nullable()
                    ->constrained(table: 'buildings')
                    ->onDelete(action: 'cascade');

                $table->timestamps(precision: 6);
            }
        );

        Schema::table(table: 'organizations',
            callback: function (Blueprint $table): void {
                $table->index(columns: 'building_id');
                $table->index(columns: 'name');
                $table->index(columns: 'created_at');
            }
        );
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists(table: 'organizations');
    }
};
