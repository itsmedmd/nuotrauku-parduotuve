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
        Schema::create('collections', function (Blueprint $table) {
            $table->id();
            $table->string('name', 200);
            $table->string('description', 500)->nullable();
            $table->timestamp('creation_date')->default(DB::raw('CURRENT_TIMESTAMP'));

            $table->unsignedBigInteger('fk_user_id_kurejas');
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
        Schema::dropIfExists('collections');
    }
};
