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
        Schema::create('auctions', function (Blueprint $table) {
            $table->id();
            $table->timestamp('creation_date')->default(DB::raw('CURRENT_TIMESTAMP'));
            $table->dateTime('end_date')->nullable();
            $table->float('price');
            $table->float('initial_price');
            $table->float('minimum_bid_raise');
            $table->enum('status', ['ongoing', 'extended', 'ended'])->default('ongoing');
            
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
        Schema::dropIfExists('auctions');
    }
};
