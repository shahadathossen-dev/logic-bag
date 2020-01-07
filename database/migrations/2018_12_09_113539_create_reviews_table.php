<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateReviewsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('reviews', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('product_id')
                    ->unsigned()
                    ->foreign('product_id')
                    ->foreign('user_id')
                    ->references('id')
                    ->on('products')
                    ->onDelete('cascade');
            $table->integer('customer_id')->unsigned()->nullable();
            $table->integer('visitor_id')->unsigned()->nullable();
            $table->string('comment');
            $table->integer('rating')->unsigned();
            $table->boolean('approved')->default(1);
            $table->boolean('reviewed')->default(0);
            $table->string('updated_by')->nullable();
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('reviews');
    }
}
