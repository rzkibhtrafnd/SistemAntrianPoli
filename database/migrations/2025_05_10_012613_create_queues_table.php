<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
    {
        Schema::create('queues', function (Blueprint $table) {
            $table->id();
            $table->integer('queue_number');
            $table->foreignId('patient_id');
            $table->foreignId('poli_id');
            $table->foreignId('doctor_id');
            $table->time('schedule_time');
            $table->string('status')->default('waiting');
            $table->timestamp('registration_time')->useCurrent();
            $table->timestamp('called_time')->nullable();
            $table->timestamp('finish_time')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('queues');
    }
};
