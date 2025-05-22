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
        Schema::create('applicants', function (Blueprint $table) {
            $table->id();
            $table->string('full_name');
            $table->string('email')->unique();
            $table->string('phone')->nullable();
            $table->date('birthday')->nullable();          // ➕ Ngày sinh
            $table->string('major')->nullable();           // ➕ Chuyên ngành
            $table->string('university')->nullable();      // ➕ Trường học
            $table->string('position')->nullable();
            $table->string('status')->default('Ứng tuyển'); // Ứng tuyển, Đã PV, Trúng tuyển...
            $table->string('cv_path')->nullable();         // ➕ File CV
            $table->string('confirmation')->nullable();    // ➕ Xác nhận hồ sơ
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
        Schema::dropIfExists('applicants');
    }
};
