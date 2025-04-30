<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class RemoveGalleryIdFromGalleryContents extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('gallery_contents', function (Blueprint $table) {
            // Menghapus kolom gallery_id
            $table->dropColumn('gallery_id');
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
            // Menambahkan kembali kolom gallery_id jika rollback dilakukan
            $table->unsignedBigInteger('gallery_id')->nullable();
        });
    }
}
