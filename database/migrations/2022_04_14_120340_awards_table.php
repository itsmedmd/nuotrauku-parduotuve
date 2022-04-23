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
        Schema::create('awards', function (Blueprint $table) {
            $table->id();
            $table->timestamp('date')->default(DB::raw('CURRENT_TIMESTAMP'));
            $table->float('prize_amount');
            
            $table->unsignedBigInteger('fk_user_id_laimetojas');
            $table->unsignedBigInteger('fk_image_id');

            $table->foreign('fk_user_id_laimetojas')->references('id')->on('users');
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
        Schema::dropIfExists('awards');
    }
};
