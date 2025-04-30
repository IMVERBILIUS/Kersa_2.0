<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('gallery_subtitles', function (Blueprint $table) {
            $table->id();
            $table->foreignId('gallery_id')->constrained('galleries')->onDelete('cascade');
            $table->integer('order_number')->default(1);// urutan subjudul
            $table->string('subtitle'); // Subjudul misalnya 1.1, 2.1, dst
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('gallery_subtitles');
    }
};
