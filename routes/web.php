<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\SuratController;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\File;
    
Route::middleware(['guest'])->group(function() {
    Route::get('masuk', function () {
        return view('masuk');
    })->name('masuk'); 

    Route::get('/buat_akun', function () {
        return view('buat_akun');
    })->name('buat_akun');
    

    Route::post('masuk', [UserController::class, 'masuk'])->name('masuk');
    Route::post('tambah_user', [UserController::class, 'tambah_user'])->name('tambah_user');
});

Route::middleware(['auth'])->group(function() {
    Route::get('/surat_masuk', function () {
        return redirect()->route('surat.surat_masuk');
    })->name('surat_masuk')->middleware('userAccess:Pegawai');  
    
    Route::get('/req_surat', function () {
        return view('surat.req_surat');
    })->name('req_surat')->middleware('userAccess:Warga');

    Route::get('/pegawai', function () {
        return view('pegawai');
    })->name('pegawai')->middleware('userAccess:Pegawai'); 

    Route::get('/jabatan', function () {
        return view('jabatan');
    })->name('jabatan')->middleware('userAccess:Pegawai');

    Route::get('ubah_kata_sandi', function () {
        return view('ubah_kata_sandi');
    })->name('ubah_kata_sandi');

    Route::get('profile', function () {
        return view('profile');
    })->name('profile');
    
    Route::get('surat_masuk', [SuratController::class, 'surat_masuk'])->name('surat.surat_masuk')->middleware('userAccess:Pegawai'); 
    Route::get('surat_disetujui', [SuratController::class, 'surat_disetujui'])->name('surat.surat_disetujui')->middleware('userAccess:Pegawai'); 
    Route::get('surat_ditolak', [SuratController::class, 'surat_ditolak'])->name('surat.surat_ditolak')->middleware('userAccess:Pegawai'); 

    Route::get('/surat/create', [SuratController::class, 'create'])->name('surat.create');

    
    Route::put('ubah_kata_sandi/{nik}', [UserController::class, 'ubah_kata_sandi'])->name('submit_kata_sandi');
    Route::put('ubah_profile/{nik}', [UserController::class, 'ubah_profile'])->name('ubah_profile');
    
    Route::post('buat_sku', [SuratController::class, 'buat_sku'])->name('buat_sku');
    Route::post('buat_skbm', [SuratController::class, 'buat_skbm'])->name('buat_skbm');
    Route::post('buat_skd', [SuratController::class, 'buat_skd'])->name('buat_skd');
    Route::post('buat_sktm', [SuratController::class, 'buat_sktm'])->name('buat_sktm');

    Route::get('skbm', [SuratController::class, 'skbm'])->name('surat.skbm'); 
    Route::get('skd', [SuratController::class, 'skd'])->name('surat.skd'); 
    Route::get('sktm', [SuratController::class, 'sktm'])->name('surat.sktm'); 
    Route::get('sku', [SuratController::class, 'sku'])->name('surat.sku'); 

    Route::post('tambah_pegawai', [UserController::class, 'tambah_pegawai'])->name('tambah_pegawai');
    Route::put('ubah_pegawai', [UserController::class, 'ubah_pegawai'])->name('ubah_pegawai');
    Route::post('get_data_pegawai', [UserController::class, 'get_data_pegawai'])->name('get_data_pegawai');
    Route::get('ubah_isi_pegawai/{nik}', [UserController::class, 'ubah_isi_pegawai'])->name('ubah_isi_pegawai');
    Route::delete('hapus_pegawai/{nik}', [UserController::class, 'hapus_pegawai'])->name('hapus_pegawai');

    Route::post('tambah_jabatan', [UserController::class, 'tambah_jabatan'])->name('tambah_jabatan');
    Route::put('ubah_jabatan', [UserController::class, 'ubah_jabatan'])->name('ubah_jabatan');
    Route::post('get_data_jabatan', [UserController::class, 'get_data_jabatan'])->name('get_data_jabatan');
    Route::get('ubah_isi_jabatan/{nip}', [UserController::class, 'ubah_isi_jabatan'])->name('ubah_isi_jabatan');
    Route::delete('hapus_jabatan/{nip}', [UserController::class, 'hapus_jabatan'])->name('hapus_jabatan');

    Route::post('update_peran', [UserController::class, 'update_peran'])->name('update_peran');
    Route::post('update_jabatan', [UserController::class, 'update_jabatan'])->name('update_jabatan');

    Route::post('get_data_sku', [SuratController::class, 'get_data_sku'])->name('get_data_sku');
    Route::post('get_data_skbm', [SuratController::class, 'get_data_skbm'])->name('get_data_skbm');
    Route::post('get_data_skd', [SuratController::class, 'get_data_skd'])->name('get_data_skd');
    Route::post('get_data_sktm', [SuratController::class, 'get_data_sktm'])->name('get_data_sktm');

    Route::put('sku_setuju/{id_sk_usaha}', [SuratController::class, 'sku_setuju'])->name('sku_setuju'); 
    Route::put('skbm_setuju/{id_sk_belum_menikah}', [SuratController::class, 'skbm_setuju'])->name('skbm_setuju'); 
    Route::put('skd_setuju/{id_sk_domisili}', [SuratController::class, 'skd_setuju'])->name('skd_setuju'); 
    Route::put('sktm_setuju/{id_sk_tidak_mampu}', [SuratController::class, 'sktm_setuju'])->name('sktm_setuju'); 

    Route::put('sku_tolak/{id_sk_usaha}', [SuratController::class, 'sku_tolak'])->name('sku_tolak');
    Route::put('skbm_tolak/{id_sk_belum_menikah}', [SuratController::class, 'skbm_tolak'])->name('skbm_tolak');
    Route::put('skd_tolak/{id_sk_domisili}', [SuratController::class, 'skd_tolak'])->name('skd_tolak');
    Route::put('sktm_tolak/{id_sk_tidak_mampu}', [SuratController::class, 'sktm_tolak'])->name('sktm_tolak');

    Route::get('unduh_sku/{id_sk_usaha}', [SuratController::class, 'unduh_sku'])->name('unduh_sku');
    Route::get('unduh_skbm/{id_sk_belum_menikah}', [SuratController::class, 'unduh_skbm'])->name('unduh_skbm');
    Route::get('unduh_skd/{id_sk_domisili}', [SuratController::class, 'unduh_skd'])->name('unduh_skd');
    Route::get('unduh_sktm/{id_sk_tidak_mampu}', [SuratController::class, 'unduh_sktm'])->name('unduh_sktm');

    Route::put('sku_selesai/{id_sk_usaha}', [SuratController::class, 'sku_selesai'])->name('sku_selesai'); 
    Route::put('skbm_selesai/{id_sk_belum_menikah}', [SuratController::class, 'skbm_selesai'])->name('skbm_selesai'); 
    Route::put('skd_selesai/{id_sk_domisili}', [SuratController::class, 'skd_selesai'])->name('skd_selesai'); 
    Route::put('sktm_selesai/{id_sk_tidak_mampu}', [SuratController::class, 'sktm_selesai'])->name('sktm_selesai'); 

    Route::delete('hapus_sku/{id_sk_usaha}', [SuratController::class, 'hapus_sku'])->name('hapus_sku');
    Route::delete('hapus_skbm/{id_sk_belum_menikah}', [SuratController::class, 'hapus_skbm'])->name('hapus_skbm');
    Route::delete('hapus_skd/{id_sk_domisili}', [SuratController::class, 'hapus_skd'])->name('hapus_skd');
    Route::delete('hapus_sktm/{id_sk_tidak_mampu}', [SuratController::class, 'hapus_sktm'])->name('hapus_sktm');

    Route::get('keluar', [UserController::class, 'keluar'])->name('keluar'); 

    Route::get('dokumen_bukti/{filename}', function ($filename) {
        $path = public_path('bukti_dokumen/' . $filename);
    
        if (!File::exists($path)) {
            abort(404);
        }
    
        return response()->download($path);
    });
});


Route::get('/', function () {
    return view('masuk');
}); 

Route::get('/masuk', function () {
    return view('masuk');
})->name('masuk');

Route::post('index', [SuratController::class, 'index'])->name('index');
Route::post('index_2', [SuratController::class, 'index_2'])->name('index_2');
Route::post('index', [UserController::class, 'index'])->name('index');
Route::post('index_sku', [UserController::class, 'index_sku'])->name('index_sku');


Route::put('ubah_sku', [SuratController::class, 'ubah_sku'])->name('ubah_sku');
Route::put('ubah_skbm', [SuratController::class, 'ubah_skbm'])->name('ubah_skbm');
Route::put('ubah_skd', [SuratController::class, 'ubah_skd'])->name('ubah_skd');
Route::put('ubah_sktm', [SuratController::class, 'ubah_sktm'])->name('ubah_sktm');

