<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class RoleTableCreate extends Migration
{
    public function up()
    {
        Schema::create('role', function ($table) {
            $table->increments('id');

            $table->string('name');
        });
    }

    public function down()
    {
        Schema::dropIfExists('role');
    }
}
