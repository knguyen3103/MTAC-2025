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
use App\Http\Controllers\Admin\InterviewController;
use App\Http\Controllers\Admin\RecruitmentPlanController;
use App\Http\Controllers\Admin\AnnouncementController;
use App\Http\Controllers\Admin\ReportController;

// Excel Export
use App\Exports\RecruitmentPlansExport;
use Maatwebsite\Excel\Facades\Excel;

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
    Route::get('/change-password', [PasswordChangeController::class, 'edit'])->name('password.change');
    Route::post('/change-password', [PasswordChangeController::class, 'update'])->name('password.update');

    Route::get('/profile', [ProfileController::class, 'show'])->name('profile.show');
    Route::get('/profile/edit', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});


// ============ ADMIN ============
Route::prefix('admin')->name('admin.')->middleware(['auth', 'role:admin'])->group(function () {
    Route::get('/', fn () => view('admin.dashboard'))->name('dashboard');

    Route::get('/users', [UserController::class, 'index'])->name('users.index');

    Route::prefix('a_employees')->name('a_employees.')->group(function () {
        Route::get('/', [EmployeeController::class, 'index'])->name('index');
        Route::get('/create', [EmployeeController::class, 'create'])->name('create');
        Route::post('/', [EmployeeController::class, 'store'])->name('store');
        Route::get('/{id}/edit', [EmployeeController::class, 'edit'])->name('edit');
        Route::put('/{id}', [EmployeeController::class, 'update'])->name('update');
        Route::delete('/{id}', [EmployeeController::class, 'destroy'])->name('destroy');
        Route::get('/{id}', [EmployeeController::class, 'show'])->name('show');
    });

    Route::prefix('departments')->name('departments.')->group(function () {
        Route::get('/', [DepartmentController::class, 'index'])->name('index');
        Route::get('/create', [DepartmentController::class, 'create'])->name('create');
        Route::post('/', [DepartmentController::class, 'store'])->name('store');
        Route::get('/{id}/edit', [DepartmentController::class, 'edit'])->name('edit');
        Route::put('/{id}', [DepartmentController::class, 'update'])->name('update');
        Route::delete('/{id}', [DepartmentController::class, 'destroy'])->name('destroy');
        Route::get('/{id}/employees', [DepartmentController::class, 'employees'])->name('employees');
    });

    Route::prefix('recruitments')->name('recruitments.')->middleware(['auth'])->group(function () {
        Route::get('/', [RecruitmentController::class, 'index'])->name('index');
        Route::get('/create', [RecruitmentController::class, 'create'])->name('create');
        Route::post('/', [RecruitmentController::class, 'store'])->name('store');
        Route::get('/{id}/edit', [RecruitmentController::class, 'edit'])->name('edit');
        Route::put('/{id}', [RecruitmentController::class, 'update'])->name('update');
        Route::delete('/{id}', [RecruitmentController::class, 'destroy'])->name('destroy');

        Route::prefix('plans')->name('plans.')->group(function () {
            Route::get('/', [RecruitmentPlanController::class, 'index'])->name('index');
            Route::get('/create', [RecruitmentPlanController::class, 'create'])->name('create');
            Route::post('/', [RecruitmentPlanController::class, 'store'])->name('store');
            Route::get('/{id}/edit', [RecruitmentPlanController::class, 'edit'])->name('edit');
            Route::put('/{id}', [RecruitmentPlanController::class, 'update'])->name('update');
            Route::delete('/{id}', [RecruitmentPlanController::class, 'destroy'])->name('destroy');
            Route::get('/export', function () {
                return Excel::download(new RecruitmentPlansExport, 'ke_hoach_tuyen_dung.xlsx');
            })->name('export');
        });
    });

    Route::prefix('interviews')->name('interviews.')->group(function () {
        Route::get('/', [InterviewController::class, 'index'])->name('index');
        Route::get('/invitation', [InterviewController::class, 'sendInvitationForm'])->name('invitation');
        Route::post('/send-invitation', [InterviewController::class, 'sendInvitation'])->name('send_invitation');
        Route::get('/confirmation', [InterviewController::class, 'confirmationForm'])->name('confirmation');
        Route::post('/submit-confirmation', [InterviewController::class, 'submitConfirmation'])->name('submit_confirmation');
        Route::post('/{id}/update-status', [InterviewController::class, 'updateStatus'])->name('update_status');
        Route::get('/{id}', [InterviewController::class, 'show'])->name('show');
        Route::get('/{id}/edit', [InterviewController::class, 'edit'])->name('edit');
        Route::put('/{id}', [InterviewController::class, 'update'])->name('update');
        Route::delete('/{id}', [InterviewController::class, 'destroy'])->name('destroy');
    });

    Route::prefix('applicants')->name('applicants.')->group(function () {
        Route::get('/', [ApplicantController::class, 'index'])->name('index');
        Route::get('/create', [ApplicantController::class, 'create'])->name('create');
        Route::post('/', [ApplicantController::class, 'store'])->name('store');
        Route::get('/{id}/edit', [ApplicantController::class, 'edit'])->name('edit');
        Route::put('/{id}', [ApplicantController::class, 'update'])->name('update');
        Route::delete('/{id}', [ApplicantController::class, 'destroy'])->name('destroy');
        Route::get('/approved', [ApplicantController::class, 'approved'])->name('approved');
        Route::get('/filter', [ApplicantController::class, 'filter'])->name('filter');
        Route::get('/accepted', [ApplicantController::class, 'accepted'])->name('accepted');
        Route::post('/{id}/confirm', [ApplicantController::class, 'confirm'])->name('confirm');
        Route::post('/{id}/to-hr', [ApplicantController::class, 'moveToHR'])->name('to_hr');
        Route::get('/statistics', [ApplicantController::class, 'statistics'])->name('statistics');
        Route::get('/new-employees', [ApplicantController::class, 'newEmployees'])->name('new_employees');
        Route::get('/{id}', [ApplicantController::class, 'show'])->name('show');
        Route::post('/approve', [ApplicantController::class, 'approve'])->name('approve');
    });

    Route::prefix('announcements')->name('announcements.')->group(function () {
        Route::get('/', [AnnouncementController::class, 'index'])->name('index');
        Route::get('/create', [AnnouncementController::class, 'create'])->name('create');
        Route::post('/', [AnnouncementController::class, 'store'])->name('store');
        Route::get('/{id}/edit', [AnnouncementController::class, 'edit'])->name('edit');
        Route::put('/{id}', [AnnouncementController::class, 'update'])->name('update');
        Route::delete('/{id}', [AnnouncementController::class, 'destroy'])->name('destroy');
    });

    Route::prefix('hr')->name('hr.')->group(function () {
        Route::get('/', [ApplicantController::class, 'hrFileStatus'])->name('index');
        Route::post('/update/{id}', [ApplicantController::class, 'updateHRFileStatus'])->name('update_file_status');
        Route::post('/remove/{id}', [ApplicantController::class, 'removeHRFileStatus'])->name('remove_file_status');
    });

    Route::prefix('reports')->name('reports.')->group(function () {
        Route::get('/', [ReportController::class, 'index'])->name('index');
        Route::get('/export', [ReportController::class, 'export'])->name('export');
    });
 });

// ============ NHÂN VIÊN ============
Route::prefix('employee')->name('employee.')->middleware(['auth', 'role:nhan_vien'])->group(function () {
    Route::get('/dashboard', fn () => view('employee.dashboard'))->name('dashboard');
});

// ============ ROUTE AUTH ============
require __DIR__.'/auth.php';
