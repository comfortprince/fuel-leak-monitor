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
        Schema::create('custom_alerts', function (Blueprint $table) {
            $table->id();
            $table->foreignId('storage_tank_id')->constrained()->onDelete('cascade');
            $table->decimal('mq2_min', 10, 2);
            $table->decimal('mq2_max', 10, 2);
            $table->decimal('bmp180_min', 10, 2);
            $table->decimal('bmp180_max', 10, 2);
            $table->string('level');
            $table->text('description');
            $table->text('action_required');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('custom_alerts');
    }
};
