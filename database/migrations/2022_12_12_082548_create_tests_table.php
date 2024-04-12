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
        Schema::create('tests', function (Blueprint $table) {
            $table->id();
            $table->foreignId('test_type_id')->constrained();
            $table->foreignId('subject_id')->constrained();
            $table->string('duration')->nullable();
            $table->boolean('pass_mark');
            $table->boolean('is_published')->default(0);
            $table->text('instruction')->nullable();
            $table->dateTime('start_date')->nullable();  
            $table->dateTime('end_date')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('tests');
    }
};
