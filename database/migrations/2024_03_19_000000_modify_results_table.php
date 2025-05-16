<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('results', function (Blueprint $table) {
            // First, add the new column
            $table->foreignId('test_user_id')->nullable()->after('id')->constrained('test_user');
        });

        // Migrate existing data
        DB::statement('
            UPDATE results r
            JOIN test_user tu ON r.user_id = tu.user_id AND r.test_id = tu.test_id
            SET r.test_user_id = tu.id
        ');

        Schema::table('results', function (Blueprint $table) {
            // Make the column required
            $table->foreignId('test_user_id')->nullable(false)->change();
            
            // Drop the old columns
            $table->dropForeign(['user_id']);
            $table->dropForeign(['test_id']);
            $table->dropColumn(['user_id', 'test_id']);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('results', function (Blueprint $table) {
            // Add back the old columns
            $table->foreignId('user_id')->after('id')->constrained();
            $table->foreignId('test_id')->after('user_id')->constrained();
        });

        // Migrate data back
        DB::statement('
            UPDATE results r
            JOIN test_user tu ON r.test_user_id = tu.id
            SET r.user_id = tu.user_id, r.test_id = tu.test_id
        ');

        Schema::table('results', function (Blueprint $table) {
            // Drop the new column
            $table->dropForeign(['test_user_id']);
            $table->dropColumn('test_user_id');
        });
    }
}; 