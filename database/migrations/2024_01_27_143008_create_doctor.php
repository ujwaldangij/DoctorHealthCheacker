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
        Schema::create('doctor', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('specialties');
            $table->string('contact');
            $table->string('email');
            $table->string("align")->default('no');
            $table->unsignedBigInteger('session_user_id')->nullable();
            $table->enum('agree_disagree', ['agree', 'disagree'])->nullable();
            $table->date('sample_collection_date')->nullable();
            $table->time('sample_collection_time')->nullable();
            $table->string('address_line')->nullable();
            $table->string('state')->nullable();
            $table->string('city')->nullable();
            $table->string('pincode')->nullable();
            $table->string('user_mr')->nullable();
            $table->timestamps();
            $table->longText("esign")->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('doctor');
    }
};
