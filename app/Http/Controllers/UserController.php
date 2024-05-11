<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;



class UserController extends Controller
{
    public function index()
    {
        $user = User::all();
        return view('surat.req_surat', compact('user'));
    }

    public function masuk(Request $request) {
        $data = [
            "nik" => $request->masuk_nik,
            "password" => $request->masuk_kata_sandi,
        ];
        // dd($data);
        if(Auth::attempt($data)) {
            Session::flash('alert', [
                // tipe dalam sweetalert2: success, error, warning, info, question
                'type' => 'success',
                'title' => 'Login Berhasil',
                'message' => "Selamat Datang ".Auth::user()->nama,
            ]);
            return redirect()->route("surat.req_surat");
        };
        // dd($data);
        Session::flash('alert', [
            'type' => 'error',
            'title' => 'Login Gagal',
            'message' => "Username atau Password salah!",
        ]);
        return back();
    }

    public function tambah_user(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'nik' => 'required',
            'nama' => 'required',
            'password' => 'required',
        ]);
        
        // dd($validator);

        if ($validator->fails()) {
            Session::flash('alert', [
                'type' => 'error',
                'title' => 'Input Data Gagal',
                'message' => '',
            ]);
        } else { 
        User::create([
            'nik' => $request->nik,
            'nama' => $request->nama,
            'password' => Hash::make($request->password),
        ]);

        $register = [
            'nik' => $request->nik,
            'password' => $request->password,
        ];
    }
        if (Auth::attempt($register)) {
            return redirect('surat.req_surat')->with('success', Auth::user()->nama . 'yeeay');
        } else {
            return redirect('pegawai')->withErrors('salah nich');
        }
    }
}
