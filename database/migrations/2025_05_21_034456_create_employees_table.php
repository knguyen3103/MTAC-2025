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
        Schema::create('employees', function (Blueprint $table) {
    $table->id();
    $table->string('ma_nhanvien')->unique();
    $table->string('ma_cham_cong')->nullable();
    $table->string('ho_ten');
    $table->enum('gioi_tinh', ['Nam', 'Nữ', 'Khác'])->nullable();
    $table->date('ngay_sinh')->nullable();
    $table->string('so_dien_thoai')->nullable();
    $table->string('email')->nullable();
    $table->string('vi_tri')->nullable();
    $table->string('chuc_vu')->nullable();
    $table->foreignId('department_id')->constrained()->onDelete('cascade');

    $table->enum('trang_thai', [
        'Chính thức', 'Thử việc', 'Học việc', 'Đào tạo', 'Thực tập',
        'Cộng tác viên', 'Thời vụ', 'Tạm hoãn HĐLĐ', 'Nghỉ việc', 'Nghỉ thai sản'
    ])->default('Thử việc');

    // Các mốc thời gian
    $table->date('ngay_vao_thu_viec')->nullable();
    $table->date('ngay_ket_thuc_thu_viec')->nullable();
    $table->string('ket_qua_thu_viec')->nullable();

    $table->date('ngay_vao_hoc_viec')->nullable();
    $table->date('ngay_ket_thuc_hoc_viec')->nullable();
    $table->string('ket_qua_hoc_viec')->nullable();

    $table->date('ngay_vao_chinh_thuc')->nullable();

    $table->date('ngay_thuc_tap')->nullable();
    $table->date('ngay_ket_thuc_thuc_tap')->nullable();
    $table->string('de_tai_thuc_tap')->nullable();
    $table->string('danh_gia_thuc_tap')->nullable();

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
        Schema::dropIfExists('employees');
    }
};
