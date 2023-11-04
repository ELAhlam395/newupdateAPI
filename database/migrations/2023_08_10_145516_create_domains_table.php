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
        Schema::create('domains', function (Blueprint $table) {
            $table->id();
            $table->string('Name');
            $table->string('Date_Creation');
            $table->string('Due_Date');
            $table->string('Status');
          
            $table->unsignedBigInteger('Id_Acc_Domain');
            $table->foreign('Id_Acc_Domain')->references('id')->on('acc_prv__dmns');


            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('domains');
    }
};
