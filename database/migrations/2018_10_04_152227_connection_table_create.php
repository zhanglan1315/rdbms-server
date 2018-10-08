<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class ConnectionTableCreate extends Migration
{
    public function up()
    {
        Schema::create('connection', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('user_id');

            $table->string('name')->nullable();

            $table->string('driver')->enum(['pgsql']);
            $table->string('host');
            $table->string('port');
            $table->string('username');
            $table->string('password')->nullable();
            $table->string('database');

            $table->timestamp('created_at')->useCurrent();
        });
    }

    public function down()
    {
        Schema::dropIfExists('connection');
    }
}
