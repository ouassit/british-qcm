<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up()
    {
        Schema::create('user_page_connections', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('user_id')->index();
            $table->string('page');
            $table->ipAddress('ip_address')->nullable();
            $table->decimal('latitude', 10, 7)->nullable();
            $table->decimal('longitude', 10, 7)->nullable();
            $table->double('accuracy')->nullable();
            $table->string('location_status', 24)->default('not_requested');
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('user_page_connections');
    }
};
