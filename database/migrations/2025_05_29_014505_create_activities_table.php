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
        Schema::create(table: 'activities',
            callback: function (Blueprint $table): void {
                $table->comment(comment: 'Деятельности');

                $table->uuid(column: 'id')->primary();

                $table->string(column: 'name', length: 50);
                $table->uuid(column: 'parent_id')->nullable();

                $table->timestamps(precision: 6);
            }
        );

        Schema::table(table: 'activities',
            callback: function (Blueprint $table): void {
                $table->foreign(columns: 'parent_id')
                    ->references(column: 'id')
                    ->on(table: 'activities')
                    ->onDelete(action: 'cascade');

                $table->unique(columns: ['parent_id', 'name']);

                $table->index(columns: 'parent_id');
                $table->index(columns: 'created_at');
            }
        );
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists(table: 'activities');
    }
};
