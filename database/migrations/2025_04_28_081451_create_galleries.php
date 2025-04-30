<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('galleries', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->onDelete('cascade'); // User pembuat
            $table->string('author')->nullable(); // Nama author manual
            $table->string('title'); // Nama karya/project
            $table->string('location'); // Lokasi proyek
            $table->string('function'); // Fungsi proyek
            $table->integer('land_area'); // LT (m2)
            $table->integer('building_area'); // LB (m2)
            $table->string('thumbnail')->nullable(); // Thumbnail utama
            $table->enum('status', ['Draft', 'Published'])->default('Draft'); // Status
            $table->unsignedBigInteger('views')->default(0); // Views
            $table->text('description')->nullable(); // Deskripsi umum
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('galleries');
    }
};
