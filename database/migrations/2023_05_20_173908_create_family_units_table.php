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
        Schema::create('family_units', function (Blueprint $table) {
            $table->id();
            $table->integer('gn_division_id')->references('id')->on('gn_divisions');
            // $table->string('family_unit_no');
            $table->integer('primary_member_id')->unique()->nullable();
            $table->string('address_line_1', 50);
            $table->string('address_line_2',50)->nullable();
            $table->string('city');
            $table->string('postal_code', 5);
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
        Schema::dropIfExists('family_units');
    }
};