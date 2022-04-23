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
        Schema::create('auction_bids', function (Blueprint $table) {
            $table->id();
            $table->float('price');
            $table->timestamp('bid_date')->default(DB::raw('CURRENT_TIMESTAMP'));

            $table->unsignedBigInteger('fk_auction_id');
            $table->foreign('fk_auction_id')->references('id')->on('auctions');

            $table->unsignedBigInteger('fk_user_id');
            $table->foreign('fk_user_id')->references('id')->on('users');

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
        Schema::dropIfExists('auction_bids');
    }
};
