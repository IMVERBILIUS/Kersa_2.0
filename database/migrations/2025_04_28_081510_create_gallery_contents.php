<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('gallery_contents', function (Blueprint $table) {
            $table->id();
            $table->foreignId('gallery_subtitle_id')->constrained('gallery_subtitles')->onDelete('cascade');
            $table->integer('order_number')->default(1); // urutan paragraf dalam satu subtitle
            $table->text('content'); // isi paragraf
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('gallery_contents');
    }
};
