<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAreasTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('areas', function (Blueprint $table) {
            $table->id();
            $table->timestamps();
            $table->string('area')->nullable();
            $table->string('area_base')->nullable();
            $table->string('area_building')->nullable();
            $table->string('production_cost')->nullable();
            $table->string('maintenance_cost')->nullable();
            $table->string('building_conditions')->nullable();
            $table->string('trade_bonus_domestic')->nullable();
            $table->string('trade_bonus_overseas')->nullable();
            $table->string('lifting_technology')->nullable();
            $table->string('adjacent_bonus')->nullable();
            $table->string('looting_bonus')->nullable();
            $table->text('effect')->nullable();

            // 文明固有で、どの文明化なのか

            // ユーザー入力
            $table->json('consideration')->nullable();
            $table->integer('star')->default(0);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('areas');
    }
}
