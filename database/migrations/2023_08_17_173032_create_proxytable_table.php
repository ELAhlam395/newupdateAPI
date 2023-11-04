<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('proxytable', function (Blueprint $table) {
            $table->id();
            $table->string('ipproxy');
            $table->string('port');
            $table->string('userproxy');
            $table->string('passwordproxy');
            $table->unsignedBigInteger('idaccproxy');
            $table->foreign('idaccproxy')->references('id')->on('accountproxy');
            $table->string('providerproxy');
            $table->string('teamproxy');
            $table->string('ispproxy');
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
        Schema::dropIfExists('proxytable');
    }
};
