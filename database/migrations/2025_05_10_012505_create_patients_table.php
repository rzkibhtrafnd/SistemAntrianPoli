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
        Schema::create('patients', function (Blueprint $table) {
            $table->id();
            $table->string('registration_number')->unique();
            $table->string('name');
            $table->enum('gender', ['Laki-laki', 'Perempuan']);
            $table->date('birth_date');
            $table->text('address');
            $table->string('phone', 15);
            $table->text('medical_record')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('patients');
    }
};
