<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddGallerySubtitleIdToGalleryContentsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('gallery_contents', function (Blueprint $table) {
            // Menambahkan kolom gallery_subtitle_id
            $table->unsignedBigInteger('gallery_subtitle_id')->nullable();

            // Menambahkan foreign key constraint
            $table->foreign('gallery_subtitle_id')->references('id')->on('gallery_subtitles')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('gallery_contents', function (Blueprint $table) {
            // Menghapus kolom gallery_subtitle_id
            $table->dropForeign(['gallery_subtitle_id']);
            $table->dropColumn('gallery_subtitle_id');
        });
    }
}
