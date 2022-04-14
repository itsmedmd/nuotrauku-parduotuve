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
        Schema::create('images', function (Blueprint $table) {
            $table->id();
            $table->string('title', 200);
            $table->string('description', 500)->nullable();
            $table->integer('rating')->default(0);
            $table->float('price')->nullable();
            $table->timestamp('creation_date');
            $table->boolean('is_visible')->default(true);
            $table->string('image', 1000);

            $table->unsignedBigInteger('fk_collection_id_dabartine')->nullable();
            $table->unsignedBigInteger('fk_collection_id_originali');
            $table->unsignedBigInteger('fk_user_id_savininkas');
            $table->unsignedBigInteger('fk_user_id_kurejas');

            $table->foreign('fk_collection_id_dabartine')->references('id')->on('collections');
            $table->foreign('fk_collection_id_originali')->references('id')->on('collections');
            $table->foreign('fk_user_id_savininkas')->references('id')->on('users');
            $table->foreign('fk_user_id_kurejas')->references('id')->on('users');
            
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
        Schema::dropIfExists('images');
    }
};
