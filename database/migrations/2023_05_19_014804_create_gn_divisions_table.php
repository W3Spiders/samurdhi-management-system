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
        Schema::create('gn_divisions', function (Blueprint $table) {
            $table->id();
            $table->integer('ward_no')->references('ward_no')->on('wards');
            $table->string('gn_division_no', 5)->unique(); // Max length 5
            $table->string('gn_division_name', 50);
            $table->integer('gn_user_id')->references('id')->on('users')->unique()->nullable();
            $table->integer('sn_user_id')->references('id')->on('users')->unique()->nullable();
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
        Schema::dropIfExists('gn_divisions');
    }
};
