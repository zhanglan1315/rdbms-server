<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class EmailTableCreate extends Migration
{
    public function up()
    {
        Schema::create('email', function ($table) {
            $table->string('address')->primary();
            $table->integer('user_id');
            $table->boolean('is_verified')->default(false);
        });
    }

    public function down()
    {
        Schema::dropIfExists('email');
    }
}
