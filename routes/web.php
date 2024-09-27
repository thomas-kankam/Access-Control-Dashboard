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

    // Students
    Route::get('students', [UserController::class, "getStudents"])->name("get.students");
    Route::post('save/student', [UserController::class, "saveStudent"])->name("save.student");

    Route::get('students/{student}/edit', [UserController::class, "editStudent"])->name("edit.student");
    Route::delete('student/{student} ', [UserController::class, "destroyStudent"])->name("destroy.student");
    Route::put('student/{student}', [UserController::class, "updateStudent"])->name("update.student");

    // Staffs
    Route::get('staffs', [UserController::class, "getStaffs"])->name("get.staffs");
    Route::get('staffs/{staff}/edit', [UserController::class, "editStaff"])->name("edit.staff");
    Route::delete('staff/{staff} ', [UserController::class, "destroyStaff"])->name("destroy.staff");
    Route::put('staff/{staff}', [UserController::class, "updateStaff"])->name("update.staff");

    Route::post('save/staff', [UserController::class, "saveStaff"])->name("save.staff");

    // // feedback
    // Route::resource('users', UserController::class);
    Route::get('user', [UserController::class, "getUsers"])->name("get.users");
    Route::get('user/{user}/edit', [UserController::class, "editUser"])->name("edit.user");
    Route::delete('user/{user} ', [UserController::class, "destroyUser"])->name("destroy.user");
    Route::put('user/{user}', [UserController::class, "updateUser"])->name("update.user");

    Route::post('save/user', [UserController::class, "saveUser"])->name("save.user");
});
