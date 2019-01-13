<?php

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class UserTableCreate extends Migration
{
    public function up()
    {
        Schema::create('user', function ($table) {
            $table->increments('id');

            $table->string('name')->nullable()->default(null);
            $table->string('username')->unique();
            $table->string('password');
            $table->string('email')->nullable()->unique();

            $table->timestamp('created_at')->useCurrent();
            $table->timestamp('updated_at')->useCurrent();
        });

        DB::statement("ALTER TABLE \"user\" ADD COLUMN roles integer[] DEFAULT '{}'");
    }

    public function down()
    {
        Schema::dropIfExists('user');
    }
}
