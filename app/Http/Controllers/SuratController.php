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
        $data = JenisSurat::pluck('nama_jenis_surat');
        dd($data);
    }    

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

    // public function detail_spt($id_spt)
    // {
    //     $spt = SPT::findOrFail($id_spt);
    //     $anggota_spt = AnggotaSPT::where('id_spt', $id_spt)->get();
    //     return view('spt_pka.detail_spt', compact('spt', 'anggota_spt'));
    // }


    public function update_surat(Request $request, $id)
    {
        // Validasi data yang dikirim dari formulir
        $validator = Validator::make($request->all(), [
            'jenis_surat' => 'required',
            'nama_warga' => 'required',
            'nik_warga' => 'required',
            // Tambahkan validasi untuk bidang lainnya di sini sesuai kebutuhan
        ]);
        
        // Jika validasi gagal, kembalikan respon dengan pesan kesalahan
        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }
    
        // Jika validasi berhasil, lanjutkan dengan menyimpan data ke database
        try {
            // Ambil data yang dikirim dari formulir
            $jenis_surat = $request->input('jenis_surat');
            $nama_warga = $request->input('nama_warga');
            $nik_warga = $request->input('nik_warga');
    
            // Lanjutkan dengan mengambil data lainnya sesuai kebutuhan
    
            // Simpan data ke database
            $surat = Surat::find($id);
            $surat->jenis_surat = $jenis_surat;
            $surat->nama_warga = $nama_warga;
            $surat->nik_warga = $nik_warga;
            // Lanjutkan dengan menyimpan data lainnya sesuai kebutuhan
            $surat->save();
    
            // Setelah data berhasil disimpan, kembalikan respon dengan pesan sukses
            return redirect()->back()->with('success', 'Data surat berhasil diperbarui.');
        } catch (\Exception $e) {
            // Tangani kesalahan jika terjadi
            return redirect()->back()->with('error', 'Terjadi kesalahan saat memperbarui data surat: ' . $e->getMessage());
        }
    }
    
    public function edit_surat($id)
    {
        $surats = Surat::findorfail($id);
        return view('surat.res_surat', compact('surats'));
    }

    
    public function get_data_surat(Request $request)
    {
        $surats = Surat::where('id_surat', $request->id)->first();
        if($surats)
        {
            return response()->json([
                'status'=>'success',
                'surats'=> $surats,
            ]);
        }
        else
        {
            return response()->json([
                'status'=>'error',
            ]);
        }

    }

}