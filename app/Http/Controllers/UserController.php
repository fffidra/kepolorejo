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
            'nik' => 'required|unique:user,nik|size:16',
            'nama' => 'required',
        ]);
        
        if ($validator->fails()) {
            Session::flash('alert', [
                'type' => 'error',
                'title' => 'Tambah Pegawai Gagal',
                'message' => '',
            ]);
        } else {
            $nama = $request->nama;

            User::create([
                'nik' => $request->nik,
                'nama' => $request->nama,
                'password' => bcrypt('1234'),
                'role' => 'Pegawai'
            ]);
                
            Session::flash('alert', [
                'type' => 'success',
                'title' => 'Tambah Pegawai ' . $nama . ' Berhasil',                
                'message' => '',
            ]);
        }
        return back();
    }

    public function ubah_pegawai(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'ubah_nik' => 'nullable',
            'ubah_nama' => 'nullable',
        ]);

        // dd($validator);
        if ($validator->fails()) {
            Session::flash('alert', [
                'type' => 'error',
                'title' => 'Ubah Data Gagal',
                'message' => 'Ada inputan yang salah!',
            ]);
        } else {
            $pegawai = User::find($request->nik);
    
            if ($pegawai) {
                $pegawai->update([
                    'nik' => $request->ubah_nik,
                    'nama' => $request->ubah_nama,
                ]);
                Session::flash('alert', [
                    'type' => 'success',
                    'title' => 'Edit Data Berhasil',
                    'message' => '',
                ]);
            } else {
                Session::flash('alert', [
                    'type' => 'error',
                    'title' => 'Input Data Gagal',
                    'message' => 'Pegawai tidak ditemukan!',
                ]); 
            }
        }
        return back();
    }
    
    public function get_data_pegawai(Request $request)
    {
        $pegawai = User::where('nik', $request->id)->first();

        if($pegawai) {
            return response()->json([
                'status' => 'success',
                'pegawai' => $pegawai,
            ]);
        } else {
            return response()->json([
                'status' => 'error',
            ]);
        }
    }
    
    public function ubah_isi_pegawai($nik) 
    {
        $pegawai = User::find($nik);
        return response()->json(['pegawai' => $pegawai]);
    }
    
    public function hapus_pegawai($nik)
    {
        $pegawai = User::findOrFail($nik);
        if($pegawai) {
            Session::flash('alert', [
                'type' => 'success',
                'title' => 'Hapus Data '.$pegawai->nama.' Berhasil',
                'message' => "",
            ]); 
            $pegawai->delete();
        } else {
            Session::flash('alert', [
                'type' => 'error',
                'title' => 'Hapus Data Gagal',
                'message' => 'Ada kesalahan!',
            ]); 
        }
        return back();
    }

    public function tambah_jabatan(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'nip' => 'required|size:21|unique:jabatan,nip',            
            'nama' => 'required',
            'posisi' => 'required',
        ]);
        
        if ($validator->fails()) {
            Session::flash('alert', [
                'type' => 'error',
                'title' => 'Tambah Jabatan Gagal',
                'message' => 'Ada kesalahan!',
            ]);
        } else {
            $nama = $request->nama;
            Jabatan::create([
                'nip' => $request->nip,
                'nama' => $request->nama,
                'posisi' => $request->posisi,
                'peran' => 'Non Penanda Tangan'
            ]);
                
            Session::flash('alert', [
                'type' => 'success',
                'title' => 'Tambah Jabatan ' . $nama . ' Berhasil',                
                'message' => '',
            ]);
        }
        return back();
    }

    public function ubah_jabatan(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'ubah_nip' => 'required|size:21|unique:jabatan,nip,' . $request->nip . ',nip',
            'ubah_nama' => 'required',
            'ubah_posisi' => 'required',
        ]);
    
        if ($validator->fails()) {
            Session::flash('alert', [
                'type' => 'error',
                'title' => 'Ubah Data Gagal',
                'message' => 'Ada inputan yang salah!',
            ]);
        } else {
            $jabatan = Jabatan::where('nip', $request->nip)->first();
    
            if ($jabatan) {
                $jabatan->update([
                    'nip' => $request->ubah_nip,
                    'nama' => $request->ubah_nama,
                    'posisi' => $request->ubah_posisi,
                ]);
                Session::flash('alert', [
                    'type' => 'success',
                    'title' => 'Edit Data Berhasil',
                    'message' => "",
                ]);
            } else {
                Session::flash('alert', [
                    'type' => 'error',
                    'title' => 'Edit Data Gagal',
                    'message' => 'Data jabatan tidak ditemukan!',
                ]); 
            }
        }
        return back();
    }
    
    public function get_data_jabatan(Request $request)
    {
        $jabatan = Jabatan::where('nip', $request->id)->first();
        if($jabatan)
        {
            return response()->json([
                'status'=>'success',
                'jabatan'=> $jabatan,
            ]);
        }
        else
        {
            return response()->json([
                'status'=>'error',
            ]);
        }
    }

    public function ubah_isi_jabatan($nip) 
    {
        $jabatan = Jabatan::find($nip);
        return response()->json(['jabatan'=>$jabatan]);
    }

    public function hapus_jabatan($nip)
    {
        $jabatan = Jabatan::findOrFail($nip);
        if($jabatan) {
            Session::flash('alert', [
                'type' => 'success',
                'title' => 'Hapus Data '.$jabatan->nama.' Berhasil',
                'message' => "",
            ]); 
            $jabatan->delete();
        } else {
            Session::flash('alert', [
                'type' => 'error',
                'title' => 'Hapus Data Gagal',
                'message' => 'Ada kesalahan!',
            ]); 
        }
        return back();
    }

    // public function updatePeran(Request $request)
    // {
    //     $jabatan = Jabatan::where('nip', $request->nip)->first();
    //     if ($jabatan) {
    //         $jabatan->peran = $request->peran;
    //         $jabatan->save();

    //         return response()->json([
    //             'status' => 'success',
    //         ]);
    //     } else {
    //         return response()->json([
    //             'status' => 'error',
    //         ]);
    //     }
    // }

    public function updatePeran(Request $request)
    {
        // Validasi input
        $validator = Validator::make($request->all(), [
            'nip' => 'required|exists:jabatan,nip',
            'peran' => 'required|in:Penanda Tangan,Non Penanda Tangan',
        ]);

        if ($validator->fails()) {
            return response()->json(['status' => 'error', 'message' => 'Data tidak valid'], 400);
        }

        $nip = $request->input('nip');
        $peran = $request->input('peran');

        if ($peran == 'Penanda Tangan') {
            // Set semua peran 'Penanda Tangan' menjadi 'Non Penanda Tangan'
            Jabatan::where('peran', 'Penanda Tangan')->update(['peran' => 'Non Penanda Tangan']);
        }

        // Update peran untuk pejabat yang dipilih
        $jabatan = Jabatan::where('nip', $nip)->first();
        $jabatan->peran = $peran;
        $jabatan->save();

        return response()->json(['status' => 'success', 'message' => 'Peran berhasil diperbarui']);
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
            'nik' => 'required|unique:user,nik|size:16',            
            'nama' => 'required',
            'password' => 'required',
        ]);
        if ($validator->fails()) {
            // Mengambil semua pesan kesalahan dan menyimpannya ke dalam session flash
            Session::flash('alert', [
                'type' => 'error',
                'title' => 'Buat Akun Gagal',
                'message' => 'Ada inputan yang salah!',            
            ]);
        } else {
            User::create([
                'nik' => $request->nik,
                'nama' => $request->nama,
                'password' => bcrypt($request->password),
            ]);
    
            Session::flash('alert', [
                'type' => 'success',
                'title' => 'Buat Akun Berhasil',
                'message' => 'Akun berhasil dibuat!',
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