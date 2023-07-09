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
        Schema::create('samurdhi_payment_request_items', function (Blueprint $table) {
            $table->id();
            $table->integer('samurdhi_payment_request_id')->references('id')->on('samurdhi_payment_requests');
            $table->integer('family_unit_id')->references('id')->on('family_units');
            $table->decimal('amount', $precision = 8, $scale = 2);
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
        Schema::dropIfExists('samurdhi_payment_request_items');
    }
};