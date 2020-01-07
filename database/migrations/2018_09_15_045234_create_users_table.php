<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('users', function (Blueprint $table) {
            $table->increments('id');
            $table->string('fname')->nullable();
            $table->string('lname')->nullable();
            $email = $table->string('email')->unique();
            $email->collation = 'utf8mb4_bin';
            $username = $table->string('username')->unique();
            $username->collation = 'utf8mb4_bin';
            $password = $table->string('password')->nullable();
            $table->tinyInteger('role_id')->default(2);
            $table->tinyInteger('status_id')->default(3);
            $table->timestamp('email_verified_at')->nullable();
            $password->collation = 'utf8mb4_bin';
            $verify_token = $table->string('verify_token')->nullable();
            $verify_token->collation = 'utf8mb4_bin';
            $table->string('updated_by')->nullable();
            $table->rememberToken();
            $table->softDeletes();
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
        Schema::dropIfExists('users');
    }
}
