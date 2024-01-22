<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

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
            $table->id();
            $table->string('username')->nullable();
            $table->string('email')->unique();
            $table->string('password');
            $table->string('request_token')->nullable();
            $table->string('reset_token')->nullable();
            $table->boolean('isLogin')->default(0);
            $table->timestamp('activity_at')->nullable()->default(DB::raw('CURRENT_TIMESTAMP'));
            $table->text('device_token')->nullable();
            $table->text('old_token')->nullable();
            $table->text('new_token')->nullable();
            $table->rememberToken();
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
