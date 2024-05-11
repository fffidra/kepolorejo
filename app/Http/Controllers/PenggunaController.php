<?php

namespace App\Http\Controllers;

use App\Models\Pengguna;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;



class PenggunaController extends Controller
{
    public function index()
    {
        $pengguna = Pengguna::all();
        return view('buat_akun', compact('pengguna'));
    }

    public function tambah_pengguna(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'nik' => 'nullable',
            'nama' => 'nullable',
            'password' => 'nullable',
        ]);

        if ($validator->fails()) {
            Session::flash('alert', [
                'type' => 'error',
                'title' => 'Buat Akun Gagal',
                'message' => 'Ada data yang salah!',
            ]);
        } else {
            Pengguna::create([
                'nik' => $request->nik,
                'nama' => $request->nama,
                'password' => Hash::make($request->password)
            ]);
        }

        Session::flash('alert', [
            'type' => 'success',
            'title' => 'Buat Akun Berhasil',
            'message' => ''
        ]);

        return back();
    }

    public function masuk(Request $request) {
        $data = [
            "nik" => $request->nik,
            "password" => $request->password,
        ];
    
        // Hash check dilakukan setelah mendapatkan data dari formulir
        if(Auth::attempt($data)) {
            Session::flash('alert', [
                // tipe dalam sweetalert2: success, error, warning, info, question
                'type' => 'success',
                'title' => 'Login Berhasil',
                'message' => "Selamat Datang "
            ]);
            return redirect()->route("pegawai");
        };
    
        Session::flash('alert', [
            'type' => 'error',
            'title' => 'Login Gagal',
            'message' => "Username atau Password salah!",
        ]);
        return back();
    }
    

    // public function tambah_user(Request $request)
        // {
        //     $validator = Validator::make($request->all(), [
        //         'nik' => 'required',
        //         'nama' => 'required',
        //         'password' => 'required',
        //     ]);
            
        //     // dd($validator);

        //     if ($validator->fails()) {
        //         Session::flash('alert', [
        //             'type' => 'error',
        //             'title' => 'Input Data Gagal',
        //             'message' => '',
        //         ]);
        //     } else { 
        //     User::create([
        //         'nik' => $request->nik,
        //         'nama' => $request->nama,
        //         'password' => Hash::make($request->password),
        //     ]);

        //     $register = [
        //         'nik' => $request->nik,
        //         'password' => $request->password,
        //     ];
        // }
        //     if (Auth::attempt($register)) {
        //         return redirect('surat.req_surat')->with('success', Auth::user()->nama . 'yeeay');
        //     } else {
        //         return redirect('pegawai')->withErrors('salah nich');
        //     }
        // }
}
