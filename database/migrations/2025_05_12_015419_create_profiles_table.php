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
       Schema::create('profiles', function (Blueprint $table) {
        $table->id();
        $table->foreignId('user_id')->unique()->constrained();
        $table->string('phone')->nullable();
        $table->string('address')->nullable();
        $table->string('avatar')->nullable();
        // ... các trường khác theo file kế hoạch
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
        Schema::dropIfExists('profiles');
    }
};
