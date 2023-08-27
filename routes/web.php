<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserController;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\MeetingController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\PengumumanController;
use App\Http\Controllers\RegisterController;
use App\Models\Pengumuman;

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

Route::group(['middleware' => ['auth', 'cekRole:super_admin,admin']], function() {

        Route::get("/admin", [DashboardController::class, "index"])->name('admin_dashboard_index');

        Route::get("/admin/rapat", [MeetingController::class, "index"])->name('admin_meeting_index');
        Route::get("/admin/rapat/tambah", [MeetingController::class, "create_index"])->name('admin_create_meeting_index');
        Route::post("/admin/rapat/tambah/store", [MeetingController::class, "create_store"])->name('admin_create_meeting_store');
        Route::post("/admin/rapat/edit/store/{id}", [MeetingController::class, "edit_store"])->name('admin_edit_meeting_store');
        Route::post("/admin/rapat/delete/{id}", [MeetingController::class, "delete"])->name('admin_meeting_delete');


        
        Route::get("/admin/rapat/detail/{id}", [MeetingController::class, "detail_meeting"])->name('detail_meeting');
        Route::get("/admin/rapat/detail/json/{id}", [MeetingController::class, "detail_meeting_data"])->name('detail_meeting_data');

        Route::get("/admin/anggota", [UserController::class, "index"])->name('admin_user_index');
        Route::post('/admin/anggota/delete/{id}', [UserController::class, 'delete_user'])->name('user_delete');

        Route::get("/admin/pengumuman", [PengumumanController::class, "index"])->name('admin_pengumuman_index');
        Route::get("/admin/pengumuman/json", [PengumumanController::class, "data"])->name('pengumuman_data');
        Route::get("/admin/pengumuman/tambah", [PengumumanController::class, "create_index"])->name('admin_create_pengumuman_index');
        Route::post("/admin/pengumuman/tambah/store", [PengumumanController::class, "create_store"])->name('admin_create_pengumuman_store');
        
                // Datatables
                Route::get('admin/meeting/json', [MeetingController::class, "data"])->name('meeting_data');
                Route::get('admin/member/json', [UserController::class, "data"])->name('user_data');

});

Route::group(['middleware' => ['auth', 'cekRole:user']], function() {

        // View
        Route::get('/rapat', [MeetingController::class, 'user_index'])->name('user_meeting_index');

        Route::get('/absen/rapat/{id}', [MeetingController::class, 'presence_user'])->name('presence_user');
        Route::post('/rapat/store/{id}', [MeetingController::class, 'user_store'])->name('user_meeting_store');

        Route::get('/edit/absen/rapat/{id}', [MeetingController::class, 'edit_presence_user'])->name('edit_presence_user');
        Route::post('/edit/rapat/store/{id}', [MeetingController::class, 'edit_user_store'])->name('edit_user_meeting_store');

        Route::get('/pengumuman', [PengumumanController::class, 'user_index'])->name('user_pengumuman_index');
        Route::post('/pengumuman/read/{id}', [PengumumanController::class, 'markAsRead'])->name('read_pengumuman');


        // Datatables
        Route::get('/rapat/json', [MeetingController::class, 'user_meeting_data'])->name('user_meeting_data');

        
});

Route::post('/promote_user/{id}', [UserController::class, 'promote_user'])->name('promote_to_admin')->middleware(['auth', 'cekRole:super_admin']);
