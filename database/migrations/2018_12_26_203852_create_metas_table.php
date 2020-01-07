<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateMetasTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('metas', function (Blueprint $table) {
            $table->increments('id');
            $table->string('model')
                    ->foreign('model')
                    ->references('model')->on('products')
                    ->onDelete('cascade');
            $table->string('title')->unique();
            $table->string('slug')->unique();
            $table->text('description');
            $table->boolean('reviewed')->default(0);
            $table->boolean('published')->default(0);
            $table->integer('views')->unsigined()->default(0);
            $table->timestamp('last_view')->nullable();
            $table->string('created_by')->nullable();
            $table->string('updated_by')->nullable();
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
        Schema::dropIfExists('metas');
    }
}
