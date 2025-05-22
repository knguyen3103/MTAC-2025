<?php

use Illuminate\Support\Facades\Route;

//  Controllers cho USER
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\User\DocumentController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\Auth\PasswordChangeController;

//  Controllers cho ADMIN
use App\Http\Controllers\Admin\ApplicantController;
use App\Http\Controllers\Admin\DepartmentController;
use App\Http\Controllers\Admin\EmployeeController;
use App\Http\Controllers\Admin\RecruitmentController;

// ============ TRANG CHỦ ============
Route::get('/', fn () => view('welcome'));

// ============ DASHBOARD REDIRECT ============
Route::get('/dashboard', function () {
    /** @var \App\Models\User $user */
    $user = auth()->user()->load('role');
    $role = $user->role->name ?? null;

    return match ($role) {
        'admin'     => redirect()->route('admin.dashboard'),
        'nhan_vien' => redirect()->route('employee.dashboard'),
        default     => abort(403),
    };
})->middleware('auth')->name('dashboard');


// ============ USER (NHÂN VIÊN) ============
Route::middleware('auth')->group(function () {
    // Đổi mật khẩu
    Route::get('/change-password', [PasswordChangeController::class, 'edit'])->name('password.change');
    Route::post('/change-password', [PasswordChangeController::class, 'update'])->name('password.update');

    // Hồ sơ cá nhân
    Route::get('/profile', [ProfileController::class, 'show'])->name('profile.show');
    Route::get('/profile/edit', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});


// ============ ADMIN ============
Route::prefix('admin')->name('admin.')->middleware(['auth', 'role:admin'])->group(function () {

    Route::get('/', fn () => view('admin.dashboard'))->name('dashboard');

    //  Danh sách tài khoản
    Route::get('/users', [UserController::class, 'index'])->name('users.index');

    //  Nhân sự
    Route::prefix('a_employees')->name('a_employees.')->group(function () {
        Route::get('/', [EmployeeController::class, 'index'])->name('index');
        Route::get('/create', [EmployeeController::class, 'create'])->name('create');
        Route::post('/', [EmployeeController::class, 'store'])->name('store');
        Route::get('/{id}/edit', [EmployeeController::class, 'edit'])->name('edit');
        Route::put('/{id}', [EmployeeController::class, 'update'])->name('update');
        Route::delete('/{id}', [EmployeeController::class, 'destroy'])->name('destroy');
        Route::get('/{id}', [EmployeeController::class, 'show'])->name('show');
    });

    //  Phòng ban
    Route::prefix('departments')->name('departments.')->group(function () {
        Route::get('/', [DepartmentController::class, 'index'])->name('index');
        Route::get('/create', [DepartmentController::class, 'create'])->name('create');
        Route::post('/', [DepartmentController::class, 'store'])->name('store');
        Route::get('/{id}/edit', [DepartmentController::class, 'edit'])->name('edit');
        Route::put('/{id}', [DepartmentController::class, 'update'])->name('update');
        Route::delete('/{id}', [DepartmentController::class, 'destroy'])->name('destroy');
    });

    //  Tuyển dụng
    Route::prefix('recruitments')->name('recruitments.')->group(function () {
        Route::get('/', [RecruitmentController::class, 'index'])->name('index');
        Route::get('/create', [RecruitmentController::class, 'create'])->name('create');
        Route::post('/', [RecruitmentController::class, 'store'])->name('store');
        Route::get('/{id}/edit', [RecruitmentController::class, 'edit'])->name('edit');
        Route::put('/{id}', [RecruitmentController::class, 'update'])->name('update');
        Route::delete('/{id}', [RecruitmentController::class, 'destroy'])->name('destroy');
    });

    //  Ứng viên
    Route::prefix('applicants')->name('applicants.')->group(function () {
        Route::get('/', [ApplicantController::class, 'index'])->name('index');
        Route::get('/create', [ApplicantController::class, 'create'])->name('create');
        Route::post('/', [ApplicantController::class, 'store'])->name('store');
        Route::get('/{id}/edit', [ApplicantController::class, 'edit'])->name('edit');
        Route::put('/{id}', [ApplicantController::class, 'update'])->name('update');
        Route::delete('/{id}', [ApplicantController::class, 'destroy'])->name('destroy');
        Route::get('/approved', [ApplicantController::class, 'approved'])->name('approved');
        Route::get('/filter', [ApplicantController::class, 'filter'])->name('filter');

        //  Trúng tuyển
        Route::get('/accepted', [ApplicantController::class, 'accepted'])->name('accepted');
        Route::post('/{id}/confirm', [ApplicantController::class, 'confirm'])->name('confirm');
        Route::post('/{id}/to-hr', [ApplicantController::class, 'moveToHR'])->name('to_hr');
    });

    //  Phòng Hành chính Nhân sự
    Route::prefix('hr')->name('hr.')->group(function () {
        Route::get('/', [ApplicantController::class, 'hrFileStatus'])->name('index');
        Route::post('/{id}', [ApplicantController::class, 'updateHRFileStatus'])->name('update_file_status');
    });
    //Thống kê
    Route::prefix('applicants')->name('applicants.')->group(function () {
        Route::get('/statistics', [ApplicantController::class, 'statistics'])->name('statistics');
});



});


// ============ NHÂN VIÊN ============
Route::prefix('employee')->name('employee.')->middleware(['auth', 'role:nhan_vien'])->group(function () {
    Route::get('/dashboard', fn () => view('employee.dashboard'))->name('dashboard');
});


// ============ ROUTE AUTH ============
require __DIR__.'/auth.php';
