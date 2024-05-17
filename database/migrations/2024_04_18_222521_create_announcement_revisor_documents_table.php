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
        Schema::create('announcement_revisor_documents', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('announcements_id');
            $table->unsignedBigInteger('revisor_documents_id');
            $table->timestamps();

                
            $table->foreign('announcements_id')->references('id')->on('announcements')->onDelete('cascade');;
            $table->foreign('revisor_documents_id')->references('id')->on('revisor_documents')->onDelete('cascade');;
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('announcement_revisor_documents');
    }
};
