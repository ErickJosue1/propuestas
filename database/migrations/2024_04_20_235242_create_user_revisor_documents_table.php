<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('user_revisor_documents', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('user_id');
            $table->unsignedBigInteger('revisor_documents_id');
            $table->string("path");
            $table->integer("status");
            $table->timestamps();

                
            $table->foreign('user_id')->references('id')->on('users');
            $table->foreign('revisor_documents_id')->references('id')->on('revisor_documents');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('user_revisor_documents');
    }
};
