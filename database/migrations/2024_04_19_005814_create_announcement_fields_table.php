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
        Schema::create('announcement_fields', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('announcements_id');
            $table->unsignedBigInteger('fields_id');
            $table->timestamps();

                
            $table->foreign('announcements_id')->references('id')->on('announcements')->onDelete('cascade');;
            $table->foreign('fields_id')->references('id')->on('fields')->onDelete('cascade');;
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('announcement_fields');
    }
};
