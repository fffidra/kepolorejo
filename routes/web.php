<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\PegawaiController;
use App\Http\Controllers\SuratController;
use App\Http\Controllers\UserController;
use App\Models\User;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Response;
    
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
    Route::get('/home', function () {
        return redirect()->route('surat.res_surat');
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
    
    
    Route::get('surat_disetujui', [SuratController::class, 'surat_disetujui'])->name('surat.surat_disetujui')->middleware('userAccess:Pegawai'); 
    Route::get('surat_ditolak', [SuratController::class, 'surat_ditolak'])->name('surat.surat_ditolak')->middleware('userAccess:Pegawai'); 

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


// Route::get('/filter-surat/{status_surat}', [SuratController::class, 'filterSurat']);






Route::get('/masuk', function () {
    return view('masuk');
})->name('masuk');

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
Route::post('index_2', [SuratController::class, 'index_2'])->name('index_2');
Route::post('index', [UserController::class, 'index'])->name('index');
Route::post('index_sku', [UserController::class, 'index_sku'])->name('index_sku');


Route::get('surat', [SuratController::class, 'index'])->name('surat.req_surat');
Route::post('buat_surat', [SuratController::class, 'buat_surat'])->name('buat_surat');
Route::post('update_surat', [SuratController::class, 'update_surat'])->name('update_surat');

Route::put('ubah_sku', [SuratController::class, 'ubah_sku'])->name('ubah_sku');
Route::put('ubah_skbm', [SuratController::class, 'ubah_skbm'])->name('ubah_skbm');
Route::put('ubah_skd', [SuratController::class, 'ubah_skd'])->name('ubah_skd');
Route::put('ubah_sktm', [SuratController::class, 'ubah_sktm'])->name('ubah_sktm');

Route::put('edit_surat', [SuratController::class, 'edit_surat'])->name('edit_surat');

Route::post('get_data_surat', [SuratController::class, 'get_data_surat'])->name('get_data_surat');
Route::post('get_data_sku', [SuratController::class, 'get_data_sku'])->name('get_data_sku');
Route::post('get_data_skbm', [SuratController::class, 'get_data_skbm'])->name('get_data_skbm');
Route::post('get_data_skd', [SuratController::class, 'get_data_skd'])->name('get_data_skd');
Route::post('get_data_sktm', [SuratController::class, 'get_data_sktm'])->name('get_data_sktm');

Route::post('detail_sk_usaha', [SuratController::class, 'detail_sk_usaha'])->name('detail_sk_usaha');
Route::get('ubah_isi_surat/{id_surat}', [SuratController::class, 'ubah_isi_surat']);
Route::get('ubah_isi_sku/{id_sk_usaha}', [SuratController::class, 'ubah_isi_sku']);
Route::get('ubah_isi_skbm/{id_sk_belum_menikah}', [SuratController::class, 'ubah_isi_skbm']);
Route::get('ubah_isi_skd/{id_sk_domisili}', [SuratController::class, 'ubah_isi_skd']);
Route::get('ubah_isi_sktm/{id_sk_tidak_mampu}', [SuratController::class, 'ubah_isi_sktm']);

Route::put('verifikasi_surat/{id_surat}', [SuratController::class, 'verifikasi_surat'])->name('verifikasi_surat');
Route::put('verifikasi_sk_usaha/{id_sk_usaha}', [SuratController::class, 'verifikasi_sk_usaha'])->name('verifikasi_sk_usaha');
Route::put('verifikasi_sk_belum_menikah/{id_sk_belum_menikah}', [SuratController::class, 'verifikasi_sk_belum_menikah'])->name('verifikasi_sk_belum_menikah');
Route::put('verifikasi_sk_domisili/{id_sk_domisili}', [SuratController::class, 'verifikasi_sk_domisili'])->name('verifikasi_sk_domisili');
Route::put('verifikasi_sk_tidak_mampu/{id_sk_tidak_mampu}', [SuratController::class, 'verifikasi_sk_tidak_mampu'])->name('verifikasi_sk_tidak_mampu');

Route::get('surat_masuk', [SuratController::class, 'index'])->name('surat.res_surat'); 
Route::get('riwayat_surat', [SuratController::class, 'riwayat_surat'])->name('surat.riwayat_surat'); 
Route::put('surat_selesai/{id_surat}', [SuratController::class, 'surat_selesai'])->name('surat_selesai'); 

Route::put('sku_selesai/{id_sk_usaha}', [SuratController::class, 'sku_selesai'])->name('sku_selesai'); 
Route::put('sku_setuju/{id_sk_usaha}', [SuratController::class, 'sku_setuju'])->name('sku_setuju'); 
Route::put('skbm_selesai/{id_sk_belum_menikah}', [SuratController::class, 'skbm_selesai'])->name('skbm_selesai'); 
Route::put('skd_selesai/{id_sk_domisili}', [SuratController::class, 'skd_selesai'])->name('skd_selesai'); 
Route::put('sktm_selesai/{id_sk_tidak_mampu}', [SuratController::class, 'sktm_selesai'])->name('sktm_selesai'); 

Route::get('cari_surat', [SuratController::class, 'cari_surat'])->name('cari_surat');

Route::delete('hapus_surat/{id_surat}', [SuratController::class, 'hapus_surat'])->name('hapus_surat');
Route::delete('hapus_sk_usaha/{id_sk_usaha}', [SuratController::class, 'hapus_sk_usaha'])->name('hapus_sk_usaha');
Route::delete('hapus_sk_belum_menikah/{id_sk_belum_menikah}', [SuratController::class, 'hapus_sk_belum_menikah'])->name('hapus_sk_belum_menikah');
Route::delete('hapus_sk_domisili/{id_sk_domisili}', [SuratController::class, 'hapus_sk_domisili'])->name('hapus_sk_domisili');
Route::delete('hapus_sk_tidak_mampu/{id_sk_tidak_mampu}', [SuratController::class, 'hapus_sk_tidak_mampu'])->name('hapus_sk_tidak_mampu');

Route::get('unduh_surat/{jenis_surat}/{id_surat}', [SuratController::class, 'unduh_surat'])->name('unduh_surat');
Route::get('unduh_sk_usaha/{id_sk_usaha}', [SuratController::class, 'unduh_sk_usaha'])->name('unduh_sk_usaha');
Route::get('unduh_sk_belum_menikah/{id_sk_belum_menikah}', [SuratController::class, 'unduh_sk_belum_menikah'])->name('unduh_sk_belum_menikah');
Route::get('unduh_sk_domisili/{id_sk_domisili}', [SuratController::class, 'unduh_sk_domisili'])->name('unduh_sk_domisili');
Route::get('unduh_sk_tidak_mampu/{id_sk_tidak_mampu}', [SuratController::class, 'unduh_sk_tidak_mampu'])->name('unduh_sk_tidak_mampu');

Route::post('dokumen_surat', [SuratController::class, 'dokumen_surat'])->name('dokumen_surat');