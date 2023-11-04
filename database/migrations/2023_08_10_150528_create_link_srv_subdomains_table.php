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
        Schema::create('link_srv_subdomains', function (Blueprint $table) {
            $table->unsignedBigInteger('id_subdomain');
            $table->foreign('id_subdomain')->references('id')->on('sub__domains');

            $table->unsignedBigInteger('Id_Server');
            $table->foreign('Id_Server')->references('id')->on('servers');

            $table->primary(['id_subdomain','Id_Server']);

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('link_srv_subdomains');
    }
};
