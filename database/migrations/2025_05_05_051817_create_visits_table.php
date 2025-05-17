<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('visits', function (Blueprint $table) {
            $table->id();
            $table->ipAddress('ip_address');      // IP pengunjung
            $table->string('user_agent')->nullable(); // Info browser/device
            $table->string('url');                // URL halaman yang dikunjungi
            $table->timestamp('visited_at')->useCurrent(); // Waktu kunjungan
        });
    }

    public function down()
    {
        Schema::dropIfExists('visits');
    }
};
