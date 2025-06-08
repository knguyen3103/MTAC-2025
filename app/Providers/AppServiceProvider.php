<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\View;
use Carbon\Carbon;
use App\Models\Announcement;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
{
    view()->composer('*', function ($view) {
        $today = Carbon::now();
        $unreadCount = Announcement::where('hien_thi_tu', '<=', $today)
            ->where(function ($q) use ($today) {
                $q->whereNull('hien_thi_den')->orWhere('hien_thi_den', '>=', $today);
            })
            ->count();

        $view->with('announcementCount', $unreadCount);
    });
}

}
