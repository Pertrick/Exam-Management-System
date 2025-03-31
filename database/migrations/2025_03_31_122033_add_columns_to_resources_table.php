<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('resources', function (Blueprint $table) {
            $table->string('pdf_file')->nullable()->after('cover_image');
            $table->string('uploaded_video')->nullable()->after('pdf_file');
            $table->string('video_url')->nullable()->after('uploaded_video');
           
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('resources', function (Blueprint $table) {
            $table->dropColumn('pdf_file');
            $table->dropColumn('uploaded_video');
            $table->dropColumn('video_url');
            $table->dropColumn('resource');
        });
    }
};
