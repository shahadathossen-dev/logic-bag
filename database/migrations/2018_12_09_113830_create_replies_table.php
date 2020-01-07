<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateRepliesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('replies', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('review_id')
                    ->unsigned()->foreign('review_id')
                    ->references('id')->on('reviews')
                    ->onDelete('cascade');
            $table->integer('customer_id')->unsigned()->nullable();
            $table->integer('user_id')->unsigned()->nullable();
            $table->string('comment');
            $table->boolean('approved')->default(1);
            $table->boolean('reviewed')->default(0);
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
        Schema::dropIfExists('replies');
    }
}
