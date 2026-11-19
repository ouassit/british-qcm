<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up()
    {
        // A management-page visit belongs to a user, not to a student's test.
        DB::statement('ALTER TABLE student_test_connections MODIFY student_test_id BIGINT UNSIGNED NULL');

        Schema::table('student_test_connections', function (Blueprint $table) {
            $table->unsignedBigInteger('user_id')->nullable()->index();
            $table->string('page')->nullable();
        });

        // Keep the source table as a backup; all new writes use the target table.
        if (Schema::hasTable('user_page_connections')) {
            DB::transaction(function () {
                DB::table('user_page_connections')->orderBy('id')->chunkById(500, function ($connections) {
                    $rows = [];
                    foreach ($connections as $connection) {
                        $row = (array) $connection;
                        unset($row['id']);
                        $row['student_test_id'] = null;
                        $rows[] = $row;
                    }
                    DB::table('student_test_connections')->insert($rows);
                });
            });
        }
    }

    public function down()
    {
        // Do not discard user identifiers or visits recorded since the migration.
        throw new \RuntimeException('This data migration requires a manual rollback to preserve recorded visits.');
    }
};
