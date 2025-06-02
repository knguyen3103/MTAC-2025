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
    Schema::create('interviews', function (Blueprint $table) {
        $table->id();
        $table->foreignId('applicant_id')->constrained()->onDelete('cascade'); // ← CHUYỂN LÊN ĐÂY
        $table->string('full_name');
        $table->string('position');
        $table->dateTime('interview_time')->nullable();
        $table->string('status')->nullable();
        $table->string('confirmation_status')->nullable();
        $table->text('note')->nullable();
        $table->timestamps(); // giữ ở cuối
    });
}



    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('interviews');
    }
};
