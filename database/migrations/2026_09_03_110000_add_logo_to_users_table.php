<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddLogoToUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        if (Schema::hasColumn('users', 'logo')) {
            return;
        }

        Schema::table('users', function (Blueprint $table) {
            $table->string('logo')->nullable()->after('expire_date');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        if (!Schema::hasColumn('users', 'logo')) {
            return;
        }

        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn('logo');
        });
    }
}
