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
        Schema::create('members', function (Blueprint $table) {
            $table->id();
            $table->integer('family_unit_id')->references('id')->on('family_units');
            $table->string('first_name', 50);
            $table->string('last_name', 50)->nullable();
            $table->string('middle_name', 50)->nullable();
            $table->string('phone', 10)->unique()->nullable();
            $table->string('email', 50)->unique()->nullable();
            $table->string('nic', 12)->unique()->nullable();
            $table->date('birthday');
            $table->enum('has_income', [0,1]);
            $table->double('monthly_income', 10, 2)->nullable();
            $table->enum('gender', ['m','f']);
            $table->string('race', 10);
            $table->enum('marital_status', ['married', 'single']);
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
        Schema::dropIfExists('members');
    }
};