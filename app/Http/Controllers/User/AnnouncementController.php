<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Announcement;
use Carbon\Carbon;

class AnnouncementController extends Controller
{
 
public function index()
{
    $now = now();

    $announcements = Announcement::where(function ($query) use ($now) {
        $query->whereNull('hien_thi_tu')->orWhere('hien_thi_tu', '<=', $now);
    })->where(function ($query) use ($now) {
        $query->whereNull('hien_thi_den')->orWhere('hien_thi_den', '>=', $now);
    })
    ->orderByDesc('do_quan_trong')
    ->orderByDesc('created_at')
    ->paginate(10);

    return view('employee.announcements.index', compact('announcements'));
}
public function countNewAnnouncements()
{
    $today = Carbon::now();
    return Announcement::where('hien_thi_tu', '<=', $today)
        ->where(function ($q) use ($today) {
            $q->whereNull('hien_thi_den')->orWhere('hien_thi_den', '>=', $today);
        })
        ->count();
}
}

