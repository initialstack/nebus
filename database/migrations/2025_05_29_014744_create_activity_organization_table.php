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
        Schema::create(table: 'activity_organization',
            callback: function (Blueprint $table): void {
                $table->comment(comment: 'Деятельности и организации');

                $table->foreignUuid(column: 'organization_id')
                    ->nullable()
                    ->constrained(table: 'organizations')
                    ->onDelete(action: 'cascade');

                $table->foreignUuid(column: 'activity_id')
                    ->nullable()
                    ->constrained(table: 'activities')
                    ->onDelete(action: 'cascade');
            }
        );

        Schema::table(table: 'activity_organization',
            callback: function (Blueprint $table): void {
                $table->unique(columns: ['organization_id', 'activity_id']);

                $table->index(columns: 'organization_id');
                $table->index(columns: 'activity_id');
            }
        );
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists(table: 'activity_organization');
    }
};
