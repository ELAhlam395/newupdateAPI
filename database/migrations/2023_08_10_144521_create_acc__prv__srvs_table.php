<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('acc__prv__srvs', function (Blueprint $table) {
            $table->id();
            $table->string('User');
            $table->string('Password');
            $table->string('Location');
            
            $table->unsignedBigInteger('Id_team');
            $table->foreign('Id_team')->references('id')->on('teams');
            
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('acc__prv__srvs');
    }
};
