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
        Schema::create('elder_allowance_payment_request_items', function (Blueprint $table) {
            $table->id();
            $table->integer('elder_allowance_payment_request_id')->references('id')->on('elder_allowance_payment_requests');
            $table->integer('member_id')->references('id')->on('members');
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
        Schema::dropIfExists('elder_allowance_payment_request_items');
    }
};