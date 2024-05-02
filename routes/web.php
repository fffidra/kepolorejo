<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\SuratController;
use App\Http\Controllers\UserController;

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

Route::middleware('guest')->group(function() {
    Route::get('masuk', function () {
        return view('masuk');
    })->name('masuk'); // GET Akses Laman Login
    Route::post('masuk', [UserController::class, 'masuk'])->name('masuk.akun'); // POST Aksi Proses Login
});

Route::middleware('auth')->group(function() {
    Route::get('keluar', [UserController::class, 'keluar'])->name('keluar.akun'); // GET Aksi Proses Logout

    Route::get('ubah_kata_sandi', function () {
        return view('ubah_kata_sandi');
    })->name('ubah_kata_sandi'); // GET Akses Laman Ubah Password
    Route::put('ubah_kata_sandi/{nip}', [UserController::class, 'ubah_kata_sandi'])->name('submit_kata_sandi'); // PUT Aksi Proses Ubah Password

    Route::group(['middleware' => 'ubah.kata.sandi'], function () {
        Route::get('/', function () {
            return view('masuk');
        })->name('masuk'); 


        Route::post('tambah_user', [UserController::class, 'tambah_user_baru'])->name('tambah_user'); // POST Aksi Proses Tambah User
        Route::post('buat_surat_usaha', [SuratController::class, 'buat_surat_usaha'])->name('buat_surat_usaha'); // POST Aksi Proses Buat SPT
        Route::get('surat', [SuratController::class, 'index'])->name('surat.req_surat');


    });
});


Route::get('/', function () {
    return view('surat.res_surat');
});

Route::get('/req', function () {
    return view('surat.req_surat');
});

Route::get('/masuk', function () {
    return view('masuk');
})->name('masuk');

Route::get('/buat_akun', function () {
    return view('buat_akun');
})->name('buat_akun');

Route::get('/usaha', function () {
    return view('surat.surat_keterangan_usaha');
});

Route::get('/nikah', function () {
    return view('surat.surat_keterangan_nikah');
});

Route::get('/waris', function () {
    return view('surat.surat_ahli_waris');
});

Route::post('check-database', [SuratController::class, 'checkDatabase'])->name('check_database');
Route::post('buat_surat_usaha', [SuratController::class, 'buat_surat_usaha'])->name('buat_surat_usaha');
Route::post('index', [SuratController::class, 'index'])->name('index');
Route::get('surat', [SuratController::class, 'index'])->name('surat.req_surat');
Route::post('buat_surat', [SuratController::class, 'buat_surat'])->name('buat_surat');
Route::post('update_surat', [SuratController::class, 'update_surat'])->name('update_surat');
Route::put('edit_surat', [SuratController::class, 'edit_surat'])->name('edit_surat');
Route::post('get_data_surat', [SuratController::class, 'get_data_surat'])->name('get_data_surat');
Route::get('ubah_isi_surat/{id_surat}', [SuratController::class, 'ubah_isi_surat']);
Route::put('verifikasi_surat/{id_surat}', [SuratController::class, 'verifikasi_surat'])->name('verifikasi_surat');
Route::get('surat_masuk', [SuratController::class, 'index'])->name('surat.res_surat'); 
Route::get('surat_disetujui', [SuratController::class, 'surat_disetujui'])->name('surat.surat_disetujui'); 
Route::get('riwayat_surat', [SuratController::class, 'riwayat_surat'])->name('surat.riwayat_surat'); 
Route::put('surat_selesai/{id_surat}', [SuratController::class, 'surat_selesai'])->name('surat_selesai'); 
Route::get('cari_surat', [SuratController::class, 'cari_surat'])->name('cari_surat');
Route::delete('hapus_surat/{id_surat}', [SuratController::class, 'hapus_surat'])->name('hapus_surat');
Route::get('unduh_surat/{jenis_surat}/{id_surat}', [SuratController::class, 'unduh_surat'])->name('unduh_surat');

