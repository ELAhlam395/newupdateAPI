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
        Schema::create('link2s', function (Blueprint $table) {
            $table->unsignedBigInteger('Id_Prov_Server');
            $table->foreign('Id_Prov_Server')->references('id')->on('provider__servers');

            $table->unsignedBigInteger('Id_Acc_Server');
            $table->foreign('Id_Acc_Server')->references('id')->on('acc__prv__srvs');

            $table->primary(['Id_Prov_Server','Id_Acc_Server']);



            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('link2s');
    }
};
