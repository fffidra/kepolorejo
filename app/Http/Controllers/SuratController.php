<?php

namespace App\Http\Controllers;

use App\Models\Surat;
use App\Models\JenisSurat;
use App\Models\Status;
use App\Models\Agama;
use App\Models\Pekerjaan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Validator;

class SuratController extends Controller
{
    public function index()
    {
        $surats = Surat::all();
        return view('surat.res_surat', compact('surats'));
    }

    public function checkDatabase()
    {
        $data = Agama::pluck('nama_agama');
        dd($data);
    }    

    // public function buat_surat(Request $request)
    // {
    //     $validator = Validator::make($request->all(), [
    //         'jenis_surat' => 'required',
    //         'nama_warga' => 'nullable',
    //         'nik_warga' => 'nullable',
    //         'ttl' => 'nullable',
    //         'status_nikah' => 'nullable',
    //         'agama' => 'nullable',
    //         'pekerjaan' => 'nullable',
    //         'alamat' => 'nullable',
    //         'usaha' => 'nullable',
    //         'keperluan' => 'nullable',

    //         'nama_warga_2' => 'nullable',
    //         'nik_warga_2' => 'nullable',
    //         'jenis_kelamin' => 'nullable',
    //         'ttl_2' => 'nullable',
    //         'agama_2' => 'nullable',
    //         'status_nikah_2' => 'nullable',
    //         'pekerjaan_2' => 'nullable',
    //         'alamat_2' => 'nullable',
    //         'alamat_dom' => 'nullable',
    //         'keperluan_2' => 'nullable',
    //     ]);
        
    //     if ($validator->fails()) {
    //         Session::flash('alert', [
    //             'type' => 'error',
    //             'title' => 'Pengajuan Surat Gagal',
    //             'message' => 'Ada data yang salah!'
    //         ]);
    //     } else {
    //         $nama_warga = '';
    //         $nik_warga = '';
    //         $ttl = '';
    //         $agama = '';
    //         $status_nikah = '';
    //         $pekerjaan = '';
    //         $alamat = '';
    //         $keperluan = '';
    //         $usaha = '';
    //         $jenis_kelamin = '';
    //         $alamat_dom = '';

    //         if ($request->jenis_surat === 'SURAT KETERANGAN USAHA') {
    //             $nama_warga = $request->nama_warga;
    //             $nik_warga = $request->nik_warga;
    //             $ttl = $request->ttl;
    //             $agama = $request->agama;
    //             $status_nikah = $request->status_nikah;
    //             $pekerjaan = $request->pekerjaan;
    //             $alamat = $request->alamat;
    //             $keperluan = $request->keperluan;
    //         } elseif ($request->jenis_surat === 'SURAT KETERANGAN DOMISILI') {
    //             $nama_warga = $request->nama_warga_2;
    //             $nik_warga = $request->nik_warga_2;
    //             $ttl = $request->ttl_2;
    //             $agama = $request->agama_2;
    //             $status_nikah = $request->status_nikah_2;
    //             $pekerjaan = $request->pekerjaan_2;
    //             $alamat = $request->alamat_2;
    //             $keperluan = $request->keperluan_2;
    //         }

    //         $surat_baru = [
    //             'jenis_surat' => $request->jenis_surat,
    //             'nama_warga' => $nama_warga,
    //             'nik_warga' => $nik_warga,
    //             'ttl' => $ttl,
    //             'agama' => $agama,
    //             'status_nikah' => $status_nikah,
    //             'pekerjaan' => $pekerjaan,
    //             'alamat' => $alamat,
    //             'keperluan' => $keperluan,
    //             'usaha' => $request->$usaha,
    //             'jenis_kelamin' => $request->$jenis_kelamin,
    //             'alamat_dom' => $request->$alamat_dom
    //         ];

    //         Surat::create($surat_baru);
        
    //         Session::flash('alert', [
    //             'type' => 'success',
    //             'title' => 'Pengajuan Surat Berhasil',
    //             'message' => ''
    //         ]);
    //     }

    //     return back();
    // }

    // public function buat_surat(Request $request)
    // {
    //     $validator = Validator::make($request->all(), [
    //         'jenis_surat' => 'required',
    //         'nama_warga' => 'nullable',
    //         'nik_warga' => 'nullable',
    //         'ttl' => 'nullable',
    //         'status_nikah' => 'nullable',
    //         'agama' => 'nullable',
    //         'pekerjaan' => 'nullable',
    //         'alamat' => 'nullable',
    //         'usaha' => 'nullable',
    //         'keperluan' => 'nullable',

    //         'nama_warga_2' => 'nullable',
    //         'nik_warga_2' => 'nullable',
    //         'jenis_kelamin' => 'nullable',
    //         'ttl_2' => 'nullable',
    //         'agama_2' => 'nullable',
    //         'status_nikah_2' => 'nullable',
    //         'pekerjaan_2' => 'nullable',
    //         'alamat_2' => 'nullable',
    //         'alamat_dom' => 'nullable',
    //         'keperluan_2' => 'nullable',
    //     ]);
        
    //     if ($validator->fails()) {
    //         Session::flash('alert', [
    //             'type' => 'error',
    //             'title' => 'Pengajuan Surat Gagal',
    //             'message' => 'Ada data yang salah!'
    //         ]);
    //     } else {
    //         $surat_baru = [
    //             'jenis_surat' => $request->jenis_surat,
    //             'nama_warga' => $request->jenis_surat === 'SURAT KETERANGAN USAHA' ? $request->nama_warga : $request->nama_warga_2,
    //             'nik_warga' => $request->jenis_surat === 'SURAT KETERANGAN USAHA' ? $request->nik_warga : $request->nik_warga_2,
    //             'ttl' => $request->jenis_surat === 'SURAT KETERANGAN USAHA' ? $request->ttl : $request->ttl_2,
    //             'status_nikah' => $request->jenis_surat === 'SURAT KETERANGAN USAHA' ? $request->status_nikah : $request->status_nikah_2,
    //             'agama' => $request->jenis_surat === 'SURAT KETERANGAN USAHA' ? $request->agama : $request->agama_2,
    //             'pekerjaan' => $request->jenis_surat === 'SURAT KETERANGAN USAHA' ? $request->pekerjaan : $request->pekerjaan_2,
    //             'alamat' => $request->jenis_surat === 'SURAT KETERANGAN USAHA' ? $request->alamat : $request->alamat_2,
    //             'keperluan' => $request->jenis_surat === 'SURAT KETERANGAN USAHA' ? $request->keperluan : $request->keperluan_2,
    //             'usaha' => $request->usaha,
    //             'jenis_kelamin' => $request->jenis_kelamin,
    //             'alamat_dom' => $request->alamat_dom
    //         ];

    //         Surat::create($surat_baru);
        
    //         Session::flash('alert', [
    //             'type' => 'success',
    //             'title' => 'Pengajuan Surat Berhasil',
    //             'message' => ''
    //         ]);
    //     }

    //     return back();
    // }



    // public function buat_surat(Request $request)
    // {
    //     $validator = Validator::make($request->all(), [
    //         'jenis_surat' => 'required',
    //         'status_nikah' => 'required',
    //         'agama' => 'required',
    //         'pekerjaan' => 'required',
    //         'ttl' => 'nullable',
    //         'alamat' => 'nullable',
    //         'keperluan' => 'nullable',
    //     ]);
    
    //     // Validasi input untuk surat keterangan usaha
    //     if ($request->jenis_surat == 'SURAT KETERANGAN USAHA') {
    //         $validator = Validator::make($request->all(), [
    //             'nama_warga' => 'required',
    //             'nik_warga' => 'required',
    //             'usaha' => 'nullable',
    //         ]);
    //     }
        
    //     // Validasi input untuk surat keterangan domisili
    //     if ($request->jenis_surat == 'SURAT KETERANGAN DOMISILI') {
    //         $validator = Validator::make($request->all(), [
    //             'nama_warga_2' => 'required',
    //             'nik_warga_2' => 'required',
    //             'alamat_2' => 'nullable',
    //         ]);
    //     }
        
    //     if ($validator->fails()) {
    //         Session::flash('alert', [
    //             'type' => 'error',
    //             'title' => 'Pengajuan Surat Gagal',
    //             'message' => 'Ada data yang salah!'
    //         ]);
    //         return back()->withErrors($validator)->withInput();
    //     }
    
    //     Surat::create($request->all());
    
    //     Session::flash('alert', [
    //         'type' => 'success',
    //         'title' => 'Pengajuan Surat Berhasil',
    //         'message' => ''
    //     ]);
    
    //     return back();
    // }
    

    // USAHA DOMISILI KADANG FIX EHEHHEEH
    public function buat_surat(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'jenis_surat' => 'required',
            'nama_warga' => 'nullable',
            'nik_warga' => 'nullable',
            'ttl' => 'nullable',
            'status_nikah' => 'nullable',
            'agama' => 'nullable',
            'pekerjaan' => 'nullable',
            'alamat' => 'nullable',
            'usaha' => 'nullable',
            'keperluan' => 'nullable',
            'nama_warga_2' => 'nullable',
            'nik_warga_2' => 'nullable',
            'ttl_2' => 'nullable',
            'agama_2' => 'nullable',
            'status_nikah_2' => 'nullable',
            'pekerjaan_2' => 'nullable',
            'alamat_2' => 'nullable',
            'keperluan_2' => 'nullable',
            'jenis_kelamin' => 'nullable',
            'alamat_dom' => 'nullable',
            'nama_warga_3' => 'nullable',
            'nik_warga' => 'nullable',
            'ttl_3' => 'nullable',
            'status_nikah_3' => 'nullable',
            'agama_3' => 'nullable',
            'pekerjaan_3' => 'nullable',
            'alamat_3' => 'nullable',
            'keperluan_3' => 'nullable',
            'nama_warga_4' => 'nullable',
            'nik_warga_4' => 'nullable',
            'ttl_4' => 'nullable',
            'agama_4' => 'nullable',
            'pekerjaan_4' => 'nullable',
            'alamat_4' => 'nullable',
            'keperluan_4' => 'nullable',
        ]);
        
        if ($validator->fails()) {
            Session::flash('alert', [
                'type' => 'error',
                'title' => 'Pengajuan Surat Gagal',
                'message' => 'Ada data yang salah!'
            ]);
        } else {
            switch ($request->jenis_surat) {
                case 'SURAT KETERANGAN USAHA':
                    Surat::create([
                        'jenis_surat' => $request->jenis_surat,
                        'nama_warga' => $request->nama_warga,
                        'nik_warga' => $request->nik_warga,
                        'ttl' => $request->ttl,
                        'status_nikah' => $request->status_nikah,
                        'agama' => $request->agama,
                        'pekerjaan' => $request->pekerjaan,
                        'alamat' => $request->alamat,
                        'usaha' => $request->usaha,
                        'keperluan' => $request->keperluan,
                    ]);
                    
                break;

                case 'SURAT KETERANGAN DOMISILI':
                    Surat::create([
                        'jenis_surat' => $request->jenis_surat,
                        'nama_warga' => $request->nama_warga_2,
                        'nik_warga' => $request->nik_warga_2,
                        'jenis_kelamin' => $request->jenis_kelamin,
                        'ttl' => $request->ttl_2,
                        'agama' => $request->agama_2,
                        'status_nikah' => $request->status_nikah_2,
                        'pekerjaan' => $request->pekerjaan_2,
                        'alamat' => $request->alamat_2,
                        'alamat_dom' =>$request->alamat_dom,
                        'keperluan' => $request->keperluan_2,
                    ]);
                
                break;

                case 'SURAT KETERANGAN BELUM MENIKAH':
                    Surat::create([
                        'jenis_surat' => $request->jenis_surat,
                        'nama_warga' => $request->nama_warga_3,
                        'nik_warga' => $request->nik_warga_3,
                        'ttl' => $request->ttl_3,
                        'status_nikah' => $request->status_nikah_3,
                        'agama' => $request->agama_3,
                        'pekerjaan' => $request->pekerjaan_3,
                        'alamat' => $request->alamat_3,
                        'keperluan' => $request->keperluan_3,
                    ]);
                
                break;

                case 'SURAT KETERANGAN TIDAK MAMPU':
                    Surat::create([
                        'jenis_surat' => $request->jenis_surat,
                        'nama_warga' => $request->nama_warga_4,
                        'nik_warga' => $request->nik_warga_4,
                        'ttl' => $request->ttl_4,
                        'agama' => $request->agama_4,
                        'pekerjaan' => $request->pekerjaan_4,
                        'alamat' => $request->alamat_4,
                        'keperluan' => $request->keperluan_4,
                    ]);
                
                break;
            }

            Session::flash('alert', [
                'type' => 'success',
                'title' => 'Pengajuan Surat Berhasil',
                'message' => ''
            ]);
        }
        
        return back();
    }

    
    // USAHA FIX
    // public function buat_surat(Request $request)
    // {
    //     $validator = Validator::make($request->all(), [
    //         'jenis_surat' => 'required',
    //         'status_nikah' => 'required',
    //         'agama' => 'required',
    //         'pekerjaan' => 'required',
    //         'ttl' => 'nullable',
    //         'alamat' => 'nullable',
    //         'keperluan' => 'nullable',
    //     ]);
        
    //     if ($validator->fails()) {
    //         Session::flash('alert', [
    //             'type' => 'error',
    //             'title' => 'Pengajuan Surat Gagal',
    //             'message' => 'Ada data yang salah!'
    //         ]);
    //     } else {
    //         Surat::create($request->all());
        
    //         Session::flash('alert', [
    //             'type' => 'success',
    //             'title' => 'Pengajuan Surat Berhasil',
    //             'message' => ''
    //         ]);
    //     }
        
    //     return back();
    // }
    

    // LAST FIXED
    // public function buat_surat(Request $request)
    // {
    //     switch ($request->jenis_surat) {
    //         case 'SURAT KETERANGAN USAHA':
    //             $validator = Validator::make($request->all(), [
    //                 'jenis_surat' => 'required',
    //                 'nama_warga' => 'nullable',
    //                 'nik_warga' => 'nullable',
    //                 'ttl' => 'nullable',
    //                 'status_nikah' => 'nullable',
    //                 'agama' => 'nullable',
    //                 'pekerjaan' => 'nullable',
    //                 'alamat' => 'nullable',
    //                 'usaha' => 'required', 
    //                 'keperluan' => 'nullable',
    //             ]);
            
    //         break;

    //         case 'SURAT KETERANGAN DOMISILI':
    //             $validator = Validator::make($request->all(), [
    //                 'jenis_surat' => 'required',
    //                 'nama_warga' => 'nullable',
    //                 'nik_warga' => 'nullable',
    //                 'jenis_kelamin' => 'required', 
    //                 'ttl' => 'nullable',
    //                 'agama' => 'nullable',
    //                 'status_nikah' => 'nullable',
    //                 'pekerjaan' => 'nullable',
    //                 'alamat' => 'nullable',
    //                 'alamat_dom' => 'required', 
    //                 'keperluan' => 'nullable',
    //             ]);
                
    //         break;

    //         default:
    //             $validator = Validator::make($request->all(), [
    //                 'jenis_surat' => 'required',
    //             ]);
            
    //         break;
    //     }

    //     if ($validator->fails()) {
    //         Session::flash('alert', [
    //             'type' => 'error',
    //             'title' => 'Pengajuan Surat Gagal',
    //             'message' => 'Ada data yang salah!'
    //         ]);
    //     } else {
    //         switch ($request->jenis_surat) {
    //             case 'SURAT KETERANGAN USAHA':
    //                 Surat::create([
    //                     'jenis_surat' => $request->jenis_surat,
    //                     'nama_warga' => $request->nama_warga,
    //                     'nik_warga' => $request->nik_warga,
    //                     'ttl' => $request->ttl,
    //                     'status_nikah' => $request->status_nikah,
    //                     'agama' => $request->agama,
    //                     'pekerjaan' => $request->pekerjaan,
    //                     'alamat' => $request->alamat,
    //                     'usaha' => $request->usaha,
    //                     'keperluan' => $request->keperluan,
    //                 ]);
                    
    //             break;

    //             case 'SURAT KETERANGAN DOMISILI':
    //                 Surat::create([
    //                     'jenis_surat' => $request->jenis_surat,
    //                     'nama_warga' => $request->nama_warga_2,
    //                     'nik_warga' => $request->nik_warga_2,
    //                     'jenis_kelamin' => $request->jenis_kelamin,
    //                     'ttl' => $request->ttl_2,
    //                     'agama' => $request->agama_2,
    //                     'status_nikah' => $request->status_nikah_2,
    //                     'pekerjaan' => $request->pekerjaan_2,
    //                     'alamat' => $request->alamat_2,
    //                     'alamat_dom' => $request->alamat_dom,
    //                     'keperluan' => $request->keperluan_2,
    //                 ]);
                    
    //             break;
    //         }

    //         Session::flash('alert', [
    //             'type' => 'success',
    //             'title' => 'Pengajuan Surat Berhasil',
    //             'message' => ''
    //         ]);
    //     }
    //     return back();
    // }

//     public function buat_surat(Request $request)
// {
//     $validatorRules = [
//         'jenis_surat' => 'required',
//         'nama_warga' => 'nullable',
//         'nik_warga' => 'nullable',
//         'ttl' => 'nullable',
//         'status_nikah' => 'nullable',
//         'agama' => 'nullable',
//         'pekerjaan' => 'nullable',
//         'alamat' => 'nullable',
//         'keperluan' => 'nullable',
//     ];

//     switch ($request->jenis_surat) {
//         case 'SURAT KETERANGAN USAHA':
//             $validatorRules['usaha'] = 'nullable';
//             break;

//         case 'SURAT KETERANGAN DOMISILI':
//             $validatorRules['jenis_kelamin'] = 'nullable';
//             $validatorRules['alamat_dom'] = 'nullable';
//             break;
//     }

//     $validator = Validator::make($request->all(), $validatorRules);

//     if ($validator->fails()) {
//         Session::flash('alert', [
//             'type' => 'error',
//             'title' => 'Pengajuan Surat Gagal',
//             'message' => 'Ada data yang salah!'
//         ]);
//     } else {
//         Surat::create($request->all());

//         Session::flash('alert', [
//             'type' => 'success',
//             'title' => 'Pengajuan Surat Berhasil',
//             'message' => ''
//         ]);
//     }

//     return back();
// }

}