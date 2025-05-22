<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
{
    Schema::table('applicants', function (Blueprint $table) {
        if (!Schema::hasColumn('applicants', 'cv_path')) {
            $table->string('cv_path')->nullable()->after('status');
        }
    });
}

public function down()
{
    Schema::table('applicants', function (Blueprint $table) {
        $table->dropColumn('cv_path');
    });
}

};
