<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('banks', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('ag_format');
            $table->string('cc_format');
            
        });
    }

    public function down()
    {
        Schema::dropIfExists('banks');
    }
};
