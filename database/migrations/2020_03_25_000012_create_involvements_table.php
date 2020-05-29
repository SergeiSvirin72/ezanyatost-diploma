<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateInvolvementsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('involvements', function (Blueprint $table) {
            $table->id();
            $table->foreignId('association_id');
            $table->foreign('association_id')->references('id')->on('associations')->onDelete('cascade');
            $table->foreignId('student_id');
            $table->foreign('student_id')->references('id')->on('students')->onDelete('cascade');
            $table->unique(['association_id', 'student_id']);
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
        Schema::dropIfExists('involvements');
    }
}
