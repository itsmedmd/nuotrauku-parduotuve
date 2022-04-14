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
        Schema::create('comments', function (Blueprint $table) {
            $table->id();
            $table->string('comment', 500);
            $table->timestamp('date');
            
            $table->unsignedBigInteger('fk_user_id');
            $table->unsignedBigInteger('fk_image_for_sale_id');

            $table->foreign('fk_user_id')->references('id')->on('users');
            $table->foreign('fk_image_for_sale_id')->references('id')->on('images_for_sale');
            
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
        Schema::dropIfExists('comments');
    }
};
