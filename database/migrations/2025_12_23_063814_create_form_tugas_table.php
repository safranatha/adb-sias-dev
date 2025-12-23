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
        Schema::create('form_tugas', function (Blueprint $table) {
            $table->id();
            // created by
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->boolean('status')->default(0);
            $table->timestamp('due_date');
            $table->string('jenis_permintaan');
            $table->string('kegiatan');
            $table->string('keterangan')->nullable();
            $table->string('file_path_form_tugas')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('form_tugas');
    }
};
