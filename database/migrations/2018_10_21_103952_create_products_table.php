<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateProductsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('products', function (Blueprint $table) {
            $table->increments('id');
            $table->string('title')->unique();
            $table->string('model')->unique();
            $table->integer('category_id');
            $table->integer('subcategory_id');
            $table->tinyInteger('feature_id')->default(1);
            $table->float('price', 8, 2);
            $table->string('material');
            $table->string('dimension');
            $table->double('weight', 5, 3);
            $table->integer('chamber')->unsigined();
            $table->string('pockets');
            $table->text('description');
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
        Schema::dropIfExists('products');
    }
}
