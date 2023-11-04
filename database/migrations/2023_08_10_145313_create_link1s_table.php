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
        Schema::create('link1s', function (Blueprint $table) {
            $table->unsignedBigInteger('Id_Prov_Domain');
            $table->foreign('Id_Prov_Domain')->references('id')->on('provider__domains');

            $table->unsignedBigInteger('Id_Acc_Domain');
            $table->foreign('Id_Acc_Domain')->references('id')->on('acc_prv__dmns');

            $table->primary(['Id_Prov_Domain','Id_Acc_Domain']);

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('link1s');
    }
};
