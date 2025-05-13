<?php
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\DocumentController;
use App\Http\Controllers\RecruitmentController;
use App\Http\Controllers\EmployeeController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\Auth\PasswordChangeController;

Route::get('/', fn () => view('welcome'));
Route::get('/dashboard', function () {
    /** @var \App\Models\User $user */
    $user = auth()->user()->load('role');

    $role = $user->role->name ?? null;

    return match ($role) {
        'admin' => redirect()->route('admin.dashboard'),
        'nhan_vien' => redirect()->route('employee.dashboard'),
        default => abort(403),
    };
})->middleware('auth')->name('dashboard');



//  Đổi mật khẩu
Route::middleware('auth')->group(function () {
    Route::get('/change-password', [PasswordChangeController::class, 'edit'])->name('password.change');
    Route::post('/change-password', [PasswordChangeController::class, 'update'])->name('password.update');

    //  Thông tin cá nhân
    Route::get('/profile', [ProfileController::class, 'show'])->name('profile.show');
    Route::get('/profile/edit', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});



// ADMIN ROUTES
Route::prefix('admin')->name('admin.')->middleware(['auth', 'role:admin'])->group(function () {
    Route::get('/', fn () => view('admin.dashboard'))->name('dashboard');

    Route::get('/users', [UserController::class, 'index'])->name('users.index');
    Route::get('/employees', [EmployeeController::class, 'index'])->name('employees.index');

    Route::get('/recruitments', [RecruitmentController::class, 'index'])->name('recruitments.index');
    Route::get('/recruitments/create', fn () => view('admin.recruitments.create'))->name('recruitments.create');
    Route::post('/recruitments/store', function () {
        return back()->with('success', 'Đã đăng tin thành công!');
    })->name('recruitments.store');
});

// EMPLOYEE ROUTES

Route::prefix('employee')->name('employee.')->middleware(['auth', 'role:nhan_vien'])->group(function () {
    Route::get('/dashboard', fn () => view('employee.dashboard'))->name('dashboard');
    
});

require __DIR__.'/auth.php';
