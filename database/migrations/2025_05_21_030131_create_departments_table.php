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
    Schema::create('departments', function (Blueprint $table) {
        $table->id();
        $table->string('ten_phongban');
        $table->string('ma_phongban')->unique();
        $table->unsignedBigInteger('truong_phong_id')->nullable(); // FK nhân sự làm trưởng phòng
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
        Schema::dropIfExists('departments');
    }
};
