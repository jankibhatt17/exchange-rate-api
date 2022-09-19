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
        Schema::create('currency_rates', function (Blueprint $table) {
            $table->unsignedInteger('user_id');
            //user id from user table
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');

            $table->unsignedInteger('exchange_rate_id');
            //exchange rate id from exchange_rates table
            $table->foreign('exchange_rate_id')->references('id')->on('exchange_rates')->onDelete('cascade');

            $table->date('date');
            $table->string('currency');
            $table->decimal('rate');

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
        Schema::dropIfExists('currency_rates');
    }
};
