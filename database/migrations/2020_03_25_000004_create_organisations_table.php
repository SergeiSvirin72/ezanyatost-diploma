<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateOrganisationsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('organisations', function (Blueprint $table) {
            $table->id('id');
            $table->text('full_name');
            $table->text('short_name');
            $table->foreignId('director_id')->unique();
            $table->foreign('director_id')->references('id')->on('users')->onDelete('cascade');
            $table->text('reception');
            $table->text('legal_address');
            $table->text('actual_address');
            $table->string('phone');
            $table->string('fax')->nullable();
            $table->string('email');
            $table->string('website');
            $table->string('img')->nullable();
            $table->boolean('is_school')->default(0);
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
        Schema::dropIfExists('organisations');
    }
}
