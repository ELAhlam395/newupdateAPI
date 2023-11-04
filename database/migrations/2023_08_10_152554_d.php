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

        Schema::table('sub__domains', function (Blueprint $table) {
            //define your new column here
            $table->string('Name');
            $table->string('Date_Creation');
            $table->string('Due_Date');
            $table->string('Status');

      
            
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
