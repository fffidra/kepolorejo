<?php

namespace App\Http\Controllers;

use App\Models\Jabatan;
use App\Models\Pegawai;
use App\Models\Bidang;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Validator;

class PegawaiController extends Controller
{
    public function index()
    {
        $pegawai = Pegawai::all();
        return view('pegawai', compact('pegawai'));
    }

    public function tambah_pegawai(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'nik' => 'required',
            'nama' => 'required',
        ]);
        if ($validator->fails()) {
            Session::flash('alert', [
                'type' => 'error',
                'title' => 'Input Data Gagal',
                'message' => 'NIP tidak boleh sama!',
            ]);
        } else {
            Pegawai::create([
                'nik' => $request->nik,
                'nama' => $request->nama,
                'password' => bcrypt('1234'),
            ]);
    
            Session::flash('alert', [
                // tipe dalam sweetalert2: success, error, warning, info, question
                'type' => 'success',
                'title' => 'Input Data Berhasil',
                'message' => "",
            ]);
        }
        return back();
    }

    public function masuk(Request $request) 
    {
        $data = [
            "nik" => $request->masuk_nik,
            "password" => $request->masuk_password,
        ];
        // dd($data);
        if(Auth::attempt($data)) {
            Session::flash('alert', [
                // tipe dalam sweetalert2: success, error, warning, info, question
                'type' => 'success',
                'title' => 'Login Berhasil',
                'message' => "Selamat Datang ",
            ]);
            if (Auth::user()->password_reset) {
                return redirect()->route('ubah_kata_sandi');
            }
            return redirect()->route("/");
        };
        dd($data);
        Session::flash('alert', [
            'type' => 'error',
            'title' => 'Login Gagal',
            'message' => "Username atau Password salah!",
        ]);
        return back();
    }

    public function ubah_kata_sandi(Request $request, $nik) 
    {
        $this->validate($request, [
            'password_old' => 'required',
            'password_new' => 'required',
        ]);

        $pegawai = Pegawai::where('nik', $nik)->first();

        if($pegawai && password_verify($request->password_old, $pegawai->password)) {
            if ($request->password_old === $request->password_new || $request->password_new == "1234") {
                Session::flash('alert', [
                    'type' => 'error',
                    'title' => 'Ubah Password Gagal',
                    'message' => "Password baru tidak boleh sama dengan yang lama",
                ]);
            } else {
                $pegawai->update([
                    'password' => bcrypt($request->password_new),
                    'password_reset' => 0,
                ]);
                Session::flash('alert', [
                    'type' => 'success',
                    'title' => 'Ubah Password Berhasil',
                    'message' => '',
                ]);
                return redirect()->route('/');
            }
        } else {
            Session::flash('alert', [
                'type' => 'error',
                'title' => 'Ubah Password Gagal',
                'message' => "Mohon dicek kembali inputannya!",
            ]);
        }

        return back();
    }
}