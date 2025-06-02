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
        Schema::create('recruitment_plans', function (Blueprint $table) {
            $table->id();
            $table->string('area'); // VD: HCM, Chi nhánh
            $table->string('department_type'); // VD: Phòng Ban, Khác
            $table->integer('year')->default(2023);
            $table->tinyInteger('month'); // 1-12
            $table->integer('quantity')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('recruitment_plans');
    }
};
