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
        Schema::create('pegawai_task', function (Blueprint $table) {
            $table->id();
            $table->foreignId('pegawai_id')->nullable()->constrained(
                table: 'pegawai'
            );
            $table->foreignId('task_id')->nullable()->constrained(
                table: 'task'
            );
            $table->string('status');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('pegawai_task');
    }
};
