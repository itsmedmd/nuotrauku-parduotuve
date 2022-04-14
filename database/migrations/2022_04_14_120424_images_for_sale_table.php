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
        Schema::create('images_for_sale', function (Blueprint $table) {
            $table->id();
            $table->float('price');
            $table->timestamp('creation_date');

            $table->unsignedBigInteger('fk_image_id');
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
        Schema::dropIfExists('images_for_sale');
    }
};
