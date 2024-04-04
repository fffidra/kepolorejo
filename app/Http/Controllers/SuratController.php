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

    public function buat_surat(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'jenis_surat' => 'required',
            'status_nikah' => 'required',
            'agama' => 'required',
            'pekerjaan' => 'required',
            'ttl' => 'nullable',
            'alamat' => 'nullable',
            'keperluan' => 'nullable',
        ]);
        
        if ($validator->fails()) {
            Session::flash('alert', [
                'type' => 'error',
                'title' => 'Pengajuan Surat Gagal',
                'message' => 'Ada data yang salah!'
            ]);
        } else {
            Surat::create($request->all());
        
            Session::flash('alert', [
                'type' => 'success',
                'title' => 'Pengajuan Surat Berhasil',
                'message' => ''
            ]);
        }
        
        return back();
    }


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
    
    



}
