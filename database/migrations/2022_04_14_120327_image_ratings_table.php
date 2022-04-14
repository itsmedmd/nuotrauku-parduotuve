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
        Schema::create('image_ratings', function (Blueprint $table) {
            $table->id();
            $table->boolean('rating');
            
            $table->unsignedBigInteger('fk_user_id_vertintojas');
            $table->unsignedBigInteger('fk_image_id');

            $table->foreign('fk_user_id_vertintojas')->references('id')->on('users');
            $table->foreign('fk_image_id')->references('id')->on('images');

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
        Schema::dropIfExists('image_ratings');
    }
};
