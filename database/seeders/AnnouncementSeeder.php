<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Announcement;
use Carbon\Carbon;

class AnnouncementSeeder extends Seeder
{
    public function run()
    {
        Announcement::truncate(); // Xoá toàn bộ dữ liệu cũ nếu có

        Announcement::create([
            'tieu_de' => '🔧 Thông báo bảo trì và cập nhật hệ thống',
            'noi_dung' => 'Hệ thống phần mềm nhân sự sẽ được bảo trì và nâng cấp vào lúc 20h ngày Thứ Sáu (tuần này). Trong thời gian này, vui lòng không thao tác trên hệ thống. Cảm ơn sự hợp tác của bạn!',
            'do_quan_trong' => 'Quan trọng',
            'hien_thi_tu' => Carbon::now(),
            'hien_thi_den' => Carbon::now()->addDays(3),
        ]);
    }
}
