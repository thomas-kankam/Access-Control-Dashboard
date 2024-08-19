<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\DashboardController;
use SebastianBergmann\CodeCoverage\Report\Html\Dashboard;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/
// login
Route::get('/', function () {
    return redirect()->route('dashboard');
});
Route::get('/signin/page', [AuthController::class, 'signin'])->name('auth.signin');
Route::post('login', [AuthController::class, 'login'])->name('auth.login');

Route::group(['middleware' => ['auth']], function () {
    // logout
    Route::post('logout', [AuthController::class, 'logout'])->name('logout');

    // dashboard
    Route::get('dashboard', [DashboardController::class, 'dashboard'])->name('dashboard');
    // Route::get('interests', [HomeController::class, 'getInterest'])->name('get.interests');

    // settings
    Route::resource('settings', DashboardController::class);

    // // leads
    Route::get('logs', [DashboardController::class, 'logs'])->name('logs');

    // // Download upload content template
    // Route::get("download/contact-template", [ContentController::class, "download_contact_template"])->name("contact.template");

    // Students
    Route::get('students', [UserController::class, "getStudents"])->name("get.students");
    Route::post('save/student', [UserController::class, "saveStudent"])->name("save.student");

    // Staffs
    Route::get('staffs', [UserController::class, "getStaffs"])->name("get.staffs");
    Route::post('save/staff', [UserController::class, "saveStaff"])->name("save.staff");

    // // feedback
    Route::resource('users', UserController::class);

    // // Message
    // Route::resource('message', MessageController::class);

    // // Callback
    // Route::resource('callback', CallbackController::class);

    // // Schedule
    // Route::resource('schedule', ScheduleController::class);

    // // Content
    // Route::resource('content', ContentController::class);

    // // Content
    // Route::resource('connect', ConnectController::class);

    // profile
    // Route::get('profile', [ProfileController::class, 'profile'])->name('profile');
    // Route::get('profile/account', [ProfileController::class, 'account'])->name('profile.account');
    // Route::post('update/profile', [ProfileController::class, 'update_profile'])->name('profile.update');
    // Route::post('update/password', [ProfileController::class, 'update_password'])->name('profile.password.update');
    // Route::get('profile/security', [ProfileController::class, 'security'])->name('profile.security');
});
