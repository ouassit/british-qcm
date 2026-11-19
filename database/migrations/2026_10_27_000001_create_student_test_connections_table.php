<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up()
    {
        Schema::create('student_test_connections', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('student_test_id')->index();
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
        Schema::dropIfExists('student_test_connections');
    }
};
