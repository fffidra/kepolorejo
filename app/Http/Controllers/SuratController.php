<?php

namespace App\Http\Controllers;

use App\Models\Jabatan;
use App\Models\Surat;
use App\Models\SKBelumMenikah;
use App\Models\SKDomisili;
use App\Models\SKTidakMampu;
use App\Models\SKUsaha;
use App\Models\User;
use App\Models\JenisSurat;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Validator;
use PhpOffice\PhpWord\IOFactory;
use PhpOffice\PhpWord\PhpWord;


class SuratController extends Controller
{
    public function index()
    {
        $surats = Surat::all();
        $sk_usaha = SKUsaha::all();
        $sk_belum_menikah = SKBelumMenikah::all();
        $skd = SKDomisili::all();
        $sktm = SKTidakMampu::all();
        $jabatan = Jabatan::all();
        $user = User::all();
        return view('surat.surat_masuk', compact('surats', 'sk_usaha', 'sk_belum_menikah', 'skd', 'sktm', 'jabatan', 'user'));
    }
    
    public function create()
    {
        $jenis_surat_yang_telah_diajukan = array_merge(
            SKUsaha::where('pemohon', auth()->user()->nik)->pluck('jenis_surat')->toArray(),
            SKBelumMenikah::where('pemohon', auth()->user()->nik)->pluck('jenis_surat')->toArray(),
            SKDomisili::where('pemohon', auth()->user()->nik)->pluck('jenis_surat')->toArray(),
            SKTidakMampu::where('pemohon', auth()->user()->nik)->pluck('jenis_surat')->toArray()
        );
    
        $semua_jenis_surat = JenisSurat::all();
    
        $jenis_surat_tersedia = [];
    
        foreach ($semua_jenis_surat as $jenis_surat) {
            if (!in_array($jenis_surat->nama_jenis_surat, $jenis_surat_yang_telah_diajukan)) {
                $jenis_surat_tersedia[] = $jenis_surat;
            }
        }
    
        // Tambahkan ini untuk debugging
        dd($jenis_surat_tersedia);
    
        return view('surat.req_surat', compact('jenis_surat_tersedia'));
    }
    
    

    public function surat_masuk(Request $request)
    {
        $sk_usaha = SKUsaha::where('status_surat', 'Diproses')->get();
        $sk_belum_menikah = SKBelumMenikah::where('status_surat', 'Diproses')->get();
        $skd = SKDomisili::where('status_surat', 'Diproses')->get();
        $sktm = SKTidakMampu::where('status_surat', 'Diproses')->get();
        return view('surat.surat_masuk', compact('sk_usaha', 'sk_belum_menikah', 'skd', 'sktm'));
    }

    public function surat_disetujui(Request $request)
    {
        $surat = Surat::where('status_surat', 'Disetujui')->get();
        $sk_usaha = SKUsaha::where('status_surat', 'Disetujui')->get();
        $sk_belum_menikah = SKBelumMenikah::where('status_surat', 'Disetujui')->get();
        $skd = SKDomisili::where('status_surat', 'Disetujui')->get();
        $sktm = SKTidakMampu::where('status_surat', 'Disetujui')->get();
        return view('surat.surat_disetujui', compact('surat', 'sk_usaha', 'sk_belum_menikah', 'skd', 'sktm'));
    }

    public function surat_ditolak(Request $request)
    {
        $surat = Surat::where('status_surat', 'Ditolak')->get();
        $sk_usaha = SKUsaha::where('status_surat', 'Ditolak')->get();
        $sk_belum_menikah = SKBelumMenikah::where('status_surat', 'Ditolak')->get();
        $skd = SKDomisili::where('status_surat', 'Ditolak')->get();
        $sktm = SKTidakMampu::where('status_surat', 'Ditolak')->get();
        return view('surat.surat_ditolak', compact('surat', 'sk_usaha', 'sk_belum_menikah', 'skd', 'sktm'));
    }

    public function buat_sku(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'jenis_surat_1' => 'required',
            'nama' => 'required',
            'nik' => 'required',
            'ttl' => 'required',
            'status_nikah' => 'required',
            'agama' => 'required',
            'pekerjaan' => 'required',
            'pekerjaan_lainnya' => 'nullable',
            'alamat' => 'required',
            'usaha' => 'required',
            'keperluan' => 'required',
            'bukti_suket' => 'required|mimes:jpg,jpeg,png,doc,docx,pdf',
            'bukti_kk' => 'required|mimes:jpg,jpeg,png,doc,docx,pdf',
            'bukti_ktp' => 'required|mimes:jpg,jpeg,png,doc,docx,pdf',
        ]);
        // dd($validator);

        if ($validator->fails()) {
            Session::flash('alert', [
                'type' => 'error',
                'title' => 'Pengajuan Surat Gagal',
                'message' => 'Ada data yang salah!'
            ]);
            return back()->withErrors($validator)->withInput();
        }
    
        $nik = Auth::user()->nik;
        
        $bukti_suket = $request->file('bukti_suket');
        $nama_bukti_suket = 'SUKET_' . $nik . '_' . date('Ymdhis') . '.' . $bukti_suket->getClientOriginalExtension();
        $bukti_suket->move(public_path('bukti_dokumen/SKU'), $nama_bukti_suket);

        $bukti_kk = $request->file('bukti_kk');
        $nama_bukti_kk = 'KK_' . $nik . '_' . date('Ymdhis') . '.' . $bukti_kk->getClientOriginalExtension();
        $bukti_kk->move(public_path('bukti_dokumen/SKU'), $nama_bukti_kk);

        $bukti_ktp = $request->file('bukti_ktp');
        $nama_bukti_ktp = 'KTP_' . $nik . '_' . date('Ymdhis') . '.' . $bukti_ktp->getClientOriginalExtension();
        $bukti_ktp->move(public_path('bukti_dokumen/SKU'), $nama_bukti_ktp);
    
        SKUsaha::create([
            'jenis_surat' => $request->jenis_surat_1,
            'nama' => $request->nama,
            'nik' => $request->nik,
            'ttl' => $request->ttl,
            'status_nikah' => $request->status_nikah,
            'agama' => $request->agama,
            'pekerjaan' => $request->pekerjaan,
            'pekerjaan_lainnya' => $request->pekerjaan == 'Lainnya' ? $request->pekerjaan_lainnya : null,
            'alamat' => $request->alamat,
            'usaha' => $request->usaha,
            'keperluan' => $request->keperluan,
            'bukti_suket' => $nama_bukti_suket,
            'bukti_kk' => $nama_bukti_kk,
            'bukti_ktp' => $nama_bukti_ktp,
            'pemohon' => auth()->user()->nik,
        ]);
    
        Session::flash('alert', [
            'type' => 'success',
            'title' => 'Pengajuan Surat Berhasil',
            'message' => ''
        ]);
    
        return back();
    }

    public function buat_skbm(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'jenis_surat_2' => 'required',
            'nama' => 'required',
            'nik' => 'required',
            'ttl' => 'required',
            'status_nikah' => 'required',
            'agama' => 'required',
            'pekerjaan_2' => 'required',
            'pekerjaan_lainnya_2' => 'nullable',
            'alamat' => 'required',
            'keperluan' => 'required',
            'bukti_suket' => 'required|mimes:jpg,jpeg,png,doc,docx,pdf',
            'bukti_kk' => 'required|mimes:jpg,jpeg,png,doc,docx,pdf',
            'bukti_ktp' => 'required|mimes:jpg,jpeg,png,doc,docx,pdf',
            'bukti_cerai' => 'nullable|mimes:jpg,jpeg,png,doc,docx,pdf',
            'bukti_kematian' => 'nullable|mimes:jpg,jpeg,png,doc,docx,pdf',
        ]);
        // dd($validator);

        if ($validator->fails()) {
            Session::flash('alert', [
                'type' => 'error',
                'title' => 'Pengajuan Surat Gagal',
                'message' => 'Ada data yang salah!'
            ]);
            return back()->withErrors($validator)->withInput();
        }
    
        $nik = Auth::user()->nik;
        
        $bukti_suket = $request->file('bukti_suket');
        $nama_bukti_suket = 'SUKET_' . $nik . '_' . date('Ymdhis') . '.' . $bukti_suket->getClientOriginalExtension();
        $bukti_suket->move(public_path('bukti_dokumen/SKBM'), $nama_bukti_suket);

        $bukti_kk = $request->file('bukti_kk');
        $nama_bukti_kk = 'KK_' . $nik . '_' . date('Ymdhis') . '.' . $bukti_kk->getClientOriginalExtension();
        $bukti_kk->move(public_path('bukti_dokumen/SKBM'), $nama_bukti_kk);

        $bukti_ktp = $request->file('bukti_ktp');
        $nama_bukti_ktp = 'KTP_' . $nik . '_' . date('Ymdhis') . '.' . $bukti_ktp->getClientOriginalExtension();
        $bukti_ktp->move(public_path('bukti_dokumen/SKBM'), $nama_bukti_ktp);

        $nama_bukti_cerai = null;
        $nama_bukti_kematian = null;

        // Proses file bukti_cerai jika ada
        if ($request->hasFile('bukti_cerai')) {
            $bukti_cerai = $request->file('bukti_cerai');
            $nama_bukti_cerai = 'KCR_' . $nik . '_' . date('Ymdhis') . '.' . $bukti_cerai->getClientOriginalExtension();
            $bukti_cerai->move(public_path('bukti_dokumen/SKBM'), $nama_bukti_cerai);
        }

        // Proses file bukti_kematian jika ada
        if ($request->hasFile('bukti_kematian')) {
            $bukti_kematian = $request->file('bukti_kematian');
            $nama_bukti_kematian = 'SKMTN_' . $nik . '_' . date('Ymdhis') . '.' . $bukti_kematian->getClientOriginalExtension();
            $bukti_kematian->move(public_path('bukti_dokumen/SKBM'), $nama_bukti_kematian);
        }
    
        SKBelumMenikah::create([
            'jenis_surat' => $request->jenis_surat_2,
            'nama' => $request->nama,
            'nik' => $request->nik,
            'ttl' => $request->ttl,
            'status_nikah' => $request->status_nikah,            
            'agama' => $request->agama,
            'pekerjaan' => $request->pekerjaan_2,
            'pekerjaan_lainnya' => $request->pekerjaan_2 == 'Lainnya' ? $request->pekerjaan_lainnya_2 : null,
            'alamat' => $request->alamat,
            'keperluan' => $request->keperluan,
            'bukti_suket' => $nama_bukti_suket,
            'bukti_kk' => $nama_bukti_kk,
            'bukti_ktp' => $nama_bukti_ktp,
            'bukti_cerai' => $nama_bukti_cerai,
            'bukti_kematian' => $nama_bukti_kematian,
            'pemohon' => auth()->user()->nik,
        ]);
    
        Session::flash('alert', [
            'type' => 'success',
            'title' => 'Pengajuan Surat Berhasil',
            'message' => ''
        ]);
    
        return back();
    }

    public function buat_skd(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'jenis_surat_3' => 'required',
            'nama' => 'required',
            'nik' => 'required',
            'jenis_kelamin' => 'required',
            'ttl' => 'required',
            'agama' => 'required',
            'status_nikah' => 'required',
            'pekerjaan_3' => 'required',
            'pekerjaan_lainnya_3' => 'nullable',
            'alamat' => 'required',
            'alamat_dom' => 'required',
            'keperluan' => 'required',
            'bukti_suket' => 'required|mimes:jpg,jpeg,png,doc,docx,pdf',
            'bukti_kk' => 'required|mimes:jpg,jpeg,png,doc,docx,pdf',
            'bukti_ktp' => 'required|mimes:jpg,jpeg,png,doc,docx,pdf',
        ]);
        // dd($validator);

        if ($validator->fails()) {
            Session::flash('alert', [
                'type' => 'error',
                'title' => 'Pengajuan Surat Gagal',
                'message' => 'Ada data yang salah!'
            ]);
            return back()->withErrors($validator)->withInput();
        }
    
        $nik = Auth::user()->nik;
        
        $bukti_suket = $request->file('bukti_suket');
        $nama_bukti_suket = 'SUKET_' . $nik . '_' . date('Ymdhis') . '.' . $bukti_suket->getClientOriginalExtension();
        $bukti_suket->move(public_path('bukti_dokumen/SKD'), $nama_bukti_suket);

        $bukti_kk = $request->file('bukti_kk');
        $nama_bukti_kk = 'KK_' . $nik . '_' . date('Ymdhis') . '.' . $bukti_kk->getClientOriginalExtension();
        $bukti_kk->move(public_path('bukti_dokumen/SKD'), $nama_bukti_kk);

        $bukti_ktp = $request->file('bukti_ktp');
        $nama_bukti_ktp = 'KTP_' . $nik . '_' . date('Ymdhis') . '.' . $bukti_ktp->getClientOriginalExtension();
        $bukti_ktp->move(public_path('bukti_dokumen/SKD'), $nama_bukti_ktp);
    
        SKDomisili::create([
            'jenis_surat' => $request->jenis_surat_3,
            'nama' => $request->nama,
            'nik' => $request->nik,
            'jenis_kelamin' => $request->jenis_kelamin,
            'ttl' => $request->ttl,
            'agama' => $request->agama,
            'status_nikah' => $request->status_nikah,            
            'pekerjaan' => $request->pekerjaan_3,
            'pekerjaan_lainnya' => $request->pekerjaan_3 == 'Lainnya' ? $request->pekerjaan_lainnya_3 : null,
            'alamat' => $request->alamat,
            'alamat_dom' => $request->alamat_dom,
            'keperluan' => $request->keperluan,
            'bukti_suket' => $nama_bukti_suket,
            'bukti_kk' => $nama_bukti_kk,
            'bukti_ktp' => $nama_bukti_ktp,
            'pemohon' => auth()->user()->nik,
        ]);
    
        Session::flash('alert', [
            'type' => 'success',
            'title' => 'Pengajuan Surat Berhasil',
            'message' => ''
        ]);
    
        return back();
    }

    public function buat_sktm(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'jenis_surat_4' => 'required',
            'nama' => 'required',
            'nik' => 'required',
            'ttl' => 'required',
            'agama' => 'required',
            'pekerjaan_4' => 'required',
            'pekerjaan_lainnya_4' => 'nullable',
            'alamat' => 'required',
            'keperluan' => 'required',
            'bukti_suket' => 'required|mimes:jpg,jpeg,png,doc,docx,pdf',
            'bukti_kk' => 'required|mimes:jpg,jpeg,png,doc,docx,pdf',
            'bukti_ktp' => 'required|mimes:jpg,jpeg,png,doc,docx,pdf',
        ]);
        // dd($validator);

        if ($validator->fails()) {
            Session::flash('alert', [
                'type' => 'error',
                'title' => 'Pengajuan Surat Gagal',
                'message' => 'Ada data yang salah!'
            ]);
            return back()->withErrors($validator)->withInput();
        }
    
        $nik = Auth::user()->nik;
        
        $bukti_suket = $request->file('bukti_suket');
        $nama_bukti_suket = 'SUKET_' . $nik . '_' . date('Ymdhis') . '.' . $bukti_suket->getClientOriginalExtension();
        $bukti_suket->move(public_path('bukti_dokumen/SKTM'), $nama_bukti_suket);

        $bukti_kk = $request->file('bukti_kk');
        $nama_bukti_kk = 'KK_' . $nik . '_' . date('Ymdhis') . '.' . $bukti_kk->getClientOriginalExtension();
        $bukti_kk->move(public_path('bukti_dokumen/SKTM'), $nama_bukti_kk);

        $bukti_ktp = $request->file('bukti_ktp');
        $nama_bukti_ktp = 'KTP_' . $nik . '_' . date('Ymdhis') . '.' . $bukti_ktp->getClientOriginalExtension();
        $bukti_ktp->move(public_path('bukti_dokumen/SKTM'), $nama_bukti_ktp);
    
        SKTidakMampu::create([
            'jenis_surat' => $request->jenis_surat_4,
            'nama' => $request->nama,
            'nik' => $request->nik,
            'ttl' => $request->ttl,
            'agama' => $request->agama,
            'pekerjaan' => $request->pekerjaan_4,
            'pekerjaan_lainnya' => $request->pekerjaan_4 == 'Lainnya' ? $request->pekerjaan_lainnya_4 : null,
            'alamat' => $request->alamat,
            'keperluan' => $request->keperluan,
            'bukti_suket' => $nama_bukti_suket,
            'bukti_kk' => $nama_bukti_kk,
            'bukti_ktp' => $nama_bukti_ktp,
            'pemohon' => auth()->user()->nik,
        ]);
    
        Session::flash('alert', [
            'type' => 'success',
            'title' => 'Pengajuan Surat Berhasil',
            'message' => ''
        ]);
    
        return back();
    }

    public function get_data_sku(Request $request)
    {
        $surat = SKUsaha::where('id_sk_usaha', $request->id)->first();
        if($surat)
        {
            return response()->json([
                'status'=>'success',
                'surat'=> $surat,
            ]);
        }
        else
        {
            return response()->json([
                'status'=>'error',
            ]);
        }
    }

    public function get_data_skbm(Request $request)
    {
        $surat = SKBelumMenikah::where('id_sk_belum_menikah', $request->id)->first();
        if($surat)
        {
            return response()->json([
                'status'=>'success',
                'surat'=> $surat,
            ]);
        }
        else
        {
            return response()->json([
                'status'=>'error',
            ]);
        }
    }

    public function get_data_skd(Request $request)
    {
        $surat = SKDomisili::where('id_sk_domisili', $request->id)->first();
        if($surat)
        {
            return response()->json([
                'status'=>'success',
                'surat'=> $surat,
            ]);
        }
        else
        {
            return response()->json([
                'status'=>'error',
            ]);
        }
    }

    public function get_data_sktm(Request $request)
    {
        $surat = SKTidakMampu::where('id_sk_tidak_mampu', $request->id)->first();
        if($surat)
        {
            return response()->json([
                'status'=>'success',
                'surat'=> $surat,
            ]);
        }
        else
        {
            return response()->json([
                'status'=>'error',
            ]);
        }
    }

    public function ubah_isi_sku($id_sk_usaha) 
    {
        $surat = SKUsaha::find($id_sk_usaha);
        return response()->json(['surat'=>$surat]);
    }

    public function ubah_isi_skbm($id_sk_belum_menikah) 
    {
        $surat = SKBelumMenikah::find($id_sk_belum_menikah);
        return response()->json(['surat'=>$surat]);
    }

    public function ubah_isi_skd($id_sk_domisili) 
    {
        $surat = SKDomisili::find($id_sk_domisili);
        return response()->json(['surat'=>$surat]);
    }

    public function ubah_isi_sktm($id_sk_tidak_mampu) 
    {
        $surat = SKTidakMampu::find($id_sk_tidak_mampu);
        return response()->json(['surat'=>$surat]);
    }

    public function ubah_sku(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'id_sk_usaha' => 'nullable',
            'jenis_surat' => 'nullable',
            'ubah_nama' => 'nullable',
            'ubah_nik' => 'nullable',
            'ubah_ttl' => 'nullable',
            'ubah_status_nikah' => 'nullable',
            'ubah_agama' => 'nullable',
            'ubah_pekerjaan' => 'nullable',
            'ubah_alamat' => 'nullable',
            'ubah_usaha' => 'nullable',
            'ubah_keperluan' => 'nullable',
        ]);

        // dd($validator);
        if ($validator->fails()) {
            Session::flash('alert', [
                'type' => 'error',
                'title' => 'Input Data Gagal',
                'message' => 'Ada inputan yang salah!',
            ]);
        } else {
            $surat = SKUsaha::where('id_sk_usaha', $request->id_sk_usaha)->first();


            if($surat){
                $surat->update([
                    'id_sk_usaha' => $request->id_sk_usaha,
                    'jenis_surat' => $request->jenis_surat,
                    'nama' => $request->ubah_nama,
                    'nik' => $request->ubah_nik,
                    'ttl' => $request->ubah_ttl,
                    'status_nikah' => $request->ubah_status_nikah,
                    'agama' => $request->ubah_agama,
                    'pekerjaan' => $request->ubah_pekerjaan,
                    'alamat' => $request->ubah_alamat,
                    'usaha' => $request->ubah_usaha,
                    'keperluan' => $request->ubah_keperluan,
                    'jabatan' => $request->ubah_jabatan
                ]);
                Session::flash('alert', [
                    'type' => 'success',
                    'title' => 'Edit Data Berhasil',
                    'message' => "",
                ]);
                        // dd($surat);
            } else {
                Session::flash('alert', [
                    'type' => 'error',
                    'title' => 'Input Data Gagal',
                    'message' => 'Ada inputan yang salah!',
                ]); 
            }
        }
        return back();
    }

    public function ubah_skbm(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'id_sk_belum_menikah' => 'nullable',
            'jenis_surat_2' => 'nullable',
            'ubah_nama_2' => 'nullable',
            'ubah_nik_2' => 'nullable',
            'ubah_ttl_2' => 'nullable',
            'ubah_status_nikah_2' => 'nullable',
            'ubah_agama_2' => 'nullable',
            'ubah_pekerjaan_2' => 'nullable',
            'ubah_alamat_2' => 'nullable',
            'ubah_keperluan_2' => 'nullable',
            'ubah_jabatan_2' => 'nullable'
        ]);

        // dd($validator);
        if ($validator->fails()) {
            Session::flash('alert', [
                'type' => 'error',
                'title' => 'Input Data Gagal',
                'message' => 'Ada inputan yang salah!',
            ]);
        } else {
            $surat = SKBelumMenikah::where('id_sk_belum_menikah', $request->id_sk_belum_menikah)->first();

            if($surat){
                $surat->update([
                    'id_sk_belum_menikah' => $request->id_sk_belum_menikah,
                    'jenis_surat' => $request->jenis_surat_2,
                    'nama' => $request->ubah_nama_2,
                    'nik' => $request->ubah_nik_2,
                    'ttl' => $request->ubah_ttl_2,
                    'status_nikah' => $request->ubah_status_nikah_2,
                    'agama' => $request->ubah_agama_2,
                    'pekerjaan' => $request->ubah_pekerjaan_2,
                    'alamat' => $request->ubah_alamat_2,
                    'keperluan' => $request->ubah_keperluan_2,
                    'jabatan' => $request->ubah_jabatan_2
                ]);
                Session::flash('alert', [
                    'type' => 'success',
                    'title' => 'Edit Data Berhasil',
                    'message' => "",
                ]);
            } else {
                Session::flash('alert', [
                    'type' => 'error',
                    'title' => 'Input Data Gagal',
                    'message' => 'Ada inputan yang salah!',
                ]); 
            }
        }
        return back();
    }

    public function ubah_skd(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'id_sk_domisili' => 'nullable',
            'jenis_surat_3' => 'nullable',
            'ubah_nama_3' => 'nullable',
            'ubah_nik_3' => 'nullable',
            'ubah_jenis_kelamin' => 'nullable',
            'ubah_ttl_3' => 'nullable',
            'ubah_agama_3' => 'nullable',
            'ubah_status_nikah_3' => 'nullable',
            'ubah_pekerjaan_3' => 'nullable',
            'ubah_alamat_3' => 'nullable',
            'ubah_alamat_dom' => 'nullable',
            'ubah_keperluan_3' => 'nullable',
            'ubah_jabatan_3' => 'nullable'
        ]);

        // dd($validator);
        if ($validator->fails()) {
            Session::flash('alert', [
                'type' => 'error',
                'title' => 'Input Data Gagal',
                'message' => 'Ada inputan yang salah!',
            ]);
        } else {
            $surat = SKDomisili::where('id_sk_domisili', $request->id_sk_domisili)->first();

            if($surat){
                $surat->update([
                    'id_sk_domisili' => $request->id_sk_domisili,
                    'jenis_surat' => $request->jenis_surat_3,
                    'nama' => $request->ubah_nama_3,
                    'nik' => $request->ubah_nik_3,
                    'jenis_kelamin' => $request->ubah_jenis_kelamin,
                    'ttl' => $request->ubah_ttl_3,
                    'agama' => $request->ubah_agama_3,
                    'status_nikah' => $request->ubah_status_nikah_3,
                    'pekerjaan' => $request->ubah_pekerjaan_3,
                    'alamat' => $request->ubah_alamat_3,
                    'alamat_dom' => $request->ubah_alamat_dom,
                    'keperluan' => $request->ubah_keperluan_3,
                    'jabatan' => $request->ubah_jabatan_3
                ]);
                Session::flash('alert', [
                    'type' => 'success',
                    'title' => 'Edit Data Berhasil',
                    'message' => "",
                ]);
            } else {
                Session::flash('alert', [
                    'type' => 'error',
                    'title' => 'Input Data Gagal',
                    'message' => 'Ada inputan yang salah!',
                ]); 
            }
        }
        return back();
    }

    public function ubah_sktm(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'id_sk_tidak_mampu' => 'nullable',
            'jenis_surat_4' => 'nullable',
            'ubah_nama_4' => 'nullable',
            'ubah_nik_4' => 'nullable',
            'ubah_ttl_4' => 'nullable',
            'ubah_agama_4' => 'nullable',
            'ubah_pekerjaan_4' => 'nullable',
            'ubah_alamat_4' => 'nullable',
            'ubah_keperluan_4' => 'nullable',
            'ubah_jabatan_4' => 'nullable'
        ]);

        // dd($validator);
        if ($validator->fails()) {
            Session::flash('alert', [
                'type' => 'error',
                'title' => 'Input Data Gagal',
                'message' => 'Ada inputan yang salah!',
            ]);
        } else {
            $surat = SKTidakMampu::where('id_sk_tidak_mampu', $request->id_sk_tidak_mampu)->first();

            if($surat){
                $surat->update([
                    'id_sk_tidak_mampu' => $request->id_sk_tidak_mampu,
                    'jenis_surat' => $request->jenis_surat_4,
                    'nama' => $request->ubah_nama_4,
                    'nik' => $request->ubah_nik_4,
                    'ttl' => $request->ubah_ttl_4,
                    'agama' => $request->ubah_agama_4,
                    'pekerjaan' => $request->ubah_pekerjaan_4,
                    'alamat' => $request->ubah_alamat_4,
                    'keperluan' => $request->ubah_keperluan_4,
                    'jabatan' => $request->ubah_jabatan_4
                ]);
                Session::flash('alert', [
                    'type' => 'success',
                    'title' => 'Edit Data Berhasil',
                    'message' => "",
                ]);
            } else {
                Session::flash('alert', [
                    'type' => 'error',
                    'title' => 'Input Data Gagal',
                    'message' => 'Ada inputan yang salah!',
                ]); 
            }
        }
        return back();
    }

    public function sku_tolak(Request $request, $id_sk_usaha) 
    {
        $verifikator = Auth::user()->nama;
        $surat = SKUsaha::findOrFail($id_sk_usaha);
        
        if ($surat && $surat->status_surat === 'Diproses') {
            switch ($request->aksi) {
                case 'setuju':
                    $surat->status_surat = 'Disetujui';
                    $message = 'Surat berhasil disetujui';
                    $type = 'success';
                    break;
                case 'tolak':
                    $surat->status_surat = 'Ditolak';
                    $surat->pesan = $request->alasan_tolak;
                    $message = 'Surat berhasil ditolak';
                    $type = 'error';
                    break;
                default:
                    // Do nothing
                    break;
            }
            
            $surat->verifikator = $verifikator;  
            $surat->save();

            Session::flash('alert', [
                'type' => $type,
                'title' => 'Proses Berhasil',
                'message' => $message,
            ]);
        } else {
            Session::flash('alert', [
                'type' => 'error',
                'title' => 'Kirim Data Gagal',
                'message' => 'Terjadi Error!'
            ]);
        }
        return back();
    }

    public function skbm_tolak(Request $request, $id_sk_belum_menikah) 
    {
        $verifikator = Auth::user()->nama;
        $surat = SKBelumMenikah::findOrFail($id_sk_belum_menikah);
        
        if ($surat && $surat->status_surat === 'Diproses') {
            switch ($request->aksi) {
                case 'setuju':
                    $surat->status_surat = 'Disetujui';
                    $message = 'Surat berhasil disetujui';
                    $type = 'success';
                    break;
                case 'tolak':
                    $surat->status_surat = 'Ditolak';
                    $surat->pesan = $request->alasan_tolak;
                    $message = 'Surat berhasil ditolak';
                    $type = 'error';
                    break;
                default:
                    // Do nothing
                    break;
            }
            
            $surat->verifikator = $verifikator;  
            $surat->save();

            Session::flash('alert', [
                'type' => $type,
                'title' => 'Proses Berhasil',
                'message' => $message,
            ]);
        } else {
            Session::flash('alert', [
                'type' => 'error',
                'title' => 'Kirim Data Gagal',
                'message' => 'Terjadi Error!'
            ]);
        }
        return back();
    }

    public function skd_tolak(Request $request, $id_sk_domisili) 
    {
        $verifikator = Auth::user()->nama;
        $surat = SKDomisili::findOrFail($id_sk_domisili);
        
        if ($surat && $surat->status_surat === 'Diproses') {
            switch ($request->aksi) {
                case 'setuju':
                    $surat->status_surat = 'Disetujui';
                    $message = 'Surat berhasil disetujui';
                    $type = 'success';
                    break;
                case 'tolak':
                    $surat->status_surat = 'Ditolak';
                    $surat->pesan = $request->alasan_tolak;
                    $message = 'Surat berhasil ditolak';
                    $type = 'error';
                    break;
                default:
                    // Do nothing
                    break;
            }
            
            $surat->verifikator = $verifikator;  
            $surat->save();

            Session::flash('alert', [
                'type' => $type,
                'title' => 'Proses Berhasil',
                'message' => $message,
            ]);
        } else {
            Session::flash('alert', [
                'type' => 'error',
                'title' => 'Kirim Data Gagal',
                'message' => 'Terjadi Error!'
            ]);
        }
        return back();
    }

    public function sktm_tolak(Request $request, $id_sk_tidak_mampu) 
    {
        $verifikator = Auth::user()->nama;
        $surat = SKTidakMampu::findOrFail($id_sk_tidak_mampu);
        
        if ($surat && $surat->status_surat === 'Diproses') {
            switch ($request->aksi) {
                case 'setuju':
                    $surat->status_surat = 'Disetujui';
                    $message = 'Surat berhasil disetujui';
                    $type = 'success';
                    break;
                case 'tolak':
                    $surat->status_surat = 'Ditolak';
                    $surat->pesan = $request->alasan_tolak;
                    $message = 'Surat berhasil ditolak';
                    $type = 'error';
                    break;
                default:
                    // Do nothing
                    break;
            }
            
            $surat->verifikator = $verifikator;  
            $surat->save();

            Session::flash('alert', [
                'type' => $type,
                'title' => 'Proses Berhasil',
                'message' => $message,
            ]);
        } else {
            Session::flash('alert', [
                'type' => 'error',
                'title' => 'Kirim Data Gagal',
                'message' => 'Terjadi Error!'
            ]);
        }
        return back();
    }

    public function sku_setuju($id_sk_usaha) 
    {
        $surat = SKUsaha::find($id_sk_usaha);
        $verifikator = Auth::user()->nama;
    
        if($surat) {
            $surat->status_surat = 'Disetujui'; 
            $surat->verifikator = $verifikator;  
    
            if($surat->save()) {
                Session::flash('alert', [
                    'type' => 'success',
                    'title' => 'Surat Berhasil Disetujui',
                    'message' => ''
                ]);
            } else {
                Session::flash('alert', [
                    'type' => 'error',
                    'title' => 'Surat Gagal Disetujui',
                    'message' => ''
                ]);
            }
        } else {
            Session::flash('alert', [
                'type' => 'error',
                'title' => 'Kirim Data Gagal',
                'message' => 'Data surat tidak ditemukan.'
            ]);
        }
        return back();
    }

    public function skbm_setuju($id_sk_belum_menikah) 
    {
        $surat = SKBelumMenikah::find($id_sk_belum_menikah);
        $verifikator = Auth::user()->nama;
    
        if($surat) {
            $surat->status_surat = 'Disetujui'; 
            $surat->verifikator = $verifikator;  
    
            if($surat->save()) {
                Session::flash('alert', [
                    'type' => 'success',
                    'title' => 'Surat Berhasil Disetujui',
                    'message' => ''
                ]);
            } else {
                Session::flash('alert', [
                    'type' => 'error',
                    'title' => 'Surat Gagal Disetujui',
                    'message' => ''
                ]);
            }
        } else {
            Session::flash('alert', [
                'type' => 'error',
                'title' => 'Kirim Data Gagal',
                'message' => 'Data surat tidak ditemukan.'
            ]);
        }
        return back();
    }

    public function skd_setuju($id_sk_domisili) 
    {
        $surat = SKDomisili::find($id_sk_domisili);
        $verifikator = Auth::user()->nama;
    
        if($surat) {
            $surat->status_surat = 'Disetujui'; 
            $surat->verifikator = $verifikator;  
    
            if($surat->save()) {
                Session::flash('alert', [
                    'type' => 'success',
                    'title' => 'Surat Berhasil Disetujui',
                    'message' => ''
                ]);
            } else {
                Session::flash('alert', [
                    'type' => 'error',
                    'title' => 'Surat Gagal Disetujui',
                    'message' => ''
                ]);
            }
        } else {
            Session::flash('alert', [
                'type' => 'error',
                'title' => 'Kirim Data Gagal',
                'message' => 'Data surat tidak ditemukan.'
            ]);
        }
        return back();
    }

    public function sktm_setuju($id_sk_tidak_mampu) 
    {
        $surat = SKTidakMampu::find($id_sk_tidak_mampu);
        $verifikator = Auth::user()->nama;
    
        if($surat) {
            $surat->status_surat = 'Disetujui'; 
            $surat->verifikator = $verifikator;  
    
            if($surat->save()) {
                Session::flash('alert', [
                    'type' => 'success',
                    'title' => 'Surat Berhasil Disetujui',
                    'message' => ''
                ]);
            } else {
                Session::flash('alert', [
                    'type' => 'error',
                    'title' => 'Surat Gagal Disetujui',
                    'message' => ''
                ]);
            }
        } else {
            Session::flash('alert', [
                'type' => 'error',
                'title' => 'Kirim Data Gagal',
                'message' => 'Data surat tidak ditemukan.'
            ]);
        }
        return back();
    }

    public function sku_selesai($id_sk_usaha) 
    {
        $surat = SKUsaha::find($id_sk_usaha);
    
        if($surat) {
            $surat->status_surat = 'Selesai'; 
    
            if($surat->save()) {
                Session::flash('alert', [
                    'type' => 'success',
                    'title' => 'Surat Berhasil Disimpan',
                    'message' => ''
                ]);
            } else {
                Session::flash('alert', [
                    'type' => 'error',
                    'title' => 'Surat Gagal Disimpan',
                    'message' => ''
                ]);
            }
        } else {
            Session::flash('alert', [
                'type' => 'error',
                'title' => 'Terjadi Kesalahan',
                'message' => 'Gagal menyimpan status surat.'
            ]);
        }
        return back();
    }

    public function skbm_selesai($id_sk_belum_menikah) 
    {
        $surat = SKBelumMenikah::find($id_sk_belum_menikah);
    
        if($surat) {
            $surat->status_surat = 'Selesai'; 
    
            if($surat->save()) {
                Session::flash('alert', [
                    'type' => 'success',
                    'title' => 'Surat Berhasil Disimpan',
                    'message' => ''
                ]);
            } else {
                Session::flash('alert', [
                    'type' => 'error',
                    'title' => 'Surat Gagal Disimpan',
                    'message' => ''
                ]);
            }
        } else {
            Session::flash('alert', [
                'type' => 'error',
                'title' => 'Terjadi Kesalahan',
                'message' => 'Gagal menyimpan status surat.'
            ]);
        }
        return back();
    }

    public function skd_selesai($id_sk_domisili) 
    {
        $surat = SKDomisili::find($id_sk_domisili);
    
        if($surat) {
            $surat->status_surat = 'Selesai'; 
    
            if($surat->save()) {
                Session::flash('alert', [
                    'type' => 'success',
                    'title' => 'Surat Berhasil Disimpan',
                    'message' => ''
                ]);
            } else {
                Session::flash('alert', [
                    'type' => 'error',
                    'title' => 'Surat Gagal Disimpan',
                    'message' => ''
                ]);
            }
        } else {
            Session::flash('alert', [
                'type' => 'error',
                'title' => 'Terjadi Kesalahan',
                'message' => 'Gagal menyimpan status surat.'
            ]);
        }
        return back();
    }

    public function sktm_selesai($id_sk_tidak_mampu) 
    {
        $surat = SKTidakMampu::find($id_sk_tidak_mampu);
    
        if($surat) {
            $surat->status_surat = 'Selesai'; 
    
            if($surat->save()) {
                Session::flash('alert', [
                    'type' => 'success',
                    'title' => 'Surat Berhasil Disimpan',
                    'message' => ''
                ]);
            } else {
                Session::flash('alert', [
                    'type' => 'error',
                    'title' => 'Surat Gagal Disimpan',
                    'message' => ''
                ]);
            }
        } else {
            Session::flash('alert', [
                'type' => 'error',
                'title' => 'Terjadi Kesalahan',
                'message' => 'Gagal menyimpan status surat.'
            ]);
        }
        return back();
    }

    public function hapus_sku($id_sk_usaha) 
    {
        $surat = SKUsaha::findOrFail($id_sk_usaha);

        if($surat) {
            Session::flash('alert', [
                'type' => 'success',
                'title' => 'Hapus Surat '.$surat->nama.' Berhasil',
                'message' => "",
            ]); 
            $surat->delete();
        } else {
            Session::flash('alert', [
                'type' => 'error',
                'title' => 'Hapus Surat Gagal',
                'message' => '',
            ]); 
        }
        return back();
    }

    public function hapus_skbm($id_sk_belum_menikah) 
    {
        $surat = SKBelumMenikah::findOrFail($id_sk_belum_menikah);
        
        if($surat) {
            Session::flash('alert', [
                'type' => 'success',
                'title' => 'Hapus Surat '.$surat->nama.' Berhasil',
                'message' => "",
            ]); 
            $surat->delete();
        } else {
            Session::flash('alert', [
                'type' => 'error',
                'title' => 'Hapus Surat Gagal',
                'message' => '',
            ]); 
        }
        return back();
    }

    public function hapus_skd($id_sk_domisili) 
    {
        $surat = SKDomisili::findOrFail($id_sk_domisili);
        
        if($surat) {
            Session::flash('alert', [
                'type' => 'success',
                'title' => 'Hapus Surat '.$surat->nama.' Berhasil',
                'message' => "",
            ]); 
            $surat->delete();
        } else {
            Session::flash('alert', [
                'type' => 'error',
                'title' => 'Hapus Surat Gagal',
                'message' => '',
            ]); 
        }
        return back();
    }

    public function hapus_sktm($id_sk_tidak_mampu) 
    {
        $surat = SKTidakMampu::findOrFail($id_sk_tidak_mampu);
        
        if($surat) {
            Session::flash('alert', [
                'type' => 'success',
                'title' => 'Hapus Surat '.$surat->nama.' Berhasil',
                'message' => "",
            ]); 
            $surat->delete();
        } else {
            Session::flash('alert', [
                'type' => 'error',
                'title' => 'Hapus Surat Gagal',
                'message' => '',
            ]); 
        }
        return back();
    }

    public function unduh_sku($id_sk_usaha)
    {
        $surat = SKUsaha::findOrFail($id_sk_usaha);
        $jabatan = Jabatan::where('peran', 'Penanda Tangan')->first();

        $jenisSurat = $surat->jenis_surat;
        $year = date('Y');
        $jabatanNama = $jabatan->nama;
        $jabatanNamaJabatan = $jabatan->nama_jabatan;
        $jabatanPosisi = $jabatan->posisi;
        $jabatanNIP = $jabatan->nip;

        if ($surat->pekerjaan == 'Lainnya' && !empty($surat->pekerjaan_lainnya)) {
            $pekerjaan = $surat->pekerjaan_lainnya;
        } else {
            $pekerjaan = $surat->pekerjaan;
        }

        $phpWord = new PhpWord();
        $section = $phpWord->addSection([
            'marginTop'    => 600,  
            'marginBottom' => 600, 
            'marginRight'  => 600,
            'marginLeft'   => 600
        ]);        
        $table = $section->addTable();
        $row = $table->addRow();
        $lebarA4 = 21 * 600; 

        // KOP SURAT
            $row->addCell(2800)->addImage(public_path("Logo_Kabupaten_Magetan_Vector.jpg"), array('align' => 'center', 'width' => 75));
            $row->addCell(7200)->addImage(public_path("kop.png"), array('align' => 'center', 'width' => 340 ));
            $section->addLine(['weight' => 2,'width' => 535, 'height' => 0]);

        // ISI SURAT
            $textRunHeader = $section->addTextRun(['alignment' => 'center']);
            $textRunHeader->addText(strtoupper($jenisSurat), ['bold' => true, 'underline' => 'single', 'size' => 16]);            
            $textRunHeader->addTextBreak();
            $textRunHeader->addText('Nomor : 500.3.4.3/     /403.406.6/' . $year, ['size' => 12]);
            
            $section->addTextBreak();

            $paragraph1 = 'Yang bertanda tangan di bawah ini Lurah Kepolorejo Kecamatan Magetan Kabupaten Magetan, menerangkan dengan sebenarnya bahwa : ';
            $section->addText($paragraph1, ['size' => 12], ['alignment' => 'both', 'indentation' => ['left' => 700, 'right' => 700,'firstLine' => 1000]]);
            
            $section->addTextBreak();

            $tableNama = $section->addTable(['borderSize' => 0, 'alignment' => 'center', 'borderColor' => 'white']);
            $tableNama->addRow();
            $tableNama->addCell($lebarA4 * 0.10)->addText('');
            $tableNama->addCell($lebarA4 * 0.20)->addText('Nama', ['size' => 12]);
            $tableNama->addCell($lebarA4 * 0.05)->addText(':', ['size' => 12], array('align' => 'center'));
            $tableNama->addCell($lebarA4 * 0.65)->addText($surat->nama, ['bold' => true, 'allCaps' => true, 'size' => 12]);

            $tableNIK = $section->addTable(['borderSize' => 0, 'alignment' => 'center', 'borderColor' => 'white']);
            $tableNIK->addRow();
            $tableNIK->addCell($lebarA4 * 0.10)->addText('');
            $tableNIK->addCell($lebarA4 * 0.20)->addText('NIK', ['size' => 12]);
            $tableNIK->addCell($lebarA4 * 0.05)->addText(':', ['size' => 12], array('align' => 'center'));
            $tableNIK->addCell($lebarA4 * 0.65)->addText($surat->nik, ['size' => 12]);

            $tableTtl = $section->addTable(['borderSize' => 0, 'alignment' => 'center', 'borderColor' => 'white']);
            $tableTtl->addRow();
            $tableTtl->addCell($lebarA4 * 0.10)->addText('');
            $tableTtl->addCell($lebarA4 * 0.20)->addText('Tempat/Tgl Lahir', ['size' => 12]);
            $tableTtl->addCell($lebarA4 * 0.05)->addText(':', ['size' => 12], array('align' => 'center'));
            $tableTtl->addCell($lebarA4 * 0.65)->addText($surat->ttl, ['size' => 12]);

            $tableStatus = $section->addTable(['borderSize' => 0, 'alignment' => 'center', 'borderColor' => 'white']);
            $tableStatus->addRow();
            $tableStatus->addCell($lebarA4 * 0.10)->addText('');
            $tableStatus->addCell($lebarA4 * 0.20)->addText('Status', ['size' => 12]);
            $tableStatus->addCell($lebarA4 * 0.05)->addText(':', ['size' => 12], array('align' => 'center'));
            $tableStatus->addCell($lebarA4 * 0.65)->addText($surat->status_nikah, ['size' => 12]);

            $tableAgama = $section->addTable(['borderSize' => 0, 'alignment' => 'center', 'borderColor' => 'white']);
            $tableAgama->addRow();
            $tableAgama->addCell($lebarA4 * 0.10)->addText('');
            $tableAgama->addCell($lebarA4 * 0.20)->addText('Agama', ['size' => 12]);
            $tableAgama->addCell($lebarA4 * 0.05)->addText(':', ['size' => 12], array('align' => 'center'));
            $tableAgama->addCell($lebarA4 * 0.65)->addText($surat->agama, ['size' => 12]);

            $tablePekerjaan = $section->addTable(['borderSize' => 0, 'alignment' => 'center', 'borderColor' => 'white']);
            $tablePekerjaan->addRow();
            $tablePekerjaan->addCell($lebarA4 * 0.10)->addText('');
            $tablePekerjaan->addCell($lebarA4 * 0.20)->addText('Pekerjaan', ['size' => 12]);
            $tablePekerjaan->addCell($lebarA4 * 0.05)->addText(':', ['size' => 12], array('align' => 'center'));
            $tablePekerjaan->addCell($lebarA4 * 0.65)->addText($pekerjaan, ['size' => 12]);
            
            $tableAlamat = $section->addTable(['borderSize' => 0, 'alignment' => 'center', 'borderColor' => 'white']);
            $tableAlamat->addRow();
            $tableAlamat->addCell($lebarA4 * 0.10)->addText('');
            $tableAlamat->addCell($lebarA4 * 0.20)->addText('Alamat', ['size' => 12]);
            $tableAlamat->addCell($lebarA4 * 0.05)->addText(':', ['size' => 12], array('align' => 'center'));
            $tableAlamat->addCell($lebarA4 * 0.65)->addText($surat->alamat, ['size' => 12]);

            $tableKeterangan = $section->addTable(['borderSize' => 0, 'alignment' => 'center', 'borderColor' => 'white']);
            $tableKeterangan->addRow();
            $tableKeterangan->addCell($lebarA4 * 0.10)->addText('');
            $tableKeterangan->addCell($lebarA4 * 0.20)->addText('Keterangan', ['size' => 12]);
            $tableKeterangan->addCell($lebarA4 * 0.05)->addText(':', ['size' => 12], array('align' => 'center'));
            $tableKeterangan->addCell($lebarA4 * 0.65)->addText('Berdasarkan Surat Pernyataan yang dibuat, menerangkan bahwa orang tersebut diatas benar memiliki usaha '. $surat->usaha, ['size' => 12]);

            $tableKeperluan = $section->addTable(['borderSize' => 0, 'alignment' => 'center', 'borderColor' => 'white']);
            $tableKeperluan->addRow();
            $tableKeperluan->addCell($lebarA4 * 0.10)->addText('');
            $tableKeperluan->addCell($lebarA4 * 0.20)->addText('Keperluan', ['size' => 12]);
            $tableKeperluan->addCell($lebarA4 * 0.05)->addText(':', ['size' => 12], array('align' => 'center'));
            $tableKeperluan->addCell($lebarA4 * 0.65)->addText('Untuk '. $surat->keperluan, ['size' => 12]);

            $section->addTextBreak();        

        // PENUTUP
            $paragraph2 = 'Demikian Surat Keterangan ini dibuat dan dapat dipergunakan sebagaimana mestinya.';
            $section->addText($paragraph2, ['size' => 12], ['alignment' => 'both', 'indentation' => ['left' => 700, 'right' => 700,'firstLine' => 1000]]);

            $section->addTextBreak();
            $section->addTextBreak();

        // TANDA TANGAN 
            $tableFoot = $section->addTable(['width' => 100, 'borderColor' => 'white', 'borderSize' => 1, 'alignment' => 'right']);
            $tanggalLengkap = Carbon::parse(now())->locale('id_ID')->isoFormat('DD MMMM YYYY');
            $tableFoot->addRow();
            $tableFoot->addCell(5000)->addText('Magetan, ' . $tanggalLengkap, ['size' => 12], array('align' => 'center'));
            $tableFoot->addCell(550)->addText('');
            $tableFoot->addRow();            
            $tableFoot->addCell(5000)->addText('LURAH KEPOLOREJO', ['size' => 12], array('align' => 'center'));

            if ($jabatanNamaJabatan !== 'Lurah') {
                $tableFoot->addRow();            
                $tableFoot->addCell(5000)->addText('An. '.$jabatanNamaJabatan, ['size' => 12], array('align' => 'center'));
                $tableFoot->addRow();
                $tableFoot->addCell(5000)->addText('');
    
            }

            $tableFoot->addRow();
            $tableFoot->addCell(5000)->addText('');

            $tableFoot->addRow();
            $tableFoot->addCell(5000)->addText('');

            $tableFoot->addRow();
            $tableFoot->addCell(5000)->addText('');

            $tableFoot->addRow();
            $tableFoot->addCell(5000)->addText($jabatanNama, ['size' => 12, 'bold' => true, 'underline' => 'single'], ['align' => 'center']);
            $tableFoot->addRow();
            $tableFoot->addCell(5000)->addText($jabatanPosisi, ['size' => 12], ['align' => 'center']);

            $tableFoot->addRow();
            $tableFoot->addCell(5000)->addText('NIP. ' . $jabatanNIP, ['size' => 12], ['align' => 'center']);

            $section->addTextBreak();

        $filename = ucfirst(str_replace('_', ' ', $surat->jenis_surat)) . ' ' . date('Y-m-d H-i-s') . '.docx';
        $filepath = storage_path('app/' . $filename);
        $objWriter = IOFactory::createWriter($phpWord, 'Word2007');
        $objWriter->save($filepath);

        return response()->download($filepath)->deleteFileAfterSend(true);
    }

    public function unduh_skbm($id_sk_belum_menikah)
    {
        $surat = SKBelumMenikah::findOrFail($id_sk_belum_menikah);
        $jabatan = Jabatan::where('peran', 'Penanda Tangan')->first();
        $jenisSurat = $surat->jenis_surat;
        $year = date('Y');
        
        $jabatanNama = $jabatan->nama;
        $jabatanNamaJabatan = $jabatan->nama_jabatan;
        $jabatanPosisi = $jabatan->posisi;
        $jabatanNIP = $jabatan->nip;

        if ($surat->pekerjaan == 'Lainnya' && !empty($surat->pekerjaan_lainnya)) {
            $pekerjaan = $surat->pekerjaan_lainnya;
        } else {
            $pekerjaan = $surat->pekerjaan;
        }

        $phpWord = new PhpWord();
        $section = $phpWord->addSection([
            'marginTop'    => 600,  
            'marginBottom' => 600, 
            'marginRight'  => 600,
            'marginLeft'   => 600
        ]);        
        $table = $section->addTable();
        $row = $table->addRow();
        $lebarA4 = 21 * 600; 

        // KOP SURAT
            $row->addCell(2800)->addImage(public_path("Logo_Kabupaten_Magetan_Vector.jpg"), array('align' => 'center', 'width' => 75));
            $row->addCell(7200)->addImage(public_path("kop.png"), array('align' => 'center', 'width' => 340 ));
            $section->addLine(['weight' => 2,'width' => 535, 'height' => 0]);

        // ISI SURAT
            $textRunHeader = $section->addTextRun(['alignment' => 'center']);
            $textRunHeader->addText(strtoupper($jenisSurat), ['bold' => true, 'underline' => 'single', 'size' => 16]);            
            $textRunHeader->addTextBreak();
            $textRunHeader->addText('Nomor : 500.3.4.3/     /403.406.6/' . $year, ['size' => 12]);
            
            $section->addTextBreak();

            $paragraph1 = 'Yang bertanda tangan di bawah ini Lurah Kepolorejo Kecamatan Magetan Kabupaten Magetan, menerangkan dengan sebenarnya bahwa : ';
            $section->addText($paragraph1, ['size' => 12], ['alignment' => 'both', 'indentation' => ['left' => 700, 'right' => 700,'firstLine' => 1000]]);
            
            $section->addTextBreak();

            $tableNama = $section->addTable(['borderSize' => 0, 'alignment' => 'center', 'borderColor' => 'white']);
            $tableNama->addRow();
            $tableNama->addCell($lebarA4 * 0.10)->addText('');
            $tableNama->addCell($lebarA4 * 0.20)->addText('Nama', ['size' => 12]);
            $tableNama->addCell($lebarA4 * 0.05)->addText(':', ['size' => 12], array('align' => 'center'));
            $tableNama->addCell($lebarA4 * 0.65)->addText($surat->nama, ['bold' => true, 'allCaps' => true, 'size' => 12]);

            $tableNIK = $section->addTable(['borderSize' => 0, 'alignment' => 'center', 'borderColor' => 'white']);
            $tableNIK->addRow();
            $tableNIK->addCell($lebarA4 * 0.10)->addText('');
            $tableNIK->addCell($lebarA4 * 0.20)->addText('NIK', ['size' => 12]);
            $tableNIK->addCell($lebarA4 * 0.05)->addText(':', ['size' => 12], array('align' => 'center'));
            $tableNIK->addCell($lebarA4 * 0.65)->addText($surat->nik, ['size' => 12]);

            $tableTtl = $section->addTable(['borderSize' => 0, 'alignment' => 'center', 'borderColor' => 'white']);
            $tableTtl->addRow();
            $tableTtl->addCell($lebarA4 * 0.10)->addText('');
            $tableTtl->addCell($lebarA4 * 0.20)->addText('Tempat/Tgl Lahir', ['size' => 12]);
            $tableTtl->addCell($lebarA4 * 0.05)->addText(':', ['size' => 12], array('align' => 'center'));
            $tableTtl->addCell($lebarA4 * 0.65)->addText($surat->ttl, ['size' => 12]);

            $tableAgama = $section->addTable(['borderSize' => 0, 'alignment' => 'center', 'borderColor' => 'white']);
            $tableAgama->addRow();
            $tableAgama->addCell($lebarA4 * 0.10)->addText('');
            $tableAgama->addCell($lebarA4 * 0.20)->addText('Agama', ['size' => 12]);
            $tableAgama->addCell($lebarA4 * 0.05)->addText(':', ['size' => 12], array('align' => 'center'));
            $tableAgama->addCell($lebarA4 * 0.65)->addText($surat->agama, ['size' => 12]);

            $tablePekerjaan = $section->addTable(['borderSize' => 0, 'alignment' => 'center', 'borderColor' => 'white']);
            $tablePekerjaan->addRow();
            $tablePekerjaan->addCell($lebarA4 * 0.10)->addText('');
            $tablePekerjaan->addCell($lebarA4 * 0.20)->addText('Pekerjaan', ['size' => 12]);
            $tablePekerjaan->addCell($lebarA4 * 0.05)->addText(':', ['size' => 12], array('align' => 'center'));
            $tablePekerjaan->addCell($lebarA4 * 0.65)->addText($pekerjaan, ['size' => 12]);

            $tableAlamat = $section->addTable(['borderSize' => 0, 'alignment' => 'center', 'borderColor' => 'white']);
            $tableAlamat->addRow();
            $tableAlamat->addCell($lebarA4 * 0.10)->addText('');
            $tableAlamat->addCell($lebarA4 * 0.20)->addText('Alamat', ['size' => 12]);
            $tableAlamat->addCell($lebarA4 * 0.05)->addText(':', ['size' => 12], array('align' => 'center'));
            $tableAlamat->addCell($lebarA4 * 0.65)->addText($surat->alamat, ['size' => 12]);

            $tableKeterangan = $section->addTable(['borderSize' => 0, 'alignment' => 'center', 'borderColor' => 'white']);
            $tableKeterangan->addRow();
            $tableKeterangan->addCell($lebarA4 * 0.10)->addText('');
            $tableKeterangan->addCell($lebarA4 * 0.20)->addText('Keterangan', ['size' => 12]);
            $tableKeterangan->addCell($lebarA4 * 0.05)->addText(':', ['size' => 12], array('align' => 'center'));
            $tableKeterangan->addCell($lebarA4 * 0.58)->addText('Bahwa orang yang namanya tersebut di atas benar-benar Warga Kelurahan Kepolorejo dan saat ini belum menikah', ['size' => 12]);
            $tableKeterangan->addCell($lebarA4 * 0.07)->addText('');

            $tableKeperluan = $section->addTable(['borderSize' => 0, 'alignment' => 'center', 'borderColor' => 'white']);
            $tableKeperluan->addRow();
            $tableKeperluan->addCell($lebarA4 * 0.10)->addText('');
            $tableKeperluan->addCell($lebarA4 * 0.20)->addText('Keperluan', ['size' => 12]);
            $tableKeperluan->addCell($lebarA4 * 0.05)->addText(':', ['size' => 12], array('align' => 'center'));
            $tableKeperluan->addCell($lebarA4 * 0.65)->addText('Untuk '. $surat->keperluan, ['size' => 12]);

            $section->addTextBreak();        

        // PENUTUP
            $paragraph2 = 'Demikian Surat Keterangan ini dibuat dan dapat dipergunakan sebagaimana mestinya.';
            $section->addText($paragraph2, ['size' => 12], ['alignment' => 'both', 'indentation' => ['left' => 700, 'right' => 700,'firstLine' => 1000]]);

            $section->addTextBreak();
            $section->addTextBreak();
            $section->addTextBreak();

        // TANDA TANGAN 
            $tableFoot = $section->addTable(['width' => 100, 'borderColor' => 'white', 'borderSize' => 1, 'alignment' => 'right']);
            $tanggalLengkap = Carbon::parse(now())->locale('id_ID')->isoFormat('DD MMMM YYYY');
            $tableFoot->addRow();
            $tableFoot->addCell(5000)->addText('Magetan, ' . $tanggalLengkap, ['size' => 12], array('align' => 'center'));
            $tableFoot->addCell(550)->addText('');
            $tableFoot->addRow();            
            $tableFoot->addCell(5000)->addText('LURAH KEPOLOREJO', ['size' => 12], array('align' => 'center'));

            if ($jabatanNamaJabatan !== 'Lurah') {
                $tableFoot->addRow();            
                $tableFoot->addCell(5000)->addText('An. '.$jabatanNamaJabatan, ['size' => 12], array('align' => 'center'));
                $tableFoot->addRow();
                $tableFoot->addCell(5000)->addText('');
            }

            $tableFoot->addRow();
            $tableFoot->addCell(5000)->addText('');

            $tableFoot->addRow();
            $tableFoot->addCell(5000)->addText('');

            $tableFoot->addRow();
            $tableFoot->addCell(5000)->addText('');

            $tableFoot->addRow();
            $tableFoot->addCell(5000)->addText($jabatanNama, ['size' => 12, 'bold' => true, 'underline' => 'single'], ['align' => 'center']);
            $tableFoot->addRow();
            $tableFoot->addCell(5000)->addText($jabatanPosisi, ['size' => 12], ['align' => 'center']);

            $tableFoot->addRow();
            $tableFoot->addCell(5000)->addText('NIP. ' . $jabatanNIP, ['size' => 12], ['align' => 'center']);

            $section->addTextBreak();

        $filename = ucfirst(str_replace('_', ' ', $surat->jenis_surat)) . ' ' . date('Y-m-d H-i-s') . '.docx';
        $filepath = storage_path('app/' . $filename);
        $objWriter = IOFactory::createWriter($phpWord, 'Word2007');
        $objWriter->save($filepath);

        return response()->download($filepath)->deleteFileAfterSend(true);
    }

    public function unduh_skd($id_sk_domisili)
    {
        $surat = SKDomisili::findOrFail($id_sk_domisili);
        $jabatan = Jabatan::where('peran', 'Penanda Tangan')->first();
        $jenisSurat = $surat->jenis_surat;
        $year = date('Y');
        
        $jabatanNama = $jabatan->nama;
        $jabatanNamaJabatan = $jabatan->nama_jabatan;
        $jabatanPosisi = $jabatan->posisi;
        $jabatanNIP = $jabatan->nip;

        if ($surat->pekerjaan == 'Lainnya' && !empty($surat->pekerjaan_lainnya)) {
            $pekerjaan = $surat->pekerjaan_lainnya;
        } else {
            $pekerjaan = $surat->pekerjaan;
        }

        $phpWord = new PhpWord();
        $section = $phpWord->addSection([
            'marginTop'    => 600,  
            'marginBottom' => 600, 
            'marginRight'  => 600,
            'marginLeft'   => 600
        ]);        
        $table = $section->addTable();
        $row = $table->addRow();
        $lebarA4 = 21 * 600; 

        // KOP SURAT
            $row->addCell(2800)->addImage(public_path("Logo_Kabupaten_Magetan_Vector.jpg"), array('align' => 'center', 'width' => 75));
            $row->addCell(7200)->addImage(public_path("kop.png"), array('align' => 'center', 'width' => 340 ));
            $section->addLine(['weight' => 2,'width' => 535, 'height' => 0]);

        // ISI SURAT
            $textRunHeader = $section->addTextRun(['alignment' => 'center']);
            $textRunHeader->addText(strtoupper($jenisSurat), ['bold' => true, 'underline' => 'single', 'size' => 16]);            
            $textRunHeader->addTextBreak();
            $textRunHeader->addText('Nomor : 500.3.4.3/     /403.406.6/' . $year, ['size' => 12]);

            $section->addTextBreak();

            $paragraph1 = 'Yang bertanda tangan di bawah ini Lurah Kepolorejo Kecamatan Magetan Kabupaten Magetan, menerangkan dengan sebenarnya bahwa : ';
            $section->addText($paragraph1, ['size' => 12], ['alignment' => 'both', 'indentation' => ['left' => 700, 'right' => 700,'firstLine' => 1000]]);

            $section->addTextBreak();

            $tableNama = $section->addTable(['borderSize' => 0, 'alignment' => 'center', 'borderColor' => 'white']);
            $tableNama->addRow();
            $tableNama->addCell($lebarA4 * 0.10)->addText('');
            $tableNama->addCell($lebarA4 * 0.20)->addText('Nama', ['size' => 12]);
            $tableNama->addCell($lebarA4 * 0.05)->addText(':', ['size' => 12], array('align' => 'center'));
            $tableNama->addCell($lebarA4 * 0.65)->addText($surat->nama, ['bold' => true, 'allCaps' => true, 'size' => 12]);

            $tableNIK = $section->addTable(['borderSize' => 0, 'alignment' => 'center', 'borderColor' => 'white']);
            $tableNIK->addRow();
            $tableNIK->addCell($lebarA4 * 0.10)->addText('');
            $tableNIK->addCell($lebarA4 * 0.20)->addText('NIK', ['size' => 12]);
            $tableNIK->addCell($lebarA4 * 0.05)->addText(':', ['size' => 12], array('align' => 'center'));
            $tableNIK->addCell($lebarA4 * 0.65)->addText($surat->nik, ['size' => 12]);

            $tableJK = $section->addTable(['borderSize' => 0, 'alignment' => 'center', 'borderColor' => 'white']);
            $tableJK->addRow();
            $tableJK->addCell($lebarA4 * 0.10)->addText('');
            $tableJK->addCell($lebarA4 * 0.20)->addText('Jenis Kelamin', ['size' => 12]);
            $tableJK->addCell($lebarA4 * 0.05)->addText(':', ['size' => 12], array('align' => 'center'));
            $tableJK->addCell($lebarA4 * 0.65)->addText($surat->jenis_kelamin, ['size' => 12]);

            $tableTtl = $section->addTable(['borderSize' => 0, 'alignment' => 'center', 'borderColor' => 'white']);
            $tableTtl->addRow();
            $tableTtl->addCell($lebarA4 * 0.10)->addText('');
            $tableTtl->addCell($lebarA4 * 0.20)->addText('Tempat/Tgl Lahir', ['size' => 12]);
            $tableTtl->addCell($lebarA4 * 0.05)->addText(':', ['size' => 12], array('align' => 'center'));
            $tableTtl->addCell($lebarA4 * 0.65)->addText($surat->ttl, ['size' => 12]);

            $tableAgama = $section->addTable(['borderSize' => 0, 'alignment' => 'center', 'borderColor' => 'white']);
            $tableAgama->addRow();
            $tableAgama->addCell($lebarA4 * 0.10)->addText('');
            $tableAgama->addCell($lebarA4 * 0.20)->addText('Agama', ['size' => 12]);
            $tableAgama->addCell($lebarA4 * 0.05)->addText(':', ['size' => 12], array('align' => 'center'));
            $tableAgama->addCell($lebarA4 * 0.65)->addText($surat->agama, ['size' => 12]);

            $tableStatus = $section->addTable(['borderSize' => 0, 'alignment' => 'center', 'borderColor' => 'white']);
            $tableStatus->addRow();
            $tableStatus->addCell($lebarA4 * 0.10)->addText('');
            $tableStatus->addCell($lebarA4 * 0.20)->addText('Status', ['size' => 12]);
            $tableStatus->addCell($lebarA4 * 0.05)->addText(':', ['size' => 12], array('align' => 'center'));
            $tableStatus->addCell($lebarA4 * 0.65)->addText($surat->status_nikah, ['size' => 12]);

            $tablePekerjaan = $section->addTable(['borderSize' => 0, 'alignment' => 'center', 'borderColor' => 'white']);
            $tablePekerjaan->addRow();
            $tablePekerjaan->addCell($lebarA4 * 0.10)->addText('');
            $tablePekerjaan->addCell($lebarA4 * 0.20)->addText('Pekerjaan', ['size' => 12]);
            $tablePekerjaan->addCell($lebarA4 * 0.05)->addText(':', ['size' => 12], array('align' => 'center'));
            $tablePekerjaan->addCell($lebarA4 * 0.65)->addText($pekerjaan, ['size' => 12]);

            $tableAlamat = $section->addTable(['borderSize' => 0, 'alignment' => 'center', 'borderColor' => 'white']);
            $tableAlamat->addRow();
            $tableAlamat->addCell($lebarA4 * 0.10)->addText('');
            $tableAlamat->addCell($lebarA4 * 0.20)->addText('Alamat', ['size' => 12]);
            $tableAlamat->addCell($lebarA4 * 0.05)->addText(':', ['size' => 12], array('align' => 'center'));
            $tableAlamat->addCell($lebarA4 * 0.65)->addText($surat->alamat, ['size' => 12]);

            $tableKeterangan = $section->addTable(['borderSize' => 0, 'alignment' => 'center', 'borderColor' => 'white']);
            $tableKeterangan->addRow();
            $tableKeterangan->addCell($lebarA4 * 0.10)->addText('');
            $tableKeterangan->addCell($lebarA4 * 0.20)->addText('Keterangan', ['size' => 12]);
            $tableKeterangan->addCell($lebarA4 * 0.05)->addText(':', ['size' => 12], array('align' => 'center'));
            $tableKeterangan->addCell($lebarA4 * 0.58)->addText('Menerangkan bahwa orang tersebut di atas benar berdomisili di '. $surat->alamat_dom, ['size' => 12]);
            $tableKeterangan->addCell($lebarA4 * 0.07)->addText('');

            $tableKeperluan = $section->addTable(['borderSize' => 0, 'alignment' => 'center', 'borderColor' => 'white']);
            $tableKeperluan->addRow();
            $tableKeperluan->addCell($lebarA4 * 0.10)->addText('');
            $tableKeperluan->addCell($lebarA4 * 0.20)->addText('Keperluan', ['size' => 12]);
            $tableKeperluan->addCell($lebarA4 * 0.05)->addText(':', ['size' => 12], array('align' => 'center'));
            $tableKeperluan->addCell($lebarA4 * 0.65)->addText('Untuk '. $surat->keperluan, ['size' => 12]);

            $section->addTextBreak();    

        // PENUTUP
            $paragraph2 = 'Demikian Surat Keterangan ini dibuat dan dapat dipergunakan sebagaimana mestinya.';
            $section->addText($paragraph2, ['size' => 12], ['alignment' => 'both', 'indentation' => ['left' => 700, 'right' => 700,'firstLine' => 1000]]);

            $section->addTextBreak();
            $section->addTextBreak();
            $section->addTextBreak();

        // TANDA TANGAN 
            $tableFoot = $section->addTable(['width' => 100, 'borderColor' => 'white', 'borderSize' => 1, 'alignment' => 'right']);
            $tanggalLengkap = Carbon::parse(now())->locale('id_ID')->isoFormat('DD MMMM YYYY');
            $tableFoot->addRow();
            $tableFoot->addCell(5000)->addText('Magetan, ' . $tanggalLengkap, ['size' => 12], array('align' => 'center'));
            $tableFoot->addCell(550)->addText('');
            $tableFoot->addRow();            
            $tableFoot->addCell(5000)->addText('LURAH KEPOLOREJO', ['size' => 12], array('align' => 'center'));

            if ($jabatanNamaJabatan !== 'Lurah') {
                $tableFoot->addRow();            
                $tableFoot->addCell(5000)->addText('An. '.$jabatanNamaJabatan, ['size' => 12], array('align' => 'center'));
                $tableFoot->addRow();
                $tableFoot->addCell(5000)->addText('');
            }

            $tableFoot->addRow();
            $tableFoot->addCell(5000)->addText('');

            $tableFoot->addRow();
            $tableFoot->addCell(5000)->addText('');

            $tableFoot->addRow();
            $tableFoot->addCell(5000)->addText('');

            $tableFoot->addRow();
            $tableFoot->addCell(5000)->addText($jabatanNama, ['size' => 12, 'bold' => true, 'underline' => 'single'], ['align' => 'center']);
            $tableFoot->addRow();
            $tableFoot->addCell(5000)->addText($jabatanPosisi, ['size' => 12], ['align' => 'center']);

            $tableFoot->addRow();
            $tableFoot->addCell(5000)->addText('NIP. ' . $jabatanNIP, ['size' => 12], ['align' => 'center']);

            $section->addTextBreak();

        $filename = ucfirst(str_replace('_', ' ', $surat->jenis_surat)) . ' ' . date('Y-m-d H-i-s') . '.docx';
        $filepath = storage_path('app/' . $filename);
        $objWriter = IOFactory::createWriter($phpWord, 'Word2007');
        $objWriter->save($filepath);

        return response()->download($filepath)->deleteFileAfterSend(true);
    }

    public function unduh_sktm($id_sk_tidak_mampu)
    {
        $surat = SKTidakMampu::findOrFail($id_sk_tidak_mampu);
        $jabatan = Jabatan::where('peran', 'Penanda Tangan')->first();
        $jenisSurat = $surat->jenis_surat;
        $year = date('Y');

        $jabatanNama = $jabatan->nama;
        $jabatanNamaJabatan = $jabatan->nama_jabatan;
        $jabatanPosisi = $jabatan->posisi;
        $jabatanNIP = $jabatan->nip;

        if ($surat->pekerjaan == 'Lainnya' && !empty($surat->pekerjaan_lainnya)) {
            $pekerjaan = $surat->pekerjaan_lainnya;
        } else {
            $pekerjaan = $surat->pekerjaan;
        }

        $phpWord = new PhpWord();
        $section = $phpWord->addSection([
            'marginTop'    => 600,  
            'marginBottom' => 600, 
            'marginRight'  => 600,
            'marginLeft'   => 600
        ]);        
        $table = $section->addTable();
        $row = $table->addRow();
        $lebarA4 = 21 * 600; 

        // KOP SURAT
        $row->addCell(2800)->addImage(public_path("Logo_Kabupaten_Magetan_Vector.jpg"), array('align' => 'center', 'width' => 75));
        $row->addCell(7200)->addImage(public_path("kop.png"), array('align' => 'center', 'width' => 340 ));
        $section->addLine(['weight' => 2,'width' => 535, 'height' => 0]);
        // ISI SURAT
            $textRunHeader = $section->addTextRun(['alignment' => 'center']);
            $textRunHeader->addText(strtoupper($jenisSurat), ['bold' => true, 'underline' => 'single', 'size' => 16]);            
            $textRunHeader->addTextBreak();
            $textRunHeader->addText('Nomor : 500.3.4.3/     /403.406.6/' . $year, ['size' => 12]);

            $section->addTextBreak();

            $paragraph1 = 'Yang bertanda tangan di bawah ini Lurah Kepolorejo Kecamatan Magetan Kabupaten Magetan, menerangkan dengan sebenarnya bahwa : ';
            $section->addText($paragraph1, ['size' => 12], ['alignment' => 'both', 'indentation' => ['left' => 700, 'right' => 700,'firstLine' => 1000]]);
            
            $section->addTextBreak();

            $tableNama = $section->addTable(['borderSize' => 0, 'alignment' => 'center', 'borderColor' => 'white']);
            $tableNama->addRow();
            $tableNama->addCell($lebarA4 * 0.10)->addText('');
            $tableNama->addCell($lebarA4 * 0.20)->addText('Nama', ['size' => 12]);
            $tableNama->addCell($lebarA4 * 0.05)->addText(':', ['size' => 12], array('align' => 'center'));
            $tableNama->addCell($lebarA4 * 0.65)->addText($surat->nama, ['bold' => true, 'allCaps' => true, 'size' => 12]);

            $tableNIK = $section->addTable(['borderSize' => 0, 'alignment' => 'center', 'borderColor' => 'white']);
            $tableNIK->addRow();
            $tableNIK->addCell($lebarA4 * 0.10)->addText('');
            $tableNIK->addCell($lebarA4 * 0.20)->addText('NIK', ['size' => 12]);
            $tableNIK->addCell($lebarA4 * 0.05)->addText(':', ['size' => 12], array('align' => 'center'));
            $tableNIK->addCell($lebarA4 * 0.65)->addText($surat->nik, ['size' => 12]);

            $tableTtl = $section->addTable(['borderSize' => 0, 'alignment' => 'center', 'borderColor' => 'white']);
            $tableTtl->addRow();
            $tableTtl->addCell($lebarA4 * 0.10)->addText('');
            $tableTtl->addCell($lebarA4 * 0.20)->addText('Tempat/Tgl Lahir', ['size' => 12]);
            $tableTtl->addCell($lebarA4 * 0.05)->addText(':', ['size' => 12], array('align' => 'center'));
            $tableTtl->addCell($lebarA4 * 0.65)->addText($surat->ttl, ['size' => 12]);

            $tableAgama = $section->addTable(['borderSize' => 0, 'alignment' => 'center', 'borderColor' => 'white']);
            $tableAgama->addRow();
            $tableAgama->addCell($lebarA4 * 0.10)->addText('');
            $tableAgama->addCell($lebarA4 * 0.20)->addText('Agama', ['size' => 12]);
            $tableAgama->addCell($lebarA4 * 0.05)->addText(':', ['size' => 12], array('align' => 'center'));
            $tableAgama->addCell($lebarA4 * 0.65)->addText($surat->agama, ['size' => 12]);

            $tablePekerjaan = $section->addTable(['borderSize' => 0, 'alignment' => 'center', 'borderColor' => 'white']);
            $tablePekerjaan->addRow();
            $tablePekerjaan->addCell($lebarA4 * 0.10)->addText('');
            $tablePekerjaan->addCell($lebarA4 * 0.20)->addText('Pekerjaan', ['size' => 12]);
            $tablePekerjaan->addCell($lebarA4 * 0.05)->addText(':', ['size' => 12], array('align' => 'center'));
            $tablePekerjaan->addCell($lebarA4 * 0.65)->addText($pekerjaan, ['size' => 12]);

            $tableAlamat = $section->addTable(['borderSize' => 0, 'alignment' => 'center', 'borderColor' => 'white']);
            $tableAlamat->addRow();
            $tableAlamat->addCell($lebarA4 * 0.10)->addText('');
            $tableAlamat->addCell($lebarA4 * 0.20)->addText('Alamat', ['size' => 12]);
            $tableAlamat->addCell($lebarA4 * 0.05)->addText(':', ['size' => 12], array('align' => 'center'));
            $tableAlamat->addCell($lebarA4 * 0.65)->addText($surat->alamat, ['size' => 12]);

            $tableKeterangan = $section->addTable(['borderSize' => 0, 'alignment' => 'center', 'borderColor' => 'white']);
            $tableKeterangan->addRow();
            $tableKeterangan->addCell($lebarA4 * 0.10)->addText('');
            $tableKeterangan->addCell($lebarA4 * 0.20)->addText('Keterangan', ['size' => 12]);
            $tableKeterangan->addCell($lebarA4 * 0.05)->addText(':', ['size' => 12], array('align' => 'center'));
            $tableKeterangan->addCell($lebarA4 * 0.65)->addText('Menerangkan bahwa orang tersebut diatas warga Kepolorejo dan benar tidak mampu', ['size' => 12]);

            $tableKeperluan = $section->addTable(['borderSize' => 0, 'alignment' => 'center', 'borderColor' => 'white']);
            $tableKeperluan->addRow();
            $tableKeperluan->addCell($lebarA4 * 0.10)->addText('');
            $tableKeperluan->addCell($lebarA4 * 0.20)->addText('Keperluan', ['size' => 12]);
            $tableKeperluan->addCell($lebarA4 * 0.05)->addText(':', ['size' => 12], array('align' => 'center'));
            $tableKeperluan->addCell($lebarA4 * 0.65)->addText('Untuk '. $surat->keperluan, ['size' => 12]);

            $section->addTextBreak();   

        // PENUTUP
            $paragraph2 = 'Demikian Surat Keterangan ini dibuat dan dapat dipergunakan sebagaimana mestinya.';
            $section->addText($paragraph2, ['size' => 12], ['alignment' => 'both', 'indentation' => ['left' => 700, 'right' => 700,'firstLine' => 1000]]);

            $section->addTextBreak();
            $section->addTextBreak();
            $section->addTextBreak();

        // TANDA TANGAN 
            $tableFoot = $section->addTable(['width' => 100, 'borderColor' => 'white', 'borderSize' => 1, 'alignment' => 'right']);
            $tanggalLengkap = Carbon::parse(now())->locale('id_ID')->isoFormat('DD MMMM YYYY');
            $tableFoot->addRow();
            $tableFoot->addCell(5000)->addText('Magetan, ' . $tanggalLengkap, ['size' => 12], array('align' => 'center'));
            $tableFoot->addCell(550)->addText('');
            $tableFoot->addRow();            
            $tableFoot->addCell(5000)->addText('LURAH KEPOLOREJO', ['size' => 12], array('align' => 'center'));

            if ($jabatanNamaJabatan !== 'Lurah') {
                $tableFoot->addRow();            
                $tableFoot->addCell(5000)->addText('An. '.$jabatanNamaJabatan, ['size' => 12], array('align' => 'center'));
                $tableFoot->addRow();
                $tableFoot->addCell(5000)->addText('');
            }

            $tableFoot->addRow();
            $tableFoot->addCell(5000)->addText('');

            $tableFoot->addRow();
            $tableFoot->addCell(5000)->addText('');

            $tableFoot->addRow();
            $tableFoot->addCell(5000)->addText('');

            $tableFoot->addRow();
            $tableFoot->addCell(5000)->addText($jabatanNama, ['size' => 12, 'bold' => true, 'underline' => 'single'], ['align' => 'center']);
            $tableFoot->addRow();
            $tableFoot->addCell(5000)->addText($jabatanPosisi, ['size' => 12], ['align' => 'center']);

            $tableFoot->addRow();
            $tableFoot->addCell(5000)->addText('NIP. ' . $jabatanNIP, ['size' => 12], ['align' => 'center']);

            $section->addTextBreak();
            
        $filename = ucfirst(str_replace('_', ' ', $surat->jenis_surat)) . ' ' . date('Y-m-d H-i-s') . '.docx';
        $filepath = storage_path('app/' . $filename);
        $objWriter = IOFactory::createWriter($phpWord, 'Word2007');
        $objWriter->save($filepath);

        return response()->download($filepath)->deleteFileAfterSend(true);
    }

    public function skbm(Request $request)
    {
        $surat = Surat::where('status_surat', 'Selesai')->get();
        return view('surat.skbm', compact('surat'));
    }

    public function skd(Request $request)
    {
        $surat = Surat::where('status_surat', 'Selesai')->get();
        return view('surat.skd', compact('surat'));
    }

    public function sktm(Request $request)
    {
        $surat = Surat::where('status_surat', 'Selesai')->get();
        return view('surat.sktm', compact('surat'));
    }

    public function sku(Request $request)
    {
        $surat = Surat::where('status_surat', 'Selesai')->get();
        return view('surat.sku', compact('surat'));
    }
}