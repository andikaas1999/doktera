<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('documents', function (Blueprint $table) {
            $table->id();
            $table->string('title');
            $table->string('document_number')->unique();
            $table->text('description')->nullable();
            $table->string('category'); // surat masuk, surat keluar, SK, dll
            $table->date('document_date');
            $table->string('file_path')->nullable();
            $table->string('file_name')->nullable();
            $table->string('file_type')->nullable();
            
            // Lokasi Fisik
            $table->string('cabinet_number'); // Nomor Lemari
            $table->string('ordner_number');  // Nomor Map/Ordner
            $table->string('cabinet_label')->nullable(); // Label/Nama Lemari
            $table->string('ordner_label')->nullable();  // Label/Nama Ordner
            $table->integer('document_sequence')->nullable(); // Urutan dalam ordner
            
            $table->string('status')->default('active'); // active, archived, deleted
            $table->foreignId('created_by')->constrained('users');
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('documents');
    }
};
