<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateOrdersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('orders', function (Blueprint $table) {
            $table->increments('id');
            $table->string('order_number');
            $table->integer('customer_id')
                    ->unsigned()
                    ->foreign('customer_id')
                    ->references('id')->on('customers')
                    ->onDelete('cascade');
            $table->integer('billing_address_id');
            $table->integer('delivery_address_id');
            $table->string('offer_id')->nullable();
            $table->string('payment_mode');
            $table->date('delivery_date');
            $table->tinyInteger('status_id')->default(1);
            $table->string('note')->nullable();
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
        Schema::dropIfExists('orders');
    }
}
