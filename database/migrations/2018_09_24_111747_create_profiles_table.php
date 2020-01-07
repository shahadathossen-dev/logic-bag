<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateProfilesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('profiles', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('user_id')
                    ->unsigned()
                    ->foreign('user_id')
                    ->references('id')->on('users')
                    ->onDelete('cascade');
            $table->date('dob')->nullable();
            $table->string('phone')->nullable();
            $table->string('skills')->nullable();
            $table->string('education')->nullable();
            $table->string('address')->nullable();
            $table->string('notes')->nullable();
            $table->string('avatar')->default('avatar.png');
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
        Schema::dropIfExists('admin_details');
    }
}
