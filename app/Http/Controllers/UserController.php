<?php

namespace App\Http\Controllers;

use App\Models\Jabatan;
use App\Models\SKUsaha;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Log;

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

    public function showForm()
    {
        $roles = User::select('role')->distinct()->pluck('role')->toArray();
        return view('pegawai', compact('roles'));
    }    
    
    public function tambah_pegawai(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'nik' => 'required|unique:user,nik|size:16',
            'nama' => 'required',
            'role' => 'required',
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
                'role' => $request->role
            ]);
                
            Session::flash('alert', [
                'type' => 'success',
                'title' => 'Tambah Pegawai ' . $nama . ' Berhasil',                
                'message' => '',
            ]);
        }
        return back();
    }

    public function tambah_warga(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'nik' => 'required|unique:user,nik|size:16',
            'nama' => 'required',
        ]);
        
        if ($validator->fails()) {
            Session::flash('alert', [
                'type' => 'error',
                'title' => 'Tambah Warga Gagal',
                'message' => '',
            ]);
        } else {
            $nama = $request->nama;

            User::create([
                'nik' => $request->nik,
                'nama' => $request->nama,
                'password' => bcrypt('1234'),
                'role' => 'Warga'
            ]);
                
            Session::flash('alert', [
                'type' => 'success',
                'title' => 'Tambah Warga ' . $nama . ' Berhasil',                
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
            'ubah_role' => 'nullable',
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
                    'role' => $request->ubah_role,
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

    public function hapus_warga($nik)
    {
        $warga = User::findOrFail($nik);
        if($warga) {
            Session::flash('alert', [
                'type' => 'success',
                'title' => 'Hapus Data '.$warga->nama.' Berhasil',
                'message' => "",
            ]); 
            $warga->delete();
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
            'nama_jabatan' => 'required',
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
                'nama_jabatan' => $request->nama_jabatan,
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
            'ubah_nama_jabatan' => 'required',
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
                    'nama_jabatan' => $request->ubah_nama_jabatan,
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

    public function update_peran(Request $request)
    {
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
            Jabatan::where('nip', '!=', $nip)->update(['peran' => 'Non Penanda Tangan']);
        }
                
        $jabatan = Jabatan::where('nip', $nip)->first();
        $jabatan->peran = $peran;
        $jabatan->save();

        return response()->json(['status' => 'success', 'message' => 'Peran berhasil diperbarui']);
    }

    public function update_jabatan(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'nip' => 'required|exists:jabatan,nip',
            'jabatan' => 'required|in:Lurah,Non Lurah',
        ]);

        if ($validator->fails()) {
            return response()->json(['status' => 'error', 'message' => 'Data tidak valid'], 400);
        }

        $nip = $request->input('nip');
        $jabatan_baru = $request->input('jabatan');

        if ($jabatan_baru == 'Lurah') {
            Jabatan::where('jabatan', 'Lurah')->update(['jabatan' => 'Non Lurah']);
        }

        $jabatan = Jabatan::where('nip', $nip)->first();
        $jabatan->jabatan = $jabatan_baru; 
        $jabatan->save();

        return response()->json(['status' => 'success', 'message' => 'Jabatan berhasil diperbarui']);
    }

    public function masuk(Request $request)
    {
        $request->validate([
            'nik'=>'required',
            'password'=>'required',
        ]);

        $infoLogin = [
            'nik'=>$request->nik,
            'password'=>$request->password,
        ];

        if(Auth::attempt($infoLogin)) {
            Session::flash('alert', [
                'type' => 'success',
                'title' => 'Login Berhasil',
                'message' => "Selamat Datang ".Auth::user()->nama,
            ]);
            if(Auth::user()->role == 'Warga') {
                return redirect('req_surat');
            } elseif(Auth::user()->role == 'Pegawai' || Auth::user()->role == 'SuperAdmin') {
                return redirect('surat_masuk');
            }
        } else {
            Session::flash('alert', [
                'type' => 'error',
                'title' => 'Login Gagal',
                'message' => 'NIK atau password tidak sesuai',
            ]);
            return redirect()->back()->withInput();
        }                
    }

    public function tambah_user(Request $request) {
        $validator = Validator::make($request->all(), [
            'nik' => 'required|unique:user,nik|size:16',            
            'nama' => 'required',
            'password' => 'required|min:4|max:12',
        ]);
        if ($validator->fails()) {
            Session::flash('alert', [
                'type' => 'error',
                'title' => 'Buat Akun Gagal',
                'message' => '',            
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

    public function keluar() 
    {
        Auth::logout();
        Session::flash('alert', [
            'type' => 'success',
            'title' => 'Logout Berhasil',
            'message' => "",
        ]);
        return redirect()->route("masuk");
    }

    public function ubah_kata_sandi(Request $request, $nik) 
    {
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
                ]);
                Session::flash('alert', [
                    'type' => 'success',
                    'title' => 'Ubah Password Berhasil',
                    'message' => '',
                ]);
                return back();
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

    public function ubah_profile(Request $request, $nik) 
    {
        $pengguna = User::where('nik', $nik)->first();
    
        if (!$pengguna) {
            Session::flash('alert', [
                'type' => 'error',
                'title' => 'Ubah Profile Gagal',
                'message' => '',
            ]);
            return back();
        }
    
        $validator = Validator::make($request->all(), [
            'ubah_nik' => $request->filled('ubah_nik') ? 'required' : '',
            'ubah_nama' => $request->filled('ubah_nama') ? 'required' : '',
            'password_old' => $request->filled('password_old') ? 'required' : '',
            'password_new' => $request->filled('password_new') ? 'required' : '',
        ]);
    
        if ($validator->fails()) {
            Session::flash('alert', [
                'type' => 'error',
                'title' => 'Ubah Profile Gagal',
                'message' => '',
            ]);
            return back();
        }
    
        if ($request->filled('password_old') && !password_verify($request->password_old, $pengguna->password)) {
            Session::flash('alert', [
                'type' => 'error',
                'title' => 'Ubah Profile Gagal',
                'message' => "Kata sandi lama salah.",
            ]);
            return back();
        }
    
        $updateData = [];
        if ($request->filled('ubah_nik')) {
            $updateData['nik'] = $request->ubah_nik;
        }
        if ($request->filled('ubah_nama')) {
            $updateData['nama'] = $request->ubah_nama;
        }
        if ($request->filled('password_new')) {
            $updateData['password'] = bcrypt($request->password_new);
        }
    
        $pengguna->update($updateData);
    
        Session::flash('alert', [
            'type' => 'success',
            'title' => 'Ubah Profile Berhasil',
            'message' => '',
        ]);
        
        return back();
    }
}