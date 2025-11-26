<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
{
    Schema::create('activity_logs', function (Blueprint $table) {
        $table->id();
        $table->unsignedBigInteger('user_id')->nullable();
        $table->string('name');
        $table->string('role');
        $table->string('ip')->nullable();
        $table->string('user_agent')->nullable();
        $table->string('activity');
        $table->timestamps();
    });
}

public function down(): void
{
    Schema::dropIfExists('activity_logs');
}
};