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

    // public function buat_surat_usaha(Request $request)
    // {
    //     $jenis_surat = JenisSurat::all();
    //     return view('surat.req_surat', compact('jenis_surat'));

    //     $validator = Validator::make($request->all(), [
    //         'jenis_surat' => 'required',
    //         'nama' => 'required',
    //         'nik' => 'required',
    //         'tempat_tanggal_lahir' => 'required',
    //         'status' => 'required',
    //         'agama' => 'required',
    //         'pekerjaan' => 'required',
    //         'alamat' => 'required',
    //         'keperluan' => 'required',
    //     ]);
    
    //     if ($validator->fails()) {
    //         Session::flash('alert', [
    //             'type' => 'error',
    //             'title' => 'Input Data Gagal',
    //             'message' => 'Ada inputan yang salah!',
    //         ]);
    //     } else {
    //         Surat::create([
    //             'jenis_surat' => $request->jenis_surat,
    //             'nama' => $request->nama,
    //             'nik' => $request->nik,
    //             'tempat_tanggal_lahir' => $request->tempat_tanggal_lahir,
    //             'status' => $request->status,
    //             'agama' => $request->agama,
    //             'pekerjaan' => $request->pekerjaan,
    //             'alamat' => $request->alamat,
    //             'keperluan' => $request->keperluan,
    //         ]);

    //         Session::flash('alert', [
    //             'type' => 'success',
    //             'title' => 'Input Data Berhasil',
    //             'message' => "",
    //         ]);
    //     }
    //     return back();
    // }

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
    
        // Validasi input untuk surat keterangan usaha
        if ($request->jenis_surat == 'SURAT KETERANGAN USAHA') {
            $validator = Validator::make($request->all(), [
                'nama_warga' => 'required',
                'nik_warga' => 'required',
                'usaha' => 'nullable',
            ]);
        }
        
        // Validasi input untuk surat keterangan domisili
        if ($request->jenis_surat == 'SURAT KETERANGAN DOMISILI') {
            $validator = Validator::make($request->all(), [
                'nama_warga_2' => 'required',
                'nik_warga_2' => 'required',
                'alamat_2' => 'nullable',
            ]);
        }
        
        if ($validator->fails()) {
            Session::flash('alert', [
                'type' => 'error',
                'title' => 'Pengajuan Surat Gagal',
                'message' => 'Ada data yang salah!'
            ]);
            return back()->withErrors($validator)->withInput();
        }
    
        Surat::create($request->all());
    
        Session::flash('alert', [
            'type' => 'success',
            'title' => 'Pengajuan Surat Berhasil',
            'message' => ''
        ]);
    
        return back();
    }
    
    

// public function buat_surat(Request $request)
//     {
//         // Validasi data
//         $request->validate([
//             'nama_warga' => 'required',
//             'nik_warga' => 'required',
//             'agama' => 'required',
//             'jenis_surat' => 'required',
//             'pekerjaan' => 'required',
//             'status_nikah' => 'required',
//             'alamat' => 'required',
//             'ttl' => 'required',
//             'usaha' => 'required',
//             'keperluan' => 'required',
//         ]);

        

//         // Simpan data ke database
//         Surat::create($request->all());

//         // Redirect ke halaman yang diinginkan
//         return redirect()->route('surat.req_surat')->with('success', 'Surat berhasil disimpan.');
//     }

}
