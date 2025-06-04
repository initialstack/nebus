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
        Schema::create(table: 'phones',
            callback: function (Blueprint $table): void {
                $table->comment(comment: 'Номера телефонов');

                $table->uuid(column: 'id')->primary();

                $table->string(column: 'number', length: 20);
                $table->foreignUuid(column: 'organization_id')
                    ->nullable()
                    ->constrained(table: 'organizations')
                    ->onDelete(action: 'cascade');

                $table->timestamps(precision: 6);
            }
        );

        Schema::table(table: 'phones',
            callback: function (Blueprint $table): void {
                $table->unique(columns: ['organization_id', 'number']);

                $table->index(columns: 'organization_id');
                $table->index(columns: 'created_at');
            }
        );
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists(table: 'phones');
    }
};
