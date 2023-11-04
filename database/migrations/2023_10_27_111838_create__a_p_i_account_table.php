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
        Schema::create('_a_p_i_account', function (Blueprint $table) {
            $table->id();
            $table->string('user');
            $table->string('password');
            $table->string('api_key');
            $table->string('api_hash');
            $table->string('api_get');
            $table->string('api_add');
            $table->string('api_delete');
            $table->string('api_edit');
            $table->unsignedBigInteger('idprov');
            $table->foreign('idprov')->references('id')->on('_a_p_i_provider');

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('_a_p_i_account');
    }
};
