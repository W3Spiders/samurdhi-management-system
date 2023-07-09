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
        Schema::create('samurdhi_payment_requests', function (Blueprint $table) {
            $table->id();
            $table->string('ref', 15)->unique();
            $table->integer('gn_division_id')->references('id')->on('gn_divisions');
            $table->date('payment_date');
            $table->integer('status_id')->references('id')->on('payment_request_statuses')->default(1);
            $table->decimal('total_amount', $precision = 8, $scale = 2);
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
        Schema::dropIfExists('samurdhi_payment_requests');
    }
};