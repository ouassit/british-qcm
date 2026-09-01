<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

class AddSuperAdminToUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        if (Schema::hasColumn('users', 'expire_date')) {
            $sqlMode = DB::selectOne('SELECT @@SESSION.sql_mode as mode')->mode;
            DB::statement("SET SESSION sql_mode = ''");
            DB::statement("UPDATE users SET expire_date = NULL WHERE expire_date = '0000-00-00 00:00:00'");
            DB::statement('ALTER TABLE users MODIFY expire_date timestamp NULL DEFAULT NULL');
            DB::statement("SET SESSION sql_mode = ?", [$sqlMode]);
        }

        if (Schema::hasColumn('users', 'super_admin')) {
            return;
        }

        Schema::table('users', function (Blueprint $table) {
            $table->boolean('super_admin')->default(false)->after('password');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        if (!Schema::hasColumn('users', 'super_admin')) {
            return;
        }

        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn('super_admin');
        });
    }
}
