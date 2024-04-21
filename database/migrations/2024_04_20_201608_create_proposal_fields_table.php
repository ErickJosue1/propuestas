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
        Schema::create('proposal_fields', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('proposals_id');
            $table->unsignedBigInteger('fields_id');
            $table->string("info");
            $table->timestamps();


            $table->foreign('proposals_id')->references('id')->on('proposals');
            $table->foreign('fields_id')->references('id')->on('fields');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('proposal_fields');
    }
};
