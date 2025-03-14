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
        Schema::create('storage_tanks', function (Blueprint $table) {
            $table->id();
            $table->string('identifier');
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->string('fuel_type');
            $table->string('location');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('storage_tanks');
    }
};
