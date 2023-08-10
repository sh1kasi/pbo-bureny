<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserController;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\MeetingController;
use App\Http\Controllers\DashboardController;

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

Route::get("/login", [LoginController::class, "index"])->name("login_index");

Route::post("/login/store", [LoginController::class, "store"])->name("login_store");
Route::post("/logout", [LoginController::class, "logout"])->name("logout");

// Side Admin

Route::group(['middleware' => ['auth', 'cekRole:admin']], function() {

        Route::get("/admin", [DashboardController::class, "index"])->name('admin_dashboard_index');

        Route::get("/admin/rapat", [MeetingController::class, "index"])->name('admin_meeting_index');
        Route::get("/admin/rapat/tambah", [MeetingController::class, "create_index"])->name('admin_create_meeting_index');
        Route::post("/admin/rapat/tambah/store", [MeetingController::class, "create_store"])->name('admin_create_meeting_store');
        
        Route::get("/admin/anggota", [UserController::class, "index"])->name('admin_user_index');
        
                // Datatables
                Route::get('admin/meeting/json', [MeetingController::class, "data"])->name('meeting_data');
                Route::get('admin/member/json', [UserController::class, "data"])->name('user_data');

});
