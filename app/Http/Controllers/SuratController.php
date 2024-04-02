<?php

namespace App\Http\Controllers;

use App\Models\Agama;
use App\Models\JenisSurat;
use App\Models\Surat;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Validator;

class SuratController extends Controller
{
    public function index()
    {
        $agamas = Agama::all();
        return view('surat.req_surat', ['agamas' => $agamas]);
    }

    public function checkDatabase()
    {
        $data = JenisSurat::pluck('nama_jenis_surat');
        dd($data);
    }    

    public function buat_surat_usaha(Request $request)
    {
        $jenis_surat = JenisSurat::all();
        return view('surat.req_surat', compact('jenis_surat'));

        $validator = Validator::make($request->all(), [
            'jenis_surat' => 'required',
            'nama' => 'required',
            'nik' => 'required',
            'tempat_tanggal_lahir' => 'required',
            'status' => 'required',
            'agama' => 'required',
            'pekerjaan' => 'required',
            'alamat' => 'required',
            'keperluan' => 'required',
        ]);
    
        if ($validator->fails()) {
            Session::flash('alert', [
                'type' => 'error',
                'title' => 'Input Data Gagal',
                'message' => 'Ada inputan yang salah!',
            ]);
        } else {
            Surat::create([
                'jenis_surat' => $request->jenis_surat,
                'nama' => $request->nama,
                'nik' => $request->nik,
                'tempat_tanggal_lahir' => $request->tempat_tanggal_lahir,
                'status' => $request->status,
                'agama' => $request->agama,
                'pekerjaan' => $request->pekerjaan,
                'alamat' => $request->alamat,
                'keperluan' => $request->keperluan,
            ]);

            Session::flash('alert', [
                'type' => 'success',
                'title' => 'Input Data Berhasil',
                'message' => "",
            ]);
        }
        return back();
    }
}
