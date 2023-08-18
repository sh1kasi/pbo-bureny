<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserController;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\MeetingController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\RegisterController;

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
Route::get("/register", [RegisterController::class, "index"])->name("register_index");


Route::post("/login/store", [LoginController::class, "store"])->name("login_store");
Route::post("/logout", [LoginController::class, "logout"])->name("logout");
Route::post("register/store", [RegisterController::class, "store"])->name("register_store");


// Side Admin

Route::group(['middleware' => ['auth', 'cekRole:admin']], function() {

        Route::get("/admin", [DashboardController::class, "index"])->name('admin_dashboard_index');

        Route::get("/admin/rapat", [MeetingController::class, "index"])->name('admin_meeting_index');
        Route::get("/admin/rapat/tambah", [MeetingController::class, "create_index"])->name('admin_create_meeting_index');
        Route::post("/admin/rapat/tambah/store", [MeetingController::class, "create_store"])->name('admin_create_meeting_store');
        Route::post("/admin/rapat/edit/store/{id}", [MeetingController::class, "edit_store"])->name('admin_edit_meeting_store');
        Route::post("/admin/rapat/delete/{id}", [MeetingController::class, "delete"])->name('admin_meeting_delete');
        
        Route::get("/admin/anggota", [UserController::class, "index"])->name('admin_user_index');
        
                // Datatables
                Route::get('admin/meeting/json', [MeetingController::class, "data"])->name('meeting_data');
                Route::get('admin/member/json', [UserController::class, "data"])->name('user_data');

});

Route::group(['middleware' => ['auth', 'cekRole:user']], function() {

        // View
        Route::get('/rapat', [MeetingController::class, 'user_index'])->name('user_meeting_index');

        Route::post('/rapat/store', [MeetingController::class, 'user_store'])->name('user_meeting_store');

        // Datatables
        Route::get('/rapat/json', [MeetingController::class, 'user_meeting_data'])->name('user_meeting_data');

        
});
