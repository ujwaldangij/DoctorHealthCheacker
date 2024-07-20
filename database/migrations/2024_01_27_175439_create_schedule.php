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
        Schema::create('schedule', function (Blueprint $table) {
            $table->id();
            $table->string('doctor_id');
            $table->string('status');
            $table->string('agent');
            $table->string('agent_contact')->nullable();
            $table->timestamp('agent_schedule_datetime')->nullable();
            $table->string('result');
            $table->string('upload_report');
            $table->string('user_id');
            $table->string('accept_reject')->nullable();
            $table->string('lab_partners')->nullable();
            $table->string('test_cycle')->nullable();
            $table->string('d3result')->nullable();
            $table->string('creatinine')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('schedule');
    }
};
