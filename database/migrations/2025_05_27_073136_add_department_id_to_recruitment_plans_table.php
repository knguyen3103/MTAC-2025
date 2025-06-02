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
   public function up(): void
        {
            Schema::table('recruitment_plans', function (Blueprint $table) {
                $table->unsignedBigInteger('department_id')->nullable()->after('department_type');
                $table->foreign('department_id')->references('id')->on('departments')->onDelete('set null');
            });
        }

        public function down(): void
        {
            Schema::table('recruitment_plans', function (Blueprint $table) {
                $table->dropForeign(['department_id']);
                $table->dropColumn('department_id');
            });
        }

};
