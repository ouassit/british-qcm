<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        if (Schema::hasColumn('users', 'telephone')) {
            DB::statement('ALTER TABLE users MODIFY telephone VARCHAR(255) NULL');
        }
    }

    public function down()
    {
        if (Schema::hasColumn('users', 'telephone')) {
            DB::statement("UPDATE users SET telephone = '' WHERE telephone IS NULL");
            DB::statement('ALTER TABLE users MODIFY telephone VARCHAR(255) NOT NULL');
        }
    }
};
