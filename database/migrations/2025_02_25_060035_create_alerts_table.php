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
        Schema::create('alerts', function (Blueprint $table) {
            $table->id();
            $table->foreignId('custom_alert_id')->constrained()->onDelete('cascade');
            $table->timestamp('triggered_at')->useCurrent();
            $table->enum('status', ['unresolved', 'resolved'])->default('unresolved');
            $table->unsignedBigInteger('mq2_reading_id');
            $table->unsignedBigInteger('bmp180_reading_id');
            $table->foreign('mq2_reading_id')->references('id')->on('sensor_readings');
            $table->foreign('bmp180_reading_id')->references('id')->on('sensor_readings');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('alerts');
    }
};
