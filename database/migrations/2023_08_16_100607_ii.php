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
        //

        Schema::table('servers', function (Blueprint $table) {
          

            $table->string('Due_Date')->nullable()->change();
            $table->string('Date_Creation')->nullable()->change();
            $table->string('Name_Provider')->nullable()->change();
            $table->string('Price')->nullable()->change();
            $table->string('Payment_Method')->nullable()->change();
            $table->string('Additionnal_ips')->nullable()->change();
            $table->string('Comment')->nullable()->change();
            $table->string('TEAM5')->nullable()->change();
            $table->integer('PROVIDER')->nullable()->change();

        });
    
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        //
    }
};
