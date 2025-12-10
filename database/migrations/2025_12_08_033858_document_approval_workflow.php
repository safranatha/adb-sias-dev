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
        Schema::create('document_approval_workflow', function (Blueprint $table) {
           $table->id();
           $table->foreignId('user_id')->constrained()->onDelete('cascade');
           $table->foreignId('proposal_id')->nullable()->constrained()->onDelete('cascade');
           $table->foreignId('surat_penawaran_harga_id')->nullable()->constrained()->onDelete('cascade');
           $table->char('level', 1);
           $table->boolean('status')->nullable();
           $table->string('keterangan');
           $table->string('pesan_revisi')->nullable();
           $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('document_approval_workflow');
    }
};
