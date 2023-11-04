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
        Schema::create('servers', function (Blueprint $table) {
            $table->id();
            $table->string('Ip');
            $table->string('Password');
            $table->string('Name');
            $table->string('Due_Date');
            $table->string('Date_Creation');
            $table->string('Name_Provider');
            $table->string('Price');
            $table->string('Payment_Method');
            $table->string('Additionnal_ips');
            $table->string('Comment');

            $table->unsignedBigInteger('Id_Acc_prov');
            $table->foreign('Id_Acc_prov')->references('id')->on('acc__prv__srvs');

            $table->unsignedBigInteger('Id_domain');
            $table->foreign('Id_domain')->references('id')->on('domains');

            $table->Integer('TEAM5');


            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('servers');
    }
};
