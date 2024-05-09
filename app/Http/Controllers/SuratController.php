<?php

namespace App\Http\Controllers;

use App\Models\Surat;
use App\Models\JenisSurat;
use App\Models\SKBelumMenikah;
use App\Models\SKDomisili;
use App\Models\SKTidakMampu;
use App\Models\SKUsaha;
use Carbon\Carbon;
use Illuminate\Http\Request;
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
        return view('surat.res_surat', compact('surats', 'sk_usaha', 'sk_belum_menikah', 'skd', 'sktm'));
    }

    public function checkDatabase()
    {
        $data = JenisSurat::pluck('nama_jenis_surat');
        dd($data);
    }    

    public function buat_surat(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'jenis_surat' => 'required',
            'nama' => 'nullable',
            'nik' => 'nullable',
            'ttl' => 'nullable',
            'status_nikah' => 'nullable',
            'agama' => 'nullable',
            'pekerjaan' => 'nullable',
            'alamat' => 'nullable',
            'usaha' => 'nullable',
            'keperluan' => 'nullable',
            'nama_2' => 'nullable',
            'nik_2' => 'nullable',
            'ttl_2' => 'nullable',
            'agama_2' => 'nullable',
            'status_nikah_2' => 'nullable',
            'pekerjaan_2' => 'nullable',
            'alamat_2' => 'nullable',
            'keperluan_2' => 'nullable',
            'jenis_kelamin' => 'nullable',
            'alamat_dom' => 'nullable',
            'nama_3' => 'nullable',
            'nik_3' => 'nullable',
            'ttl_3' => 'nullable',
            'status_nikah_3' => 'nullable',
            'agama_3' => 'nullable',
            'pekerjaan_3' => 'nullable',
            'alamat_3' => 'nullable',
            'keperluan_3' => 'nullable',
            'nama_4' => 'nullable',
            'nik_4' => 'nullable',
            'ttl_4' => 'nullable',
            'agama_4' => 'nullable',
            'pekerjaan_4' => 'nullable',
            'alamat_4' => 'nullable',
            'keperluan_4' => 'nullable'
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
                    SKUsaha::create([
                        'jenis_surat' => $request->jenis_surat,
                        'nama' => $request->nama,
                        'nik' => $request->nik,
                        'ttl' => $request->ttl,
                        'status_nikah' => $request->status_nikah,
                        'agama' => $request->agama,
                        'pekerjaan' => $request->pekerjaan,
                        'alamat' => $request->alamat,
                        'usaha' => $request->usaha,
                        'keperluan' => $request->keperluan
                    ]);
                
                break;

                case 'SURAT KETERANGAN DOMISILI':
                    SKDomisili::create([
                        'jenis_surat' => $request->jenis_surat,
                        'nama' => $request->nama_2,
                        'nik' => $request->nik_2,
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
                    SKBelumMenikah::create([
                        'jenis_surat' => $request->jenis_surat,
                        'nama' => $request->nama_3,
                        'nik' => $request->nik_3,
                        'ttl' => $request->ttl_3,
                        'status_nikah' => $request->status_nikah_3,
                        'agama' => $request->agama_3,
                        'pekerjaan' => $request->pekerjaan_3,
                        'alamat' => $request->alamat_3,
                        'keperluan' => $request->keperluan_3,
                    ]);
                
                break;

                case 'SURAT KETERANGAN TIDAK MAMPU':
                    SKTidakMampu::create([
                        'jenis_surat' => $request->jenis_surat,
                        'nama' => $request->nama_4,
                        'nik' => $request->nik_4,
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

    public function detail_sk_usaha(Request $request)
    {
        $sk_usaha = SKUsaha::where('id_sk_usaha', $request->id)->first();
        if($sk_usaha)
        {
            return response()->json([
                'status'=>'success',
                'sk_usaha'=> $sk_usaha,
            ]);
        }
        else
        {
            return response()->json([
                'status'=>'error',
            ]);
        }
    }

    public function ubah_isi_surat($id) 
    {
        $surats = Surat::find($id);
        return response()->json(['surats'=>$surats]);
    }

    public function edit_surat(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'ubah_nama_warga' => '',
            'ubah_nik_warga' => '',
            'ubah_agama' => '',
            'ubah_pekerjaan' => '',
            'ubah_usaha' => '',
            'ubah_ttl' => '',
            'ubah_alamat' => '',
            'ubah_alamat_dom' => '',
            'ubah_status_surat' => '',
            'ubah_keperluan' => ''
        ]);

        if ($validator->fails()) {
            Session::flash('alert', [
                'type' => 'error',
                'title' => 'Input Data Gagal',
                'message' => 'Ada inputan yang salah!',
            ]);
        } else {
            $surats = Surat::where('id_surat', $request->id_surat)->first();

            if($surats){
                $surats->update([
                    'nama_warga' => $request->ubah_nama_warga,
                    'nik_warga' => $request->ubah_nik_warga,
                    'agama' => $request->ubah_agama,
                    'pekerjaan' => $request->ubah_pekerjaan,
                    'usaha' => $request->ubah_usaha,
                    'ttl' => $request->ubah_ttl,
                    'alamat' => $request->ubah_alamat,
                    'alamat_dom' => $request->ubah_alamat_dom,
                    'status_surat' => $request->ubah_status_surat,
                    'keperluan' => $request->ubah_keperluan
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

    public function verifikasi_surat(Request $request, $id_surat) 
    {
        $surat = Surat::findOrFail($id_surat);
        
        if ($surat && $surat->status_surat === 'Diproses') {
            switch ($request->aksi) {
                case 'setuju':
                    $surat->status_surat = 'Disetujui';
                    $message = 'Surat berhasil disetujui.';
                    $type = 'success';
                    break;
                case 'tolak':
                    $surat->status_surat = 'Ditolak';
                    $message = 'Surat berhasil ditolak.';
                    $type = 'error';
                    break;
                default:
                    // Do nothing
                    break;
            }
    
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

    public function verifikasi_sk_usaha(Request $request, $id_sk_usaha) 
    {
        $surat = SKUsaha::findOrFail($id_sk_usaha);
        
        if ($surat && $surat->status_surat === 'Diproses') {
            switch ($request->aksi) {
                case 'setuju':
                    $surat->status_surat = 'Disetujui';
                    $message = 'Surat berhasil disetujui.';
                    $type = 'success';
                    break;
                case 'tolak':
                    $surat->status_surat = 'Ditolak';
                    $message = 'Surat berhasil ditolak.';
                    $type = 'error';
                    break;
                default:
                    // Do nothing
                    break;
            }
    
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

    public function verifikasi_sk_belum_menikah(Request $request, $id_sk_belum_menikah) 
    {
        $surat = SKBelumMenikah::findOrFail($id_sk_belum_menikah);
        
        if ($surat && $surat->status_surat === 'Diproses') {
            switch ($request->aksi) {
                case 'setuju':
                    $surat->status_surat = 'Disetujui';
                    $message = 'Surat berhasil disetujui.';
                    $type = 'success';
                    break;
                case 'tolak':
                    $surat->status_surat = 'Ditolak';
                    $message = 'Surat berhasil ditolak.';
                    $type = 'error';
                    break;
                default:
                    // Do nothing
                    break;
            }
    
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

    public function verifikasi_sk_domisili(Request $request, $id_sk_domisili) 
    {
        $surat = SKDomisili::findOrFail($id_sk_domisili);
        
        if ($surat && $surat->status_surat === 'Diproses') {
            switch ($request->aksi) {
                case 'setuju':
                    $surat->status_surat = 'Disetujui';
                    $message = 'Surat berhasil disetujui.';
                    $type = 'success';
                    break;
                case 'tolak':
                    $surat->status_surat = 'Ditolak';
                    $message = 'Surat berhasil ditolak.';
                    $type = 'error';
                    break;
                default:
                    // Do nothing
                    break;
            }
    
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

    public function verifikasi_sk_tidak_mampu(Request $request, $id_sk_tidak_mampu) 
    {
        $surat = SKTidakMampu::findOrFail($id_sk_tidak_mampu);
        
        if ($surat && $surat->status_surat === 'Diproses') {
            switch ($request->aksi) {
                case 'setuju':
                    $surat->status_surat = 'Disetujui';
                    $message = 'Surat berhasil disetujui.';
                    $type = 'success';
                    break;
                case 'tolak':
                    $surat->status_surat = 'Ditolak';
                    $message = 'Surat berhasil ditolak.';
                    $type = 'error';
                    break;
                default:
                    // Do nothing
                    break;
            }
    
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

    public function surat_disetujui(Request $request)
    {
        $surat = Surat::where('status_surat', 'Disetujui')->get();
        $sk_usaha = SKUsaha::where('status_surat', 'Disetujui')->get();
        $sk_belum_menikah = SKBelumMenikah::where('status_surat', 'Disetujui')->get();
        $skd = SKDomisili::where('status_surat', 'Disetujui')->get();
        $sktm = SKTidakMampu::where('status_surat', 'Disetujui')->get();
        return view('surat.surat_disetujui', compact('surat', 'sk_usaha', 'sk_belum_menikah', 'skd', 'sktm'));
    }

    public function surat_selesai($id_surat) {
        $surat = Surat::find($id_surat);
    
        if($surat) {
            $surat->status_surat = 'Selesai'; // Ubah status_surat langsung
    
            if($surat->save()) {
                Session::flash('alert', [
                    'type' => 'success',
                    'title' => 'Kirim Data Berhasil',
                    'message' => ''
                ]);
            } else {
                Session::flash('alert', [
                    'type' => 'error',
                    'title' => 'Kirim Data Gagal',
                    'message' => 'Gagal menyimpan status surat.'
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
    
    public function riwayat_surat(Request $request)
    {
        $surats = Surat::where('status_surat', 'Selesai')->get();
        return view('surat.riwayat_surat', compact('surats'));
    }

    public function cari_surat(Request $request)
    {
        $request->validate([
            'nik_warga' => 'required|numeric', 
        ]);

        $nikWarga = $request->input('nik_warga');
        $surat = Surat::where('nik_warga', $nikWarga)->first();

        // Jika surat ditemukan, kembalikan respons JSON dengan detail surat
        if ($surat) {
            return response()->json($surat);
        }
        // Jika surat tidak ditemukan, kembalikan respons teks biasa 'NIK tidak ditemukan'
        return response('NIK tidak ditemukan', 404);
    }

    public function hapus_surat($id_surat) {
        $surat = Surat::findOrFail($id_surat);
        if($surat) {
            Session::flash('alert', [
                'type' => 'success',
                'title' => 'Hapus Data '.$surat->nama_warga.' Berhasil',
                'message' => "",
            ]); 
            $surat->delete();
        } else {
            Session::flash('alert', [
                'type' => 'error',
                'title' => 'Hapus Data Gagal',
                'message' => 'NIP Tidak Valid!',
            ]); 
        }
        return back();
    }

    public function hapus_sk_usaha($id_sk_usaha) {
        $surat = SKUsaha::findOrFail($id_sk_usaha);
        if($surat) {
            Session::flash('alert', [
                'type' => 'success',
                'title' => 'Hapus Data '.$surat->nama.' Berhasil',
                'message' => "",
            ]); 
            $surat->delete();
        } else {
            Session::flash('alert', [
                'type' => 'error',
                'title' => 'Hapus Data Gagal',
                'message' => 'NIP Tidak Valid!',
            ]); 
        }
        return back();
    }

    public function hapus_sk_belum_menikah($id_sk_belum_menikah) {
        $surat = SKBelumMenikah::findOrFail($id_sk_belum_menikah);
        if($surat) {
            Session::flash('alert', [
                'type' => 'success',
                'title' => 'Hapus Data '.$surat->nama.' Berhasil',
                'message' => "",
            ]); 
            $surat->delete();
        } else {
            Session::flash('alert', [
                'type' => 'error',
                'title' => 'Hapus Data Gagal',
                'message' => 'NIP Tidak Valid!',
            ]); 
        }
        return back();
    }

    public function hapus_sk_domisili($id_sk_domisili) {
        $surat = SKDomisili::findOrFail($id_sk_domisili);
        if($surat) {
            Session::flash('alert', [
                'type' => 'success',
                'title' => 'Hapus Data '.$surat->nama.' Berhasil',
                'message' => "",
            ]); 
            $surat->delete();
        } else {
            Session::flash('alert', [
                'type' => 'error',
                'title' => 'Hapus Data Gagal',
                'message' => 'NIP Tidak Valid!',
            ]); 
        }
        return back();
    }

    public function hapus_sk_tidak_mampu($id_sk_tidak_mampu) {
        $surat = SKTidakMampu::findOrFail($id_sk_tidak_mampu);
        if($surat) {
            Session::flash('alert', [
                'type' => 'success',
                'title' => 'Hapus Data '.$surat->nama.' Berhasil',
                'message' => "",
            ]); 
            $surat->delete();
        } else {
            Session::flash('alert', [
                'type' => 'error',
                'title' => 'Hapus Data Gagal',
                'message' => 'NIP Tidak Valid!',
            ]); 
        }
        return back();
    }

    public function unduh_surat(Request $request, $jenis_surat, $id_surat)
    {
        $surat = Surat::findOrFail($id_surat);

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
            if ($jenis_surat == 'SURAT KETERANGAN DOMISILI') {
                $textRunHeader = $section->addTextRun(['alignment' => 'center']);
                $textRunHeader->addText('SURAT KETERANGAN DOMISILI', ['bold' => true, 'underline' => 'single', 'size' => 16]);
                $textRunHeader->addTextBreak();
                $textRunHeader->addText('Nomor : 400.12.4.4/     /403.406.6/2023', ['size' => 12]);

                $section->addTextBreak();

                $paragraph1 = 'Yang bertanda tangan dibawah ini Lurah Kepolorejo Kecamatan Magetan Kabupaten Magetan, menerangkan dengan sebenarnya bahwa : ';
                $section->addText($paragraph1, ['size' => 12], ['alignment' => 'both', 'indentation' => ['left' => 700, 'right' => 700,'firstLine' => 1000]]);

                $section->addTextBreak();

                $tableNama = $section->addTable(['borderSize' => 0, 'alignment' => 'center', 'borderColor' => 'white']);
                $tableNama->addRow();
                $tableNama->addCell($lebarA4 * 0.10)->addText('');
                $tableNama->addCell($lebarA4 * 0.20)->addText('Nama', ['size' => 12]);
                $tableNama->addCell($lebarA4 * 0.05)->addText(':', ['size' => 12], array('align' => 'center'));
                $tableNama->addCell($lebarA4 * 0.65)->addText($surat->nama_warga, ['bold' => true, 'allCaps' => true, 'size' => 12]);

                $tableNIK = $section->addTable(['borderSize' => 0, 'alignment' => 'center', 'borderColor' => 'white']);
                $tableNIK->addRow();
                $tableNIK->addCell($lebarA4 * 0.10)->addText('');
                $tableNIK->addCell($lebarA4 * 0.20)->addText('NIK', ['size' => 12]);
                $tableNIK->addCell($lebarA4 * 0.05)->addText(':', ['size' => 12], array('align' => 'center'));
                $tableNIK->addCell($lebarA4 * 0.65)->addText($surat->nik_warga, ['size' => 12]);

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
                $tablePekerjaan->addCell($lebarA4 * 0.65)->addText($surat->pekerjaan, ['size' => 12]);

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

                $section->addTextBreak();

            } elseif ($jenis_surat == 'SURAT KETERANGAN BELUM MENIKAH') {
                $textRunHeader = $section->addTextRun(['alignment' => 'center']);
                $textRunHeader->addText('SURAT KETERANGAN BELUM MENIKAH', ['bold' => true, 'underline' => 'single', 'size' => 16]);
                $textRunHeader->addTextBreak();
                $textRunHeader->addText('Nomor : 471.1/     /403.406.6/2024', ['size' => 12]);
                
                $section->addTextBreak();

                $paragraph1 = 'Yang bertanda tangan dibawah ini Lurah Kepolorejo Kecamatan Magetan Kabupaten Magetan, menerangkan dengan sebenarnya bahwa : ';
                $section->addText($paragraph1, ['size' => 12], ['alignment' => 'both', 'indentation' => ['left' => 700, 'right' => 700,'firstLine' => 1000]]);
                
                $section->addTextBreak();

                $tableNama = $section->addTable(['borderSize' => 0, 'alignment' => 'center', 'borderColor' => 'white']);
                $tableNama->addRow();
                $tableNama->addCell($lebarA4 * 0.10)->addText('');
                $tableNama->addCell($lebarA4 * 0.20)->addText('Nama', ['size' => 12]);
                $tableNama->addCell($lebarA4 * 0.05)->addText(':', ['size' => 12], array('align' => 'center'));
                $tableNama->addCell($lebarA4 * 0.65)->addText($surat->nama_warga, ['bold' => true, 'allCaps' => true, 'size' => 12]);

                $tableNIK = $section->addTable(['borderSize' => 0, 'alignment' => 'center', 'borderColor' => 'white']);
                $tableNIK->addRow();
                $tableNIK->addCell($lebarA4 * 0.10)->addText('');
                $tableNIK->addCell($lebarA4 * 0.20)->addText('NIK', ['size' => 12]);
                $tableNIK->addCell($lebarA4 * 0.05)->addText(':', ['size' => 12], array('align' => 'center'));
                $tableNIK->addCell($lebarA4 * 0.65)->addText($surat->nik_warga, ['size' => 12]);

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
                $tablePekerjaan->addCell($lebarA4 * 0.65)->addText($surat->pekerjaan, ['size' => 12]);

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
                $tableKeterangan->addCell($lebarA4 * 0.58)->addText('Bahwa orang yang namanya tersebut diatas benar-benar Warga Kelurahan Kepolorejo dan saat ini belum menikah', ['size' => 12]);
                $tableKeterangan->addCell($lebarA4 * 0.07)->addText('');

                $tableKeperluan = $section->addTable(['borderSize' => 0, 'alignment' => 'center', 'borderColor' => 'white']);
                $tableKeperluan->addRow();
                $tableKeperluan->addCell($lebarA4 * 0.10)->addText('');
                $tableKeperluan->addCell($lebarA4 * 0.20)->addText('Keperluan', ['size' => 12]);
                $tableKeperluan->addCell($lebarA4 * 0.05)->addText(':', ['size' => 12], array('align' => 'center'));
                $tableKeperluan->addCell($lebarA4 * 0.65)->addText('Untuk '. $surat->keperluan, ['size' => 12]);

                $section->addTextBreak();

            } elseif ($jenis_surat == 'SURAT KETERANGAN TIDAK MAMPU') {
                $textRunHeader = $section->addTextRun(['alignment' => 'center']);
                $textRunHeader->addText('SURAT KETERANGAN TIDAK MAMPU', ['bold' => true, 'underline' => 'single', 'size' => 16]);
                $textRunHeader->addTextBreak();
                $textRunHeader->addText('Nomor : 400.12.4.4/     /403.406.6/2024', ['size' => 12]);

                $section->addTextBreak();

                $paragraph1 = 'Yang bertanda tangan dibawah ini Lurah Kepolorejo Kecamatan Magetan Kabupaten Magetan, menerangkan dengan sebenarnya bahwa : ';
                $section->addText($paragraph1, ['size' => 12], ['alignment' => 'both', 'indentation' => ['left' => 700, 'right' => 700,'firstLine' => 1000]]);
                
                $section->addTextBreak();

                $tableNama = $section->addTable(['borderSize' => 0, 'alignment' => 'center', 'borderColor' => 'white']);
                $tableNama->addRow();
                $tableNama->addCell($lebarA4 * 0.10)->addText('');
                $tableNama->addCell($lebarA4 * 0.20)->addText('Nama', ['size' => 12]);
                $tableNama->addCell($lebarA4 * 0.05)->addText(':', ['size' => 12], array('align' => 'center'));
                $tableNama->addCell($lebarA4 * 0.65)->addText($surat->nama_warga, ['bold' => true, 'allCaps' => true, 'size' => 12]);

                $tableNIK = $section->addTable(['borderSize' => 0, 'alignment' => 'center', 'borderColor' => 'white']);
                $tableNIK->addRow();
                $tableNIK->addCell($lebarA4 * 0.10)->addText('');
                $tableNIK->addCell($lebarA4 * 0.20)->addText('NIK', ['size' => 12]);
                $tableNIK->addCell($lebarA4 * 0.05)->addText(':', ['size' => 12], array('align' => 'center'));
                $tableNIK->addCell($lebarA4 * 0.65)->addText($surat->nik_warga, ['size' => 12]);

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
                $tablePekerjaan->addCell($lebarA4 * 0.65)->addText($surat->pekerjaan, ['size' => 12]);

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

                $section->addTextBreak();
                
            } elseif ($jenis_surat == 'SURAT KETERANGAN USAHA') {
                $textRunHeader = $section->addTextRun(['alignment' => 'center']);
                $textRunHeader->addText('SURAT KETERANGAN USAHA', ['bold' => true, 'underline' => 'single', 'size' => 16]);
                $textRunHeader->addTextBreak();
                $textRunHeader->addText('Nomor : 500.3.4.3/     /403.406.6/2024', ['size' => 12]); 

                $section->addTextBreak();

                $paragraph1 = 'Yang bertanda tangan dibawah ini Lurah Kepolorejo Kecamatan Magetan Kabupaten Magetan, menerangkan dengan sebenarnya bahwa : ';
                $section->addText($paragraph1, ['size' => 12], ['alignment' => 'both', 'indentation' => ['left' => 700, 'right' => 700,'firstLine' => 1000]]);
                
                $section->addTextBreak();

                $tableNama = $section->addTable(['borderSize' => 0, 'alignment' => 'center', 'borderColor' => 'white']);
                $tableNama->addRow();
                $tableNama->addCell($lebarA4 * 0.10)->addText('');
                $tableNama->addCell($lebarA4 * 0.20)->addText('Nama', ['size' => 12]);
                $tableNama->addCell($lebarA4 * 0.05)->addText(':', ['size' => 12], array('align' => 'center'));
                $tableNama->addCell($lebarA4 * 0.65)->addText($surat->nama_warga, ['bold' => true, 'allCaps' => true, 'size' => 12]);

                $tableNIK = $section->addTable(['borderSize' => 0, 'alignment' => 'center', 'borderColor' => 'white']);
                $tableNIK->addRow();
                $tableNIK->addCell($lebarA4 * 0.10)->addText('');
                $tableNIK->addCell($lebarA4 * 0.20)->addText('NIK', ['size' => 12]);
                $tableNIK->addCell($lebarA4 * 0.05)->addText(':', ['size' => 12], array('align' => 'center'));
                $tableNIK->addCell($lebarA4 * 0.65)->addText($surat->nik_warga, ['size' => 12]);

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
                $tablePekerjaan->addCell($lebarA4 * 0.65)->addText($surat->pekerjaan, ['size' => 12]);

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
            }

        // PENUTUP
            $paragraph2 = 'Demikian Surat Keterangan ini dibuat dan dapat dipergunakan sebagaimana mestinya.';
            $section->addText($paragraph2, ['size' => 12], ['alignment' => 'both', 'indentation' => ['left' => 700, 'right' => 700,'firstLine' => 1000]]);

            $section->addTextBreak();
            $section->addTextBreak();
            $section->addTextBreak();

        // TANDA TANGAN 
            $tableFoot = $section->addTable(['width' => 80, 'borderColor' => 'white', 'borderSize' => 1, 'alignment' => 'right']);
            $tanggalLengkap = Carbon::parse(now())->locale('id_ID')->isoFormat('DD MMMM YYYY');
            $tableFoot->addRow();
            $tableFoot->addCell(4700)->addText('Magetan, ' . $tanggalLengkap, ['size' => 12], array('align' => 'center'));
            $tableFoot->addCell(550)->addText('');
            $tableFoot->addRow();            
            $tableFoot->addCell(4700)->addText('LURAH KEPOLOREJO', ['size' => 12], array('align' => 'center'));

            $tableFoot->addRow();
            $tableFoot->addCell(4700)->addText('');

            $tableFoot->addRow();
            $tableFoot->addCell(4700)->addText('');

            $tableFoot->addRow();
            $tableFoot->addCell(4700)->addText('');

            $tableFoot->addRow();
            $tableFoot->addCell(4700)->addText('ADITYA SURENDRA MAWARDI, SE, MM', ['size' => 12, 'bold' => true, 'underline' => 'single'], array('align' => 'center'));

            $tableFoot->addRow();
            $tableFoot->addCell(4700)->addText('Pembina', ['size' => 12], array('align' => 'center'));

            $tableFoot->addRow();
            $tableFoot->addCell(4700)->addText('NIP. 19740309 200501 1 007', ['size' => 12], array('align' => 'center'));
            
            $section->addTextBreak();


        $filename = ucfirst(str_replace('_', ' ', $jenis_surat)) . ' ' . date('Y-m-d H-i-s') . '.docx';
        $filepath = storage_path('app/' . $filename);
        $objWriter = IOFactory::createWriter($phpWord, 'Word2007');
        $objWriter->save($filepath);

        return response()->download($filepath)->deleteFileAfterSend(true);
    }

    public function unduh_sk_usaha(Request $request, $id_sk_usaha)
    {
        $surat = SKUsaha::findOrFail($id_sk_usaha);
        // $jenis_surat = SKUsaha::all();

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
            $textRunHeader->addText('SURAT KETERANGAN USAHA', ['bold' => true, 'underline' => 'single', 'size' => 16]);
            $textRunHeader->addTextBreak();
            $textRunHeader->addText('Nomor : 500.3.4.3/     /403.406.6/2024', ['size' => 12]); 

            $section->addTextBreak();

            $paragraph1 = 'Yang bertanda tangan dibawah ini Lurah Kepolorejo Kecamatan Magetan Kabupaten Magetan, menerangkan dengan sebenarnya bahwa : ';
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
            $tablePekerjaan->addCell($lebarA4 * 0.65)->addText($surat->pekerjaan, ['size' => 12]);

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
            $section->addTextBreak();

        // TANDA TANGAN 
            $tableFoot = $section->addTable(['width' => 80, 'borderColor' => 'white', 'borderSize' => 1, 'alignment' => 'right']);
            $tanggalLengkap = Carbon::parse(now())->locale('id_ID')->isoFormat('DD MMMM YYYY');
            $tableFoot->addRow();
            $tableFoot->addCell(4700)->addText('Magetan, ' . $tanggalLengkap, ['size' => 12], array('align' => 'center'));
            $tableFoot->addCell(550)->addText('');
            $tableFoot->addRow();            
            $tableFoot->addCell(4700)->addText('LURAH KEPOLOREJO', ['size' => 12], array('align' => 'center'));

            $tableFoot->addRow();
            $tableFoot->addCell(4700)->addText('');

            $tableFoot->addRow();
            $tableFoot->addCell(4700)->addText('');

            $tableFoot->addRow();
            $tableFoot->addCell(4700)->addText('');

            $tableFoot->addRow();
            $tableFoot->addCell(4700)->addText('ADITYA SURENDRA MAWARDI, SE, MM', ['size' => 12, 'bold' => true, 'underline' => 'single'], array('align' => 'center'));

            $tableFoot->addRow();
            $tableFoot->addCell(4700)->addText('Pembina', ['size' => 12], array('align' => 'center'));

            $tableFoot->addRow();
            $tableFoot->addCell(4700)->addText('NIP. 19740309 200501 1 007', ['size' => 12], array('align' => 'center'));
            
            $section->addTextBreak();


        $filename = ucfirst(str_replace('_', ' ', $surat->jenis_surat)) . ' ' . date('Y-m-d H-i-s') . '.docx';
        $filepath = storage_path('app/' . $filename);
        $objWriter = IOFactory::createWriter($phpWord, 'Word2007');
        $objWriter->save($filepath);

        return response()->download($filepath)->deleteFileAfterSend(true);
    }

    public function unduh_sk_belum_menikah(Request $request, $id_sk_belum_menikah)
    {
        $surat = SKBelumMenikah::findOrFail($id_sk_belum_menikah);
        // $jenis_surat = SKUsaha::all();

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
            $textRunHeader->addText('SURAT KETERANGAN BELUM MENIKAH', ['bold' => true, 'underline' => 'single', 'size' => 16]);
            $textRunHeader->addTextBreak();
            $textRunHeader->addText('Nomor : 471.1/     /403.406.6/2024', ['size' => 12]);
            
            $section->addTextBreak();

            $paragraph1 = 'Yang bertanda tangan dibawah ini Lurah Kepolorejo Kecamatan Magetan Kabupaten Magetan, menerangkan dengan sebenarnya bahwa : ';
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
            $tablePekerjaan->addCell($lebarA4 * 0.65)->addText($surat->pekerjaan, ['size' => 12]);

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
            $tableKeterangan->addCell($lebarA4 * 0.58)->addText('Bahwa orang yang namanya tersebut diatas benar-benar Warga Kelurahan Kepolorejo dan saat ini belum menikah', ['size' => 12]);
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
            $tableFoot = $section->addTable(['width' => 80, 'borderColor' => 'white', 'borderSize' => 1, 'alignment' => 'right']);
            $tanggalLengkap = Carbon::parse(now())->locale('id_ID')->isoFormat('DD MMMM YYYY');
            $tableFoot->addRow();
            $tableFoot->addCell(4700)->addText('Magetan, ' . $tanggalLengkap, ['size' => 12], array('align' => 'center'));
            $tableFoot->addCell(550)->addText('');
            $tableFoot->addRow();            
            $tableFoot->addCell(4700)->addText('LURAH KEPOLOREJO', ['size' => 12], array('align' => 'center'));

            $tableFoot->addRow();
            $tableFoot->addCell(4700)->addText('');

            $tableFoot->addRow();
            $tableFoot->addCell(4700)->addText('');

            $tableFoot->addRow();
            $tableFoot->addCell(4700)->addText('');

            $tableFoot->addRow();
            $tableFoot->addCell(4700)->addText('ADITYA SURENDRA MAWARDI, SE, MM', ['size' => 12, 'bold' => true, 'underline' => 'single'], array('align' => 'center'));

            $tableFoot->addRow();
            $tableFoot->addCell(4700)->addText('Pembina', ['size' => 12], array('align' => 'center'));

            $tableFoot->addRow();
            $tableFoot->addCell(4700)->addText('NIP. 19740309 200501 1 007', ['size' => 12], array('align' => 'center'));
            
            $section->addTextBreak();


        $filename = ucfirst(str_replace('_', ' ', $surat->jenis_surat)) . ' ' . date('Y-m-d H-i-s') . '.docx';
        $filepath = storage_path('app/' . $filename);
        $objWriter = IOFactory::createWriter($phpWord, 'Word2007');
        $objWriter->save($filepath);

        return response()->download($filepath)->deleteFileAfterSend(true);
    }

    public function unduh_sk_domisili(Request $request, $id_sk_domisili)
    {
        $surat = SKDomisili::findOrFail($id_sk_domisili);
        // $jenis_surat = SKUsaha::all();

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
            $textRunHeader->addText('SURAT KETERANGAN DOMISILI', ['bold' => true, 'underline' => 'single', 'size' => 16]);
            $textRunHeader->addTextBreak();
            $textRunHeader->addText('Nomor : 400.12.4.4/     /403.406.6/2023', ['size' => 12]);

            $section->addTextBreak();

            $paragraph1 = 'Yang bertanda tangan dibawah ini Lurah Kepolorejo Kecamatan Magetan Kabupaten Magetan, menerangkan dengan sebenarnya bahwa : ';
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
            $tablePekerjaan->addCell($lebarA4 * 0.65)->addText($surat->pekerjaan, ['size' => 12]);

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
            $tableKeterangan->addCell($lebarA4 * 0.58)->addText('Menerangkan bahwa orang tersebut di atas benar warga  Kepolorejo dan berdomisili di '. $surat->alamat_dom, ['size' => 12]);
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
            $tableFoot = $section->addTable(['width' => 80, 'borderColor' => 'white', 'borderSize' => 1, 'alignment' => 'right']);
            $tanggalLengkap = Carbon::parse(now())->locale('id_ID')->isoFormat('DD MMMM YYYY');
            $tableFoot->addRow();
            $tableFoot->addCell(4700)->addText('Magetan, ' . $tanggalLengkap, ['size' => 12], array('align' => 'center'));
            $tableFoot->addCell(550)->addText('');
            $tableFoot->addRow();            
            $tableFoot->addCell(4700)->addText('LURAH KEPOLOREJO', ['size' => 12], array('align' => 'center'));

            $tableFoot->addRow();
            $tableFoot->addCell(4700)->addText('');

            $tableFoot->addRow();
            $tableFoot->addCell(4700)->addText('');

            $tableFoot->addRow();
            $tableFoot->addCell(4700)->addText('');

            $tableFoot->addRow();
            $tableFoot->addCell(4700)->addText('ADITYA SURENDRA MAWARDI, SE, MM', ['size' => 12, 'bold' => true, 'underline' => 'single'], array('align' => 'center'));

            $tableFoot->addRow();
            $tableFoot->addCell(4700)->addText('Pembina', ['size' => 12], array('align' => 'center'));

            $tableFoot->addRow();
            $tableFoot->addCell(4700)->addText('NIP. 19740309 200501 1 007', ['size' => 12], array('align' => 'center'));
            
            $section->addTextBreak();


        $filename = ucfirst(str_replace('_', ' ', $surat->jenis_surat)) . ' ' . date('Y-m-d H-i-s') . '.docx';
        $filepath = storage_path('app/' . $filename);
        $objWriter = IOFactory::createWriter($phpWord, 'Word2007');
        $objWriter->save($filepath);

        return response()->download($filepath)->deleteFileAfterSend(true);
    }

    public function unduh_sk_tidak_mampu(Request $request, $id_sk_tidak_mampu)
    {
        $surat = SKTidakMampu::findOrFail($id_sk_tidak_mampu);
        // $jenis_surat = SKUsaha::all();

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
            $textRunHeader->addText('SURAT KETERANGAN TIDAK MAMPU', ['bold' => true, 'underline' => 'single', 'size' => 16]);
            $textRunHeader->addTextBreak();
            $textRunHeader->addText('Nomor : 400.12.4.4/     /403.406.6/2024', ['size' => 12]);

            $section->addTextBreak();

            $paragraph1 = 'Yang bertanda tangan dibawah ini Lurah Kepolorejo Kecamatan Magetan Kabupaten Magetan, menerangkan dengan sebenarnya bahwa : ';
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
            $tablePekerjaan->addCell($lebarA4 * 0.65)->addText($surat->pekerjaan, ['size' => 12]);

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
            $tableFoot = $section->addTable(['width' => 80, 'borderColor' => 'white', 'borderSize' => 1, 'alignment' => 'right']);
            $tanggalLengkap = Carbon::parse(now())->locale('id_ID')->isoFormat('DD MMMM YYYY');
            $tableFoot->addRow();
            $tableFoot->addCell(4700)->addText('Magetan, ' . $tanggalLengkap, ['size' => 12], array('align' => 'center'));
            $tableFoot->addCell(550)->addText('');
            $tableFoot->addRow();            
            $tableFoot->addCell(4700)->addText('LURAH KEPOLOREJO', ['size' => 12], array('align' => 'center'));

            $tableFoot->addRow();
            $tableFoot->addCell(4700)->addText('');

            $tableFoot->addRow();
            $tableFoot->addCell(4700)->addText('');

            $tableFoot->addRow();
            $tableFoot->addCell(4700)->addText('');

            $tableFoot->addRow();
            $tableFoot->addCell(4700)->addText('ADITYA SURENDRA MAWARDI, SE, MM', ['size' => 12, 'bold' => true, 'underline' => 'single'], array('align' => 'center'));

            $tableFoot->addRow();
            $tableFoot->addCell(4700)->addText('Pembina', ['size' => 12], array('align' => 'center'));

            $tableFoot->addRow();
            $tableFoot->addCell(4700)->addText('NIP. 19740309 200501 1 007', ['size' => 12], array('align' => 'center'));
            
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



    // public function dokumen_surat(Request $request)
    // {
    //     // Validasi request
    //     $request->validate([
    //         'dokumen_surat' => 'required|file|mimes:pdf,doc,docx|max:2048', // Sesuaikan dengan jenis file yang diizinkan dan batasan ukuran
    //     ]);

    //     // Mengambil file dokumen surat dari request
    //     $dokumenSurat = $request->file('dokumen_surat');

    //     // Menyimpan file dokumen surat ke storage
    //     $path = $dokumenSurat->store('dokumen_surat');

    //     // Mengambil id surat dari form, sesuaikan dengan nama input id yang digunakan di form Anda
    //     $suratId = $request->input('surat_id');

    //     // Menemukan surat berdasarkan id
    //     $surat = Surat::findOrFail($suratId);

    //     // Menyimpan nama file dokumen surat ke dalam kolom dokumen_surat di tabel surat
    //     $surat->dokumen_surat = $path;
    //     $surat->save();

    //     // Menetapkan pesan flash ke session
    //     $request->session()->flash('success', 'Surat telah berhasil diupload.');

    //     // Redirect ke halaman atau rute yang sesuai
    //     return back();
    // }

    public function dokumen_surat(Request $request)
    {
        // Mengambil semua data surat
        $surat = Surat::get();

        $success = false;

        foreach ($surat as $s) {
            // Memeriksa apakah dokumen_surat kosong dalam permintaan HTTP
            if ($request->hasFile('dokumen_surat'.$s->id_surat)) {
                // Menyimpan file dokumen_surat dalam variabel
                $dokumen = $request->file('dokumen_surat'.$s->id_surat);
                
                // Mendapatkan nama file
                $namaFile = $dokumen->getClientOriginalName();

                // Menyimpan file di lokasi yang ditentukan (misalnya folder 'dokumen')
                $dokumen->move('dokumen', $namaFile);

                // Mengupdate kolom dokumen_surat dengan nama file
                $data = Surat::where('id', $s->id_surat)->first();
                $data->dokumen_surat = $namaFile;
                $data->update();

                $success = true;
            }
        }

        // Mengarahkan kembali pengguna ke halaman sebelumnya dengan alert sesuai hasil unggahan
        if ($success) {
            return back()->with('success', 'Surat berhasil diupload.');
        } else {
            return back()->with('error', 'Gagal mengupload surat. Silakan coba lagi.');
        }
    }


//     public function dokumen_surat(Request $request)
// {
//     $surat = Surat::get();

//     foreach($surat as $letter){
//         // Mengambil nama input file dokumen_surat
//         $inputName = 'dokumen_surat'.$letter->id_surat;

//         // Memeriksa apakah file dokumen_surat telah diunggah
//         if($request->hasFile($inputName)){
//             // Mengambil file dokumen_surat dari request
//             $dokumen = $request->file($inputName);

//             // Mengambil data surat berdasarkan id_surat
//             $data = Surat::where('id_surat', $request['id_surat'.$letter->id_surat])->first();

//             // Mengubah file menjadi data biner
//             $dokumenBinary = file_get_contents($dokumen->getRealPath());

//             // Menyimpan data biner ke dalam kolom dokumen_surat di tabel surat
//             $data->dokumen_surat = $dokumenBinary;

//             // Menyimpan perubahan
//             $data->save();
//         }
//     }

//     return back();
// }

}

