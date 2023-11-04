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
            /*
            // Existing foreign key definition
            $table->foreign('Id_Acc_prov')
            ->references('id')
            ->on('acc__prv__srvs');

            $table->foreign('Id_domain')
            ->references('id')
            ->on('domains');
            
            // Update foreign key to be nullable
            $table->foreign('Id_Acc_prov')
            ->nullable()
            ->change();
           */

          // $table->foreignId('Id_domain')->nullable()->constrained();

                                                                   
          // $table->foreignId('Id_domain')->nullable()->constrained()->onDelete('cascade');
           //$table->integer('Id_domain')->unsigned()->nullable()->change();

           $table->unsignedBigInteger('Id_Acc_prov')->nullable()->change();
                                                    
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
