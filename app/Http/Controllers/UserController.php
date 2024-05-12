<?php

namespace App\Http\Controllers;

use App\Models\Jabatan;
use App\Models\Bidang;
use App\Models\SKUsaha;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Validator;

class UserController extends Controller
{
    public function index()
    {
        $pengguna = User::all();
        return view('user', compact('pengguna'));
        return view('ubah_kata_sandi', compact('pegawai'));
    }

    public function index_sku()
    {
        $sku = SKUsaha::all();
        return view('surat.req_surat', compact('sku'));
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
            User::create([
                'nik' => $request->nik,
                'nama' => $request->nama,
                'password' => bcrypt('1234'),
                'role' => 'Pegawai'
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
        $request->validate([
            'nik'=>'required',
            'password'=>'required',
        ], [
            'nik.required'=>'NIK wajib diisi!',
            'password.required'=>'Password wajib diisi!',
        ]);

        $infoLogin = [
            'nik'=>$request->nik,
            'password'=>$request->password,
        ];

        if(Auth::attempt($infoLogin)) {
            if(Auth::user()->role == 'Warga') {
                return redirect('req_surat');
            } elseif(Auth::user()->role == 'Pegawai') {
                return redirect('home');
            }
        } else {
            return redirect()->back()->withErrors('Nik dan password tidak sesuai')->withInput();
        }        
    }

    public function tambah_user(Request $request) {
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
                'message' => 'NIP tidak boleh sama!',
            ]);
        // dd($validator);
        } else {
            User::create([
                'nik' => $request->nik,
                'nama' => $request->nama,
                'password' => bcrypt($request->password),
            ]);
    
            Session::flash('alert', [
                'type' => 'success',
                'title' => 'Buat Akun Berhasil',
                'message' => "",
            ]);
        }
        return back();
    }

    public function keluar() {
        Auth::logout();
        Session::flash('alert', [
            'type' => 'success',
            'title' => 'Logout Berhasil',
            'message' => "",
        ]);
        return redirect()->route("masuk");
    }

    public function ubah_kata_sandi(Request $request) {
        $nik = Auth::user()->nik;

        $this->validate($request, [
            'password_old' => 'required',
            'password_new' => 'required',
        ]);

        $pengguna = User::where('nik', $nik)->first();

        if($pengguna && password_verify($request->password_old, $pengguna->password)) {
            if ($request->password_old === $request->password_new || $request->password_new == "1234") {
                Session::flash('alert', [
                    'type' => 'error',
                    'title' => 'Ubah Password Gagal',
                    'message' => "Password baru tidak boleh sama dengan yang lama",
                ]);
            } else {
                $pengguna->update([
                    'password' => bcrypt($request->password_new),
                    'password_reset' => 0,
                ]);
                Session::flash('alert', [
                    'type' => 'success',
                    'title' => 'Ubah Password Berhasil',
                    'message' => '',
                ]);
                return redirect()->route('surat_res.surat');
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