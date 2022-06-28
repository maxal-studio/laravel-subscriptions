<?php

declare(strict_types=1);

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddFieldToPlansTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up(): void
    {
        Schema::table(config('maxal.subscriptions.tables.plans'), function (Blueprint $table) {
            // Columns
            $table->json('incentive_text')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down(): void
    {
        Schema::table(config('maxal.subscriptions.tables.plans'), function (Blueprint $table) {
            // Columns
            $table->dropColumn('incentive_text');
        });
    }
}
