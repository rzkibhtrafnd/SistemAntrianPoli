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
            $table->string('queue_number');
            $table->foreignId('patient_id')->constrained('patients');
            $table->foreignId('poli_id')->constrained('polis');
            $table->foreignId('doctor_id')->constrained('doctors');
            $table->enum('status', ['waiting', 'called', 'in_service', 'completed', 'cancelled'])->default('waiting');
            $table->timestamp('registration_time')->useCurrent();
            $table->timestamp('called_time')->nullable();
            $table->timestamp('finish_time')->nullable();
            $table->text('notes')->nullable();
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
