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
use PhpOffice\PhpWord\IOFactory;
use PhpOffice\PhpWord\PhpWord;


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

    // public function detail_spt($id_spt)
    // {
    //     $spt = SPT::findOrFail($id_spt);
    //     $anggota_spt = AnggotaSPT::where('id_spt', $id_spt)->get();
    //     return view('spt_pka.detail_spt', compact('spt', 'anggota_spt'));
    // }


    
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

    // public function verifikasi_surat(Request $request, $id_surat) {
    //     $surats = Surat::findOrFail($id_surat);
    //     if($surats) {
    //         switch($surats->status_surat) {
    //             case 'Diproses':
    //                 switch($request->aksi) {
    //                     case 'setuju':
    //                         $surats->update([
    //                             'status_surat' => 'Selesai',
    //                         ]);
    //                         Session::flash('alert', [
    //                             'type' => 'success',
    //                             'title' => 'Surat Berhasil Disetujui',
    //                             'message' => "",
    //                         ]);
    //                         break;
    //                     case 'tolak':
    //                         $surats->update([
    //                             'status_surat' => 'Ditolak',
    //                         ]);
    //                         Session::flash('alert', [
    //                             'type' => 'success',
    //                             'title' => 'Surat Berhasil Ditolak',
    //                             'message' => "",
    //                         ]);
    //                         break;
    //                 }
    //                 break;
    //         }
    //     } else {
    //         Session::flash('alert', [
    //             'type' => 'error',
    //             'title' => 'Kirim Data Gagal',
    //             'message' => 'Terjadi Error!'
    //         ]);
    //     }
    //     return back();
    // }

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

    public function surat_disetujui(Request $request)
    {
        $surats = Surat::where('status_surat', 'Disetujui')->get();
        return view('surat.surat_disetujui', compact('surats'));
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

    public function unduh_surat(Request $request, $jenis_surat, $id_surat)
    {
        $surat = Surat::findOrFail($id_surat);

        $phpWord = new PhpWord();
        $section = $phpWord->addSection([
            'marginTop'    => 600,  
            'marginBottom' => 600, 
            'marginRight'  => 800,
            'marginLeft'   => 800
        ]);        
        $table = $section->addTable();
        $row = $table->addRow();
        $lebarA4 = 21 * 600; 

        
        $row->addCell(2500)->addImage(public_path("logo.png"), ['width' => 68]);

        $textCell = $row->addCell(7500);
        $textCell->addText('PEMERINTAH KABUPATEN MAGETAN', ['bold' => true, 'size' => 11], array('align' => 'center', 'space' => array('line' => -50)));
        $textCell->addText('I N S P E K T O R A T', ['bold' => true, 'size' => 13], array('align' => 'center', 'space' => array('line' => -50)));
        $textCell->addText('Jl. Tripandita No. 17 Magetan Kode Pos 63319', ['size' => 9], array('align' => 'center', 'space' => array('line' => -50)));
        $textCell->addText('Telp. (0351) 897113 Fax. (0351) 897161', ['size' => 9], array('align' => 'center', 'space' => array('line' => -50)));
        $textCell->addText('E-mail : inspektorat@magetan.go.id Website : http://inspektorat.magetan.go.id', ['size' => 9], array('align' => 'center', 'space' => array('line' => -50)));

        $section->addLine(['weight' => 2,'width' => 510, 'height' => 0]);

        // Logika pembuatan dokumen surat berdasarkan jenis surat
        if ($jenis_surat == 'SURAT KETERANGAN DOMISILI') {
            $textRunHeader = $section->addTextRun(['alignment' => 'center']);
            $textRunHeader->addText('SURAT KETERANGAN DOMISILI', ['bold' => true, 'underline' => 'single', 'size' => 16]);
            $textRunHeader->addTextBreak();
            $textRunHeader->addText('Nomor : 094/      /403.060/2024', ['bold' => true, 'size' => 11]);
            $textRunHeader->addTextBreak();

            $textRunHeader->addText($surat->nama_warga, ['bold' => true, 'size' => 11]);


        } elseif ($jenis_surat == 'SURAT KETERANGAN BELUM MENIKAH') {
            $textRunHeader = $section->addTextRun(['alignment' => 'center']);
            $textRunHeader->addText('SURAT KETERANGAN BELUM MENIKAH', ['bold' => true, 'underline' => 'single', 'size' => 16]);
            $textRunHeader->addTextBreak();
            $textRunHeader->addText('Nomor : 094/      /403.060/2024', ['bold' => true, 'size' => 11]);
            $textRunHeader->addTextBreak();

            $textRunHeader->addText($surat->nama_warga, ['bold' => true, 'size' => 11]);


        } elseif ($jenis_surat == 'SURAT KETERANGAN TIDAK MAMPU') {
            $textRunHeader = $section->addTextRun(['alignment' => 'center']);
            $textRunHeader->addText('SURAT KETERANGAN TIDAK MAMPU', ['bold' => true, 'underline' => 'single', 'size' => 16]);
            $textRunHeader->addTextBreak();
            $textRunHeader->addText('Nomor : 094/      /403.060/2024', ['bold' => true, 'size' => 11]);
            $textRunHeader->addTextBreak();

            $textRunHeader->addText($surat->nama_warga, ['bold' => true, 'size' => 11]);

            
        } elseif ($jenis_surat == 'SURAT KETERANGAN USAHA') {
            $textRunHeader = $section->addTextRun(['alignment' => 'center']);
            $textRunHeader->addText('SURAT KETERANGAN USAHA', ['bold' => true, 'underline' => 'single', 'size' => 16]);
            $textRunHeader->addTextBreak();
            $textRunHeader->addText('Nomor : 094/      /403.060/2024', ['bold' => true, 'size' => 11]); 
            $textRunHeader->addTextBreak();

            $textRunHeader->addText($surat->nama_warga, ['bold' => true, 'size' => 11]);
        }    

        
        else {
            // Jenis surat tidak valid, mungkin berikan tanggapan atau tangani secara khusus
        } 
        
        $tableDasar = $section->addTable(['borderSize' => 0, 'alignment' => 'center', 'borderColor' => 'white']);
        $tableDasar->addRow();
        $tableDasar->addCell($lebarA4 * 0.10)->addText('DASAR', ['bold' => true, 'size' => 11]);
        $tableDasar->addCell($lebarA4 * 0.05)->addText(':', ['bold' => true, 'size' => 11], array('align' => 'center'));

        $textRunCenter = $section->addTextRun(['alignment' => 'center']);
        $textRunCenter->addText('M E M E R I N T A H K A N', ['bold' => true, 'size' => 11]);

        $tableee = $section->addTable(['borderSize' => 0, 'alignment' => 'center', 'borderColor' => 'white']);
        $tableee->addRow();
        $tableee->addCell($lebarA4 * 0.10)->addText('KEPADA', ['bold' => true, 'size' => 11]);        
        $tableee->addCell($lebarA4 * 0.05)->addText(':', ['bold' => true, 'size' => 11], array('align' => 'center')); 
        $tableee->addCell($lebarA4 * 0.85)->addText('');
        
        $section->addTextBreak();

        $tableUntuk = $section->addTable(['borderSize' => 0, 'alignment' => 'center', 'borderColor' => 'white']);
        $tableUntuk->addRow();
        $tableUntuk->addCell($lebarA4 * 0.10)->addText('UNTUK', ['bold' => true, 'size' => 11]);
        $tableUntuk->addCell($lebarA4 * 0.05)->addText(':', ['bold' => true, 'size' => 11], array('align' => 'center'));

        $section->addTextBreak();

        $filename = ucfirst(str_replace('_', ' ', $jenis_surat)) . ' ' . date('Y-m-d H-i-s') . '.docx';
        $filepath = storage_path('app/' . $filename);
        $objWriter = IOFactory::createWriter($phpWord, 'Word2007');
        $objWriter->save($filepath);

        return response()->download($filepath)->deleteFileAfterSend(true);
    }

    // public function unduh_surat($jenis_surat)
    // {
    //     // Tentukan path ke template surat berdasarkan jenis surat
    //     $templatePath = storage_path('app/templates/' . $jenis_surat . '.docx');

    //     // Periksa apakah template ada
    //     if (!file_exists($templatePath)) {
    //         abort(404, 'Template surat tidak ditemukan');
    //     }

    //     // Buat objek PHPWord
    //     $phpWord = IOFactory::load($templatePath);

    //     // Lakukan proses yang diperlukan untuk mengisi data ke dalam dokumen Word
    //     // Misalnya:
    //     // $phpWord->setValue('nama_penerima', $data['nama_penerima']);
    //     // $phpWord->setValue('alamat_penerima', $data['alamat_penerima']);

    //     // Simpan dokumen Word yang dihasilkan
    //     $outputPath = storage_path('app/public/surat_' . $jenis_surat . '.docx');
    //     $phpWord->save($outputPath);

    //     // Kembalikan respon untuk mengunduh dokumen Word
    //     return response()->download($outputPath);
    // }
}