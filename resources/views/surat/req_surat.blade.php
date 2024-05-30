@extends('layout.app')

@section('title')
    Data Pengajuan Surat
@endsection

@section('head')
    <link rel="stylesheet" href="{{ asset('assets/css/dataTables.bootstrap5.min.css') }}">
    <script src="{{ asset('assets/js/jquery.dataTables.min.js') }}"></script>
    <script src="{{ asset('assets/js/dataTables.bootstrap5.min.js') }}"></script>
    <script src="{{ asset('ckeditor/ckeditor.js') }}"></script>
    <script src="{{ asset('assets/libs/moment/min/moment.min.js') }}"></script>
    <link rel="stylesheet" href="{{ asset('assets/libs/daterangepicker/daterangepicker.css') }}">
    <script type="text/javascript" src="{{ asset('assets/libs/daterangepicker/daterangepicker.min.js') }}"></script>
@endsection

@section('content')
    <div id="layout-wrapper">
        @include('layout.header')
        @include('layout.sidebar')
        <div class="main-content">
            <div class="page-content">
                <div class="container-fluid">                   
                    <div class="row bg-white rounded-3 pb-3 mb-3 mx-2">
                        <div class="page-title-box bg-light-subtle rounded-3 d-flex align-items-center justify-content-between px-3 py-2">
                            <h5>DATA PENGAJUAN SURAT</h5>
                        </div>
                        <div class="text-end mb-4">
                            <button data-bs-toggle="modal" data-bs-target="#tambahsuratbaru" class="btn btn-primary">AJUKAN SURAT</button>
                        </div>                    
                        <div class="container-fluid table-responsive px-3 py-3">
                            <table class="table table-striped" id="tabelSPT" style="width:100%">
                                <thead>
                                    <tr>
                                        <th class="col-md-1 text-center align-middle">TANGGAL PENGAJUAN</th>                           
                                        <th class="col-md-2 text-center align-middle">JENIS SURAT</th>                           
                                        <th class="col-md-2 text-center align-middle">NIK</th>                           
                                        <th class="col-md-2 text-center align-middle">NAMA</th>                           
                                        <th class="col-md-2 text-center align-middle">STATUS</th>                           
                                        <th class="col-md-2 text-center align-middle">AKSI</th>                           
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach(\App\Models\SKUsaha::where('pemohon', auth()->user()->nik)->get() as $sk_usaha)
                                        <tr>      
                                            <td class="text-center align-middle">{{ $sk_usaha->tanggal }}</td>
                                            <td class="text-center align-middle">{{ $sk_usaha->jenis_surat }}</td>
                                            <td class="text-center align-middle">{{ $sk_usaha->nik }}</td>
                                            <td class="text-center align-middle">{{ $sk_usaha->nama }}</td>
                                            <td class="text-center align-middle">{{ $sk_usaha->status_surat }}</td>
                                            <td class="text-center align-middle">
                                                <div class="d-flex justify-content-center">
                                                    <button type="button" data-bs-toggle="modal" data-bs-target="#detailSKU" data-bs-id="{{ $sk_usaha->id_sk_usaha }}" class="btn btn-primary btn-sm me-2">Detail</button>
                                                    @if($sk_usaha->status_surat === 'Ditolak')
                                                        <button type="button" data-bs-toggle="modal" data-bs-target="#pesan_ditolak" data-bs-id="{{ $sk_usaha->id_sk_usaha }}" data-bs-pesan="{{ $sk_usaha->pesan }}" class="btn btn-danger btn-sm">Pesan Ditolak</button>
                                                    @endif
                                                </div>
                                            </td>
                                        </tr>
                                    @endforeach

                                    @foreach(\App\Models\SKBelumMenikah::where('pemohon', auth()->user()->nik)->get() as $sk_belum_menikah)
                                        <tr>      
                                            <td class="text-center align-middle">{{ $sk_belum_menikah->tanggal }}</td>
                                            <td class="text-center align-middle">{{ $sk_belum_menikah->jenis_surat }}</td>
                                            <td class="text-center align-middle">{{ $sk_belum_menikah->nik }}</td>
                                            <td class="text-center align-middle">{{ $sk_belum_menikah->nama }}</td>
                                            <td class="text-center align-middle">{{ $sk_belum_menikah->status_surat }}</td>
                                            <td class="text-center align-middle">
                                                <div class="d-flex justify-content-center">
                                                    <button type="button" data-bs-toggle="modal" data-bs-target="#detailSKBM" data-bs-id="{{ $sk_belum_menikah->id_sk_belum_menikah }}" class="btn btn-primary btn-sm me-2">Detail</button>
                                                    @if($sk_belum_menikah->status_surat === 'Ditolak')
                                                        <button type="button" data-bs-toggle="modal" data-bs-target="#pesan_ditolak" data-bs-id="{{ $sk_belum_menikah->id_sk_belum_menikah }}" data-bs-pesan="{{ $sk_belum_menikah->pesan }}" class="btn btn-danger btn-sm">Pesan Ditolak</button>
                                                    @endif
                                                </div>
                                            </td>
                                        </tr>
                                    @endforeach

                                    @foreach(\App\Models\SKDomisili::where('pemohon', auth()->user()->nik)->get() as $skd)
                                        <tr>      
                                            <td class="text-center align-middle">{{ $skd->tanggal }}</td>
                                            <td class="text-center align-middle">{{ $skd->jenis_surat }}</td>
                                            <td class="text-center align-middle">{{ $skd->nik }}</td>
                                            <td class="text-center align-middle">{{ $skd->nama }}</td>
                                            <td class="text-center align-middle">{{ $skd->status_surat }}</td>
                                            <td class="text-center align-middle">
                                                <div class="d-flex justify-content-center">
                                                    <button type="button" data-bs-toggle="modal" data-bs-target="#detailSKD" data-bs-id="{{ $skd->id_sk_domisili }}" class="btn btn-primary btn-sm me-2">Detail</button>
                                                    @if($skd->status_surat === 'Ditolak')
                                                        <button type="button" data-bs-toggle="modal" data-bs-target="#pesan_ditolak" data-bs-id="{{ $skd->id_sk_domisili }}" data-bs-pesan="{{ $skd->pesan }}" class="btn btn-danger btn-sm">Pesan Ditolak</button>
                                                    @endif
                                                </div>
                                            </td>
                                        </tr>
                                    @endforeach

                                    @foreach(\App\Models\SKTidakMampu::where('pemohon', auth()->user()->nik)->get() as $sktm)
                                        <tr>      
                                            <td class="text-center align-middle">{{ $sktm->tanggal }}</td>
                                            <td class="text-center align-middle">{{ $sktm->jenis_surat }}</td>
                                            <td class="text-center align-middle">{{ $sktm->nik }}</td>
                                            <td class="text-center align-middle">{{ $sktm->nama }}</td>
                                            <td class="text-center align-middle">{{ $sktm->status_surat }}</td>
                                            <td class="text-center align-middle">
                                                <div class="d-flex justify-content-center">
                                                    <button type="button" data-bs-toggle="modal" data-bs-target="#detailSKTM" data-bs-id="{{ $sktm->id_sk_tidak_mampu }}" class="btn btn-primary btn-sm me-2">Detail</button>
                                                    @if($sktm->status_surat === 'Ditolak')
                                                        <button type="button" data-bs-toggle="modal" data-bs-target="#pesan_ditolak" data-bs-id="{{ $sktm->id_sk_tidak_mampu }}" data-bs-pesan="{{ $sktm->pesan }}" class="btn btn-danger btn-sm">Pesan Ditolak</button>
                                                    @endif
                                                </div>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
            @include('layout.footer')
        </div>
    </div>
@endsection

@section('modal')
    {{-- TAMBAH SURAT --}}
    <div class="modal fade" id="tambahsuratbaru" tabindex="-1" aria-hidden="true" data-bs-backdrop="static" data-bs-keyboard="false">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">PENGAJUAN SURAT BARU</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    {{-- REQ NOT ALL --}}
                    @php
                        $jenis_surat_yang_telah_diajukan = array_merge(
                            \App\Models\SKUsaha::where('pemohon', auth()->user()->nik)->pluck('jenis_surat')->toArray(),
                            \App\Models\SKBelumMenikah::where('pemohon', auth()->user()->nik)->pluck('jenis_surat')->toArray(),
                            \App\Models\SKDomisili::where('pemohon', auth()->user()->nik)->pluck('jenis_surat')->toArray(),
                            \App\Models\SKTidakMampu::where('pemohon', auth()->user()->nik)->pluck('jenis_surat')->toArray()
                        );

                        $querySKU = \App\Models\SKUsaha::where('pemohon', auth()->user()->nik)
                                ->where('status_surat', 'Ditolak')
                                ->pluck('jenis_surat');

                        $querySKBM = \App\Models\SKBelumMenikah::where('pemohon', auth()->user()->nik)
                                ->where('status_surat', 'Ditolak')
                                ->pluck('jenis_surat');

                        $querySKD = \App\Models\SKDomisili::where('pemohon', auth()->user()->nik)
                                ->where('status_surat', 'Ditolak')
                                ->pluck('jenis_surat');

                        $querySKTM = \App\Models\SKTidakMampu::where('pemohon', auth()->user()->nik)
                                ->where('status_surat', 'Ditolak')
                                ->pluck('jenis_surat');
                    
                        $jenis_surat_ditolak = $querySKU->union($querySKBM)->union($querySKD)->union($querySKTM)->toArray();

                        $semua_jenis_surat = \App\Models\JenisSurat::all();
                        $jenis_surat_tersedia = [];
                    
                        foreach ($semua_jenis_surat as $jenis_surat) {
                            if (!in_array($jenis_surat->nama_jenis_surat, $jenis_surat_yang_telah_diajukan) || in_array($jenis_surat->nama_jenis_surat, $jenis_surat_ditolak)) {
                                $jenis_surat_tersedia[] = $jenis_surat;
                            }
                        }
                    @endphp
                    <div class="mb-3">
                        <label for="jenis_surat" class="form-label"><strong>JENIS SURAT</strong></label>
                        <select class="form-select form-control" id="jenis_surat" name="jenis_surat" required onchange="showForm()">
                            <option value="" selected hidden>-- Pilih Jenis Surat --</option>
                            @foreach($jenis_surat_tersedia as $jenis_surat)
                                <option value="{{ $jenis_surat->nama_jenis_surat }}">{{ $jenis_surat->nama_jenis_surat }}</option>
                            @endforeach
                        </select>
                    </div>
                
                    {{-- REQ ALL --}}
                    {{-- <div class="mb-3">
                        <label for="jenis_surat" class="form-label"><strong>JENIS SURAT</strong></label>
                        <select class="form-select" id="jenis_surat" name="jenis_surat" required onchange="showForm()" required>
                            <option value="" selected hidden>-- Pilih Jenis Surat --</option>
                            @foreach(\App\Models\JenisSurat::all() as $jenis_surats)
                                <option value="{{ $jenis_surats->nama_jenis_surat }}">{{ $jenis_surats->nama_jenis_surat }}</option>
                            @endforeach
                        </select>
                    </div> --}}

                    {{-- USAHA --}}
                    <form method="POST" action="{{ route('buat_sku') }}" enctype="multipart/form-data">
                        @csrf
                        <div id="form_surat_SURAT KETERANGAN USAHA" class="form_surat" style="display: none;">
                            <input type="hidden" id="jenis_surat_1" name="jenis_surat_1" value="">
                            <div class="mb-3">
                                <label for="nama" class="form-label"><strong>NAMA</strong></label>
                                <input type="text" class="form-control" id="nama" name="nama" value="{{ auth()->user()->nama }}" readonly>
                            </div>
                            <div class="mb-3">
                                <label for="nik" class="form-label"><strong>NIK</strong></label>
                                <input type="text" class="form-control" id="nik" name="nik" value="{{ auth()->user()->nik }}" readonly>
                            </div>
                            <div class="mb-3">
                                <label for="ttl" class="form-label"><strong>TEMPAT, TANGGAL LAHIR - <span style="color: red;">(Contoh: Magetan, 30 Maret 1999)</span></strong></label>
                                <input type="text" class="form-control" id="ttl" name="ttl" placeholder="Masukkan tempat, tanggal lahir" required>
                            </div>
                            <div class="mb-3">
                                <label for="status_nikah" class="form-label"><strong>STATUS NIKAH</strong></label>
                                <select class="form-select" id="status_nikah" name="status_nikah" required>
                                    <option value="" selected hidden>-- Pilih Status --</option>
                                    @foreach(\App\Models\Status::all() as $status_nikahs)
                                        <option value="{{ $status_nikahs->nama_status_nikah }}">{{ $status_nikahs->nama_status_nikah }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="mb-3">
                                <label for="agama" class="form-label"><strong>AGAMA</strong></label>
                                <select class="form-select" id="agama" name="agama" required>
                                    <option value="" selected hidden>-- Pilih Agama --</option>
                                    @foreach(\App\Models\Agama::all() as $agamas)
                                        <option value="{{ $agamas->nama_agama }}">{{ $agamas->nama_agama }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="mb-3">
                                <label for="pekerjaan" class="form-label"><strong>PEKERJAAN</strong></label>
                                <select class="form-select" id="pekerjaan" name="pekerjaan" required>
                                    <option value="" selected hidden>-- Pilih Pekerjaan --</option>
                                    @foreach(\App\Models\Pekerjaan::all() as $pekerjaans)
                                        <option value="{{ $pekerjaans->nama_pekerjaan }}">{{ $pekerjaans->nama_pekerjaan }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="mb-3" id="pekerjaan_lainnya_div" style="display: none;">
                                <label for="pekerjaan_lainnya" class="form-label"><strong>PEKERJAAN LAINNYA</strong></label>
                                <input type="text" class="form-control" id="pekerjaan_lainnya" name="pekerjaan_lainnya" placeholder="Masukkan pekerjaan lainnya yang belum ada di pilihan pekerjaan" required>
                            </div>
                            <div class="mb-3">
                                <label for="alamat" class="form-label"><strong>ALAMAT</strong></label>
                                <input type="text" class="form-control" id="alamat" name="alamat" placeholder="Masukkan alamat lengkap" required>
                            </div>
                            <div class="mb-3">
                                <label for="usaha" class="form-label"><strong>JENIS DAN NAMA USAHA</strong></label>
                                <input type="text" class="form-control" id="usaha" name="usaha" placeholder="Masukkan jenis dan nama usaha lengkap" required>
                            </div>
                            <div class="mb-3">
                                <label for="keperluan" class="form-label"><strong>KEPERLUAN</strong></label>
                                <input type="text" class="form-control" id="keperluan" name="keperluan" placeholder="Masukkan keperluan pengajuan surat" required>
                            </div>
                            <div class="mb-3">
                                <label for="bukti" class="form-label"><strong>BERKAS PERSYARATAN - <span style="color: red;">(Format: jpg, jpeg, png, doc, docx, pdf)</span></strong><br>
                                    (1) Surat Pengantar RT/RW<br>
                                    <input type="file" class="form-control" id="bukti_suket" name="bukti_suket" value="{{ old('bukti_suket') }}" multiple required><br>
                                    (2) Kartu Keluarga (KK)<br>
                                    <input type="file" class="form-control" id="bukti_kk" name="bukti_kk" value="{{ old('bukti_kk') }}" multiple required><br>
                                    (3) Kartu Tanda Penduduk (KTP)<br> 
                                    <input type="file" class="form-control" id="bukti_ktp" name="bukti_ktp" value="{{ old('bukti_ktp') }}" multiple required><br>
                                </label>                                                                
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Tutup</button>
                                <button type="submit" class="btn btn-primary">Simpan</button>
                            </div>
                        </div>
                    </form>

                    {{-- BELUM MENIKAH --}}
                    <form method="POST" action="{{ route('buat_skbm') }}" enctype="multipart/form-data">
                        @csrf
                        <div id="form_surat_SURAT KETERANGAN BELUM MENIKAH" class="form_surat" style="display: none;">
                            <input type="hidden" id="jenis_surat_2" name="jenis_surat_2" value="">
                            <div class="mb-3">
                                <label for="nama" class="form-label"><strong>NAMA</strong></label>
                                <input type="text" class="form-control" id="nama" name="nama" value="{{ auth()->user()->nama }}" readonly>
                            </div>
                            <div class="mb-3">
                                <label for="nik" class="form-label"><strong>NIK</strong></label>
                                <input type="text" class="form-control" id="nik" name="nik" value="{{ auth()->user()->nik }}" readonly>
                            </div>
                            <div class="mb-3">
                                <label for="ttl" class="form-label"><strong>TEMPAT, TANGGAL LAHIR - <span style="color: red;">(Contoh: Magetan, 30 Maret 1999)</span></strong></label>
                                <input type="text" class="form-control" id="ttl" name="ttl" placeholder="Masukkan tempat, tanggal lahir" required>
                            </div>
                            <div class="mb-3">
                                <label for="status_nikah" class="form-label"><strong>STATUS NIKAH</strong></label>
                                <select class="form-select" id="status_nikah" name="status_nikah" required>
                                    <option value="" selected hidden>-- Pilih Status --</option>
                                    @foreach(\App\Models\Status::whereIn('nama_status_nikah', ['Belum Kawin', 'Cerai Hidup', 'Cerai Mati'])->get() as $status_nikahs)
                                        <option value="{{ $status_nikahs->nama_status_nikah }}">{{ $status_nikahs->nama_status_nikah }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="mb-3">
                                <label for="agama" class="form-label"><strong>AGAMA</strong></label>
                                <select class="form-select" id="agama" name="agama" required>
                                    <option value="" selected hidden>-- Pilih Agama --</option>
                                    @foreach(\App\Models\Agama::all() as $agamas)
                                        <option value="{{ $agamas->nama_agama }}">{{ $agamas->nama_agama }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="mb-3">
                                <label for="pekerjaan_2" class="form-label"><strong>PEKERJAAN</strong></label>
                                <select class="form-select" id="pekerjaan_2" name="pekerjaan_2" required>
                                    <option value="" selected hidden>-- Pilih Pekerjaan --</option>
                                    @foreach(\App\Models\Pekerjaan::all() as $pekerjaans)
                                        <option value="{{ $pekerjaans->nama_pekerjaan }}">{{ $pekerjaans->nama_pekerjaan }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="mb-3" id="pekerjaan_lainnya_div_2" style="display: none;">
                                <label for="pekerjaan_lainnya_2" class="form-label"><strong>PEKERJAAN LAINNYA</strong></label>
                                <input type="text" class="form-control" id="pekerjaan_lainnya_2" name="pekerjaan_lainnya_2" placeholder="Masukkan pekerjaan lainnya yang belum ada di pilihan pekerjaan" required>
                            </div>
                            <div class="mb-3">
                                <label for="alamat" class="form-label"><strong>ALAMAT</strong></label>
                                <input type="text" class="form-control" id="alamat" name="alamat" placeholder="Masukkan alamat lengkap" required>
                            </div>
                            <div class="mb-3">
                                <label for="keperluan" class="form-label"><strong>KEPERLUAN</strong></label>
                                <input type="text" class="form-control" id="keperluan" name="keperluan" placeholder="Masukkan keperluan pengajuan surat" required>
                            </div>
                            <div class="mb-3">
                                <label for="bukti" class="form-label"><strong>BERKAS PERSYARATAN - <span style="color: red;">(Format: jpg, jpeg, png, doc, docx, pdf)</span></strong><br>
                                    (1) Surat Pengantar RT/RW <b>*wajib</b><br>
                                    <input type="file" class="form-control" id="bukti_suket" name="bukti_suket" value="{{ old('bukti_suket') }}" required><br>
                                    (2) Kartu Keluarga (KK) <b>*wajib</b><br>
                                    <input type="file" class="form-control" id="bukti_kk" name="bukti_kk" value="{{ old('bukti_kk') }}" required><br>
                                    (3) Kartu Tanda Penduduk (KTP) <b>*wajib</b><br> 
                                    <input type="file" class="form-control" id="bukti_ktp" name="bukti_ktp" value="{{ old('bukti_ktp') }}" required><br>
                                    (4) Akta Cerai - <b>*berlaku untuk Status Cerai Hidup</b><br> 
                                    <input type="file" class="form-control" id="bukti_cerai" name="bukti_cerai" value="{{ old('bukti_cerai') }}"><br>
                                    (5) Akta Kematian - <b>*berlaku untuk Status Cerai Mati</b><br> 
                                    <input type="file" class="form-control" id="bukti_kematian" name="bukti_kematian" value="{{ old('bukti_kematian') }}"><br>
                                </label>                                                                
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Tutup</button>
                                <button type="submit" class="btn btn-primary">Simpan</button>
                            </div>
                        </div>
                    </form>
                    
                    {{-- DOMISILI --}}
                    <form method="POST" action="{{ route('buat_skd') }}" enctype="multipart/form-data">
                        @csrf
                        <div id="form_surat_SURAT KETERANGAN DOMISILI" class="form_surat" style="display: none;">
                            <input type="hidden" id="jenis_surat_3" name="jenis_surat_3" value="">
                            <div class="mb-3">
                                <label for="nama" class="form-label"><strong>NAMA</strong></label>
                                <input type="text" class="form-control" id="nama" name="nama" value="{{ auth()->user()->nama }}" readonly>
                            </div>
                            <div class="mb-3">
                                <label for="nik" class="form-label"><strong>NIK</strong></label>
                                <input type="text" class="form-control" id="nik" name="nik" value="{{ auth()->user()->nik }}" readonly>
                            </div>
                            <div class="mb-3">
                                <label for="jenis_kelamin" class="form-label"><strong>JENIS KELAMIN</strong></label>
                                <select class="form-select" id="jenis_kelamin" name="jenis_kelamin" required>
                                    <option value="" selected hidden>-- Pilih Jenis Kelamin --</option>
                                    @foreach(\App\Models\JenisKelamin::all() as $jenis_kelamins)
                                        <option value="{{ $jenis_kelamins->nama_jenis_kelamin }}">{{ $jenis_kelamins->nama_jenis_kelamin }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="mb-3">
                                <label for="ttl" class="form-label"><strong>TEMPAT, TANGGAL LAHIR - <span style="color: red;">(Contoh: Magetan, 30 Maret 1999)</span></strong></label>
                                <input type="text" class="form-control" id="ttl" name="ttl" placeholder="Masukkan tempat, tanggal lahir" required>
                            </div>
                            <div class="mb-3">
                                <label for="agama" class="form-label"><strong>AGAMA</strong></label>
                                <select class="form-select" id="agama" name="agama" required>
                                    <option value="" selected hidden>-- Pilih Agama --</option>
                                    @foreach(\App\Models\Agama::all() as $agamas)
                                        <option value="{{ $agamas->nama_agama }}">{{ $agamas->nama_agama }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="mb-3">
                                <label for="status_nikah" class="form-label"><strong>STATUS NIKAH</strong></label>
                                <select class="form-select" id="status_nikah" name="status_nikah" required>
                                    <option value="" selected hidden>-- Pilih Status --</option>
                                    @foreach(\App\Models\Status::all() as $status_nikahs)
                                        <option value="{{ $status_nikahs->nama_status_nikah }}">{{ $status_nikahs->nama_status_nikah }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="mb-3">
                                <label for="pekerjaan_3" class="form-label"><strong>PEKERJAAN</strong></label>
                                <select class="form-select" id="pekerjaan_3" name="pekerjaan_3" required>
                                    <option value="" selected hidden>-- Pilih Pekerjaan --</option>
                                    @foreach(\App\Models\Pekerjaan::all() as $pekerjaans)
                                        <option value="{{ $pekerjaans->nama_pekerjaan }}">{{ $pekerjaans->nama_pekerjaan }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="mb-3" id="pekerjaan_lainnya_div_3" style="display: none;">
                                <label for="pekerjaan_lainnya_3" class="form-label"><strong>PEKERJAAN LAINNYA</strong></label>
                                <input type="text" class="form-control" id="pekerjaan_lainnya_3" name="pekerjaan_lainnya_3" placeholder="Masukkan pekerjaan lainnya yang belum ada di pilihan pekerjaan" required>
                            </div>
                            <div class="mb-3">
                                <label for="alamat" class="form-label"><strong>ALAMAT KTP</strong></label>
                                <input type="text" class="form-control" id="alamat" name="alamat" placeholder="Masukkan alamat lengkap sesuai dengan KTP" required>
                            </div>
                            <div class="mb-3">
                                <label for="alamat_dom" class="form-label"><strong>ALAMAT DOMISILI</strong></label>
                                <input type="text" class="form-control" id="alamat_dom" name="alamat_dom" placeholder="Masukkan alamat lengkap domisili/tempat tinggal sekarang" required>
                            </div>
                            <div class="mb-3">
                                <label for="keperluan" class="form-label"><strong>KEPERLUAN</strong></label>
                                <input type="text" class="form-control" id="keperluan" name="keperluan" placeholder="Masukkan keperluan pengajuan surat" required>
                            </div>
                            <div class="mb-3">
                                <label for="bukti" class="form-label"><strong>BERKAS PERSYARATAN - <span style="color: red;">(Format: jpg, jpeg, png, doc, docx, pdf)</span></strong><br>
                                    (1) Surat Pengantar RT/RW<br>
                                    <input type="file" class="form-control" id="bukti_suket" name="bukti_suket" value="{{ old('bukti_suket') }}" multiple required><br>
                                    (2) Kartu Keluarga (KK)<br>
                                    <input type="file" class="form-control" id="bukti_kk" name="bukti_kk" value="{{ old('bukti_kk') }}" multiple required><br>
                                    (3) Kartu Tanda Penduduk (KTP)<br> 
                                    <input type="file" class="form-control" id="bukti_ktp" name="bukti_ktp" value="{{ old('bukti_ktp') }}" multiple required><br>
                                </label>                                                                
                            </div>                            
                            <div class="modal-footer">
                                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Tutup</button>
                                <button type="submit" class="btn btn-primary">Simpan</button>
                            </div>
                        </div>
                    </form>

                    {{-- TIDAK MAMPU --}}
                    <form method="POST" action="{{ route('buat_sktm') }}" enctype="multipart/form-data">
                        @csrf
                        <div id="form_surat_SURAT KETERANGAN TIDAK MAMPU" class="form_surat" style="display: none;">
                            <input type="hidden" id="jenis_surat_4" name="jenis_surat_4" value="">
                            <div class="mb-3">
                                <label for="nama" class="form-label"><strong>NAMA</strong></label>
                                <input type="text" class="form-control" id="nama" name="nama" value="{{ auth()->user()->nama }}" readonly>
                            </div>
                            <div class="mb-3">
                                <label for="nik" class="form-label"><strong>NIK</strong></label>
                                <input type="text" class="form-control" id="nik" name="nik" value="{{ auth()->user()->nik }}" readonly>
                            </div>
                            <div class="mb-3">
                                <label for="ttl" class="form-label"><strong>TEMPAT, TANGGAL LAHIR - <span style="color: red;">(Contoh: Magetan, 30 Maret 1999)</span></strong></label>
                                <input type="text" class="form-control" id="ttl" name="ttl" placeholder="Masukkan tempat, tanggal lahir" required>
                            </div>
                            <div class="mb-3">
                                <label for="agama" class="form-label"><strong>AGAMA</strong></label>
                                <select class="form-select" id="agama" name="agama" required>
                                    <option value="" selected hidden>-- Pilih Agama --</option>
                                    @foreach(\App\Models\Agama::all() as $agamas)
                                        <option value="{{ $agamas->nama_agama }}">{{ $agamas->nama_agama }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="mb-3">
                                <label for="pekerjaan_4" class="form-label"><strong>PEKERJAAN</strong></label>
                                <select class="form-select" id="pekerjaan_4" name="pekerjaan_4" required>
                                    <option value="" selected hidden>-- Pilih Pekerjaan --</option>
                                    @foreach(\App\Models\Pekerjaan::all() as $pekerjaans)
                                        <option value="{{ $pekerjaans->nama_pekerjaan }}">{{ $pekerjaans->nama_pekerjaan }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="mb-3" id="pekerjaan_lainnya_div_4" style="display: none;">
                                <label for="pekerjaan_lainnya_4" class="form-label"><strong>PEKERJAAN LAINNYA</strong></label>
                                <input type="text" class="form-control" id="pekerjaan_lainnya_4" name="pekerjaan_lainnya_4" placeholder="Masukkan pekerjaan lainnya yang belum ada di pilihan pekerjaan" required>
                            </div>
                            <div class="mb-3">
                                <label for="alamat" class="form-label"><strong>ALAMAT</strong></label>
                                <input type="text" class="form-control" id="alamat" name="alamat" placeholder="Masukkan alamat lengkap" required>
                            </div>
                            <div class="mb-3">
                                <label for="keperluan" class="form-label"><strong>KEPERLUAN</strong></label>
                                <input type="text" class="form-control" id="keperluan" name="keperluan" placeholder="Masukkan keperluan pengajuan surat" required>
                            </div>
                            <div class="mb-3">
                                <label for="bukti" class="form-label"><strong>BERKAS PERSYARATAN - <span style="color: red;">(Format: jpg, jpeg, png, doc, docx, pdf)</span></strong><br>
                                    (1) Surat Pengantar RT/RW<br>
                                    <input type="file" class="form-control" id="bukti_suket" name="bukti_suket" value="{{ old('bukti_suket') }}" multiple required><br>
                                    (2) Kartu Keluarga (KK)<br>
                                    <input type="file" class="form-control" id="bukti_kk" name="bukti_kk" value="{{ old('bukti_kk') }}" multiple required><br>
                                    (3) Kartu Tanda Penduduk (KTP)<br> 
                                    <input type="file" class="form-control" id="bukti_ktp" name="bukti_ktp" value="{{ old('bukti_ktp') }}" multiple required><br>
                                </label>                                                                
                            </div>                            
                            <div class="modal-footer">
                                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Tutup</button>
                                <button type="submit" class="btn btn-primary">Simpan</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    {{-- ALASAN DITOLAK --}}
    <div class="modal fade" id="pesan_ditolak" tabindex="-1" aria-labelledby="pesanDitolakLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="pesanDitolakLabel">Pesan Ditolak</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <p id="pesanDitolakContent"></p>
                </div>
            </div>
        </div>
    </div>

    {{-- DETAIL SKU --}}
    <div class="modal fade" id="detailSKU" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title"><strong>DETAIL SURAT KETERANGAN USAHA</strong></h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <input type="hidden" name="id_sk_usaha" id="id_sk_usaha" required>
                    <div class="row mb-1">
                        <label class="col-md-2 col-form-label">JENIS SURAT</label>
                        <div class="col-md-9 d-flex align-items-center">
                            <span>:&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<label class="form-label" id="detail_jenis_surat"></label></span>
                        </div>
                    </div>
                    <div class="row mb-1">
                        <label class="col-md-2 col-form-label">NAMA</label>
                        <div class="col-md-9 d-flex align-items-center">
                            <span>:&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<label class="form-label" id="detail_nama"></label></span>
                        </div>
                    </div>
                    <div class="row mb-1">
                        <label class="col-md-2 col-form-label">NIK</label>
                        <div class="col-md-9 d-flex align-items-center">
                            <span>:&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<label class="form-label" id="detail_nik"></label></span>
                        </div>
                    </div>
                    <div class="row mb-1">
                        <label class="col-md-2 col-form-label">TEMPAT, TANGGAL LAHIR</label>
                        <div class="col-md-9 d-flex align-items-center">
                            <span>:&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<label class="form-label" id="detail_ttl"></label></span>
                        </div>
                    </div>
                    <div class="row mb-1">
                        <label class="col-md-2 col-form-label">STATUS NIKAH</label>
                        <div class="col-md-9 d-flex align-items-center">
                            <span>:&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<label class="form-label" id="detail_status_nikah"></label></span>
                        </div>
                    </div>
                    <div class="row mb-1">
                        <label class="col-md-2 col-form-label">AGAMA</label>
                        <div class="col-md-9 d-flex align-items-center">
                            <span>:&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<label class="form-label" id="detail_agama"></label></span>
                        </div>
                    </div>
                    <div class="row mb-1">
                        <label class="col-md-2 col-form-label">PEKERJAAN</label>
                        <div class="col-md-9 d-flex align-items-center">
                            <span>:&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<label class="form-label" id="detail_pekerjaan"></label></span>
                        </div>
                    </div>
                    <div class="row mb-1">
                        <label class="col-md-2 col-form-label">ALAMAT</label>
                        <div class="col-md-9 d-flex align-items-center">
                            <span>:&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<label class="form-label" id="detail_alamat"></label></span>
                        </div>
                    </div>
                    <div class="row mb-1">
                        <label class="col-md-2 col-form-label">USAHA</label>
                        <div class="col-md-9 d-flex align-items-center">
                            <span>:&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<label class="form-label" id="detail_usaha"></label></span>
                        </div>
                    </div>
                    <div class="row mb-1">
                        <label class="col-md-2 col-form-label">KEPERLUAN</label>
                        <div class="col-md-9 d-flex align-items-center">
                            <span>:&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<label class="form-label" id="detail_keperluan"></label></span>
                        </div>
                    </div>
                    <div class="row mb-1">
                        <label class="col-md-2 col-form-label">BERKAS PERSYARATAN</label>
                        <div class="col-md-9">
                            <div class="d-flex">
                                <span>:&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</span>
                                <ul class="list-unstyled mb-0 w-100">
                                    <li class="row align-items-center mb-1">
                                        <div class="col-md-6">
                                            <label class="form-label mb-0">Surat Pengantar RT/RW</label>
                                        </div>
                                        <div class="col-md-6">
                                            <a id="detail_bukti_suket" class="btn btn-primary btn-sm w-100" href="#" target="_blank">Unduh</a>
                                        </div>
                                    </li>
                                    <li class="row align-items-center mb-1">
                                        <div class="col-md-6">
                                            <label class="form-label mb-0">Kartu Keluarga (KK)</label>
                                        </div>
                                        <div class="col-md-6">
                                            <a id="detail_bukti_kk" class="btn btn-primary btn-sm w-100" href="#" target="_blank">Unduh</a>
                                        </div>
                                    </li>
                                    <li class="row align-items-center">
                                        <div class="col-md-6">
                                            <label class="form-label mb-0">Kartu Tanda Penduduk (KTP)</label>
                                        </div>
                                        <div class="col-md-6">
                                            <a id="detail_bukti_ktp" class="btn btn-primary btn-sm w-100" href="#" target="_blank">Unduh</a>
                                        </div>
                                    </li>
                                </ul>
                            </div>
                        </div>
                    </div>                    
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Tutup</button>
                </div>
            </div>
        </div>
    </div>

    {{-- DETAIL SKBM --}}
    <div class="modal fade" id="detailSKBM" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title"><strong>DETAIL SURAT KETERANGAN BELUM MENIKAH</strong></h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <input type="hidden" name="id_sk_belum_menikah" id="id_sk_belum_menikah" required>
                    <div class="row mb-1">
                        <label class="col-md-2 col-form-label">JENIS SURAT</label>
                        <div class="col-md-9 d-flex align-items-center">
                            <span>:&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<label class="form-label" id="detail_jenis_surat_2"></label></span>
                        </div>
                    </div>
                    <div class="row mb-1">
                        <label class="col-md-2 col-form-label">NAMA</label>
                        <div class="col-md-9 d-flex align-items-center">
                            <span>:&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<label class="form-label" id="detail_nama_2"></label></span>
                        </div>
                    </div>
                    <div class="row mb-1">
                        <label class="col-md-2 col-form-label">NIK</label>
                        <div class="col-md-9 d-flex align-items-center">
                            <span>:&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<label class="form-label" id="detail_nik_2"></label></span>
                        </div>
                    </div>
                    <div class="row mb-1">
                        <label class="col-md-2 col-form-label">TEMPAT, TANGGAL LAHIR</label>
                        <div class="col-md-9 d-flex align-items-center">
                            <span>:&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<label class="form-label" id="detail_ttl_2"></label></span>
                        </div>
                    </div>
                    <div class="row mb-1">
                        <label class="col-md-2 col-form-label">STATUS NIKAH</label>
                        <div class="col-md-9 d-flex align-items-center">
                            <span>:&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<label class="form-label" id="detail_status_nikah_2"></label></span>
                        </div>
                    </div>
                    <div class="row mb-1">
                        <label class="col-md-2 col-form-label">AGAMA</label>
                        <div class="col-md-9 d-flex align-items-center">
                            <span>:&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<label class="form-label" id="detail_agama_2"></label></span>
                        </div>
                    </div>
                    <div class="row mb-1">
                        <label class="col-md-2 col-form-label">PEKERJAAN</label>
                        <div class="col-md-9 d-flex align-items-center">
                            <span>:&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<label class="form-label" id="detail_pekerjaan_2"></label></span>
                        </div>
                    </div>
                    <div class="row mb-1">
                        <label class="col-md-2 col-form-label">ALAMAT</label>
                        <div class="col-md-9 d-flex align-items-center">
                            <span>:&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<label class="form-label" id="detail_alamat_2"></label></span>
                        </div>
                    </div>
                    <div class="row mb-1">
                        <label class="col-md-2 col-form-label">KEPERLUAN</label>
                        <div class="col-md-9 d-flex align-items-center">
                            <span>:&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<label class="form-label" id="detail_keperluan_2"></label></span>
                        </div>
                    </div>
                    <div class="row mb-1">
                        <label class="col-md-2 col-form-label">BERKAS PERSYARATAN</label>
                        <div class="col-md-9">
                            <div class="d-flex">
                                <span>:&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</span>
                                <ul class="list-unstyled mb-0 w-100">
                                    <li id="suket" class="row align-items-center mb-2">
                                        <div class="col-md-6">
                                            <label class="form-label mb-0">Surat Pengantar RT/RW</label>
                                        </div>
                                        <div class="col-md-6">
                                            <a id="detail_bukti_suket_2" class="btn btn-primary btn-sm w-100" href="#" target="_blank">Unduh</a>
                                        </div>
                                    </li>
                                    <li id="kk" class="row align-items-center mb-2">
                                        <div class="col-md-6">
                                            <label class="form-label mb-0">Kartu Keluarga (KK)</label>
                                        </div>
                                        <div class="col-md-6">
                                            <a id="detail_bukti_kk_2" class="btn btn-primary btn-sm w-100" href="#" target="_blank">Unduh</a>
                                        </div>
                                    </li>
                                    <li id="ktp" class="row align-items-center mb-2">
                                        <div class="col-md-6">
                                            <label class="form-label mb-0">Kartu Tanda Penduduk (KTP)</label>
                                        </div>
                                        <div class="col-md-6">
                                            <a id="detail_bukti_ktp_2" class="btn btn-primary btn-sm w-100" href="#" target="_blank">Unduh</a>
                                        </div>
                                    </li>
                                    <li id="akta_cerai" class="row align-items-center mb-2">
                                        <div class="col-md-6">
                                            <label class="form-label mb-0">Akta Cerai</label>
                                        </div>
                                        <div class="col-md-6">
                                            <a id="detail_bukti_cerai_2" class="btn btn-primary btn-sm w-100" href="#" target="_blank">Unduh</a>
                                        </div>
                                    </li>
                                    <li id="akta_kematian" class="row align-items-center mb-2">
                                        <div class="col-md-6">
                                            <label class="form-label mb-0">Akta Kematian</label>
                                        </div>
                                        <div class="col-md-6">
                                            <a id="detail_bukti_kematian_2" class="btn btn-primary btn-sm w-100" href="#" target="_blank">Unduh</a>
                                        </div>
                                    </li>
                                </ul>
                            </div>
                        </div>
                    </div>                
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Tutup</button>
                </div>
            </div>
        </div>
    </div>   

    {{-- DETAIL SKD --}}
    <div class="modal fade" id="detailSKD" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title"><strong>DETAIL SURAT KETERANGAN DOMISILI</strong></h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <input type="hidden" name="id_sk_domisili" id="id_sk_domisili" required>
                    <div class="row mb-1">
                        <label class="col-md-2 col-form-label">JENIS SURAT</label>
                        <div class="col-md-9 d-flex align-items-center">
                            <span>:&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<label class="form-label" id="detail_jenis_surat_3"></label></span>
                        </div>
                    </div>
                    <div class="row mb-1">
                        <label class="col-md-2 col-form-label">NAMA</label>
                        <div class="col-md-9 d-flex align-items-center">
                            <span>:&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<label class="form-label" id="detail_nama_3"></label></span>
                        </div>
                    </div>
                    <div class="row mb-1">
                        <label class="col-md-2 col-form-label">NIK</label>
                        <div class="col-md-9 d-flex align-items-center">
                            <span>:&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<label class="form-label" id="detail_nik_3"></label></span>
                        </div>
                    </div>
                    <div class="row mb-1">
                        <label class="col-md-2 col-form-label">JENIS KELAMIN</label>
                        <div class="col-md-9 d-flex align-items-center">
                            <span>:&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<label class="form-label" id="detail_jenis_kelamin_3"></label></span>
                        </div>
                    </div>
                    <div class="row mb-1">
                        <label class="col-md-2 col-form-label">TEMPAT, TANGGAL LAHIR</label>
                        <div class="col-md-9 d-flex align-items-center">
                            <span>:&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<label class="form-label" id="detail_ttl_3"></label></span>
                        </div>
                    </div>
                    <div class="row mb-1">
                        <label class="col-md-2 col-form-label">AGAMA</label>
                        <div class="col-md-9 d-flex align-items-center">
                            <span>:&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<label class="form-label" id="detail_agama_3"></label></span>
                        </div>
                    </div>
                    <div class="row mb-1">
                        <label class="col-md-2 col-form-label">STATUS NIKAH</label>
                        <div class="col-md-9 d-flex align-items-center">
                            <span>:&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<label class="form-label" id="detail_status_nikah_3"></label></span>
                        </div>
                    </div>
                    <div class="row mb-1">
                        <label class="col-md-2 col-form-label">PEKERJAAN</label>
                        <div class="col-md-9 d-flex align-items-center">
                            <span>:&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<label class="form-label" id="detail_pekerjaan_3"></label></span>
                        </div>
                    </div>
                    <div class="row mb-1">
                        <label class="col-md-2 col-form-label">ALAMAT KTP</label>
                        <div class="col-md-9 d-flex align-items-center">
                            <span>:&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<label class="form-label" id="detail_alamat_3"></label></span>
                        </div>
                    </div>
                    <div class="row mb-1">
                        <label class="col-md-2 col-form-label">ALAMAT DOMISILI</label>
                        <div class="col-md-9 d-flex align-items-center">
                            <span>:&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<label class="form-label" id="detail_alamat_dom_3"></label></span>
                        </div>
                    </div>
                    <div class="row mb-1">
                        <label class="col-md-2 col-form-label">KEPERLUAN</label>
                        <div class="col-md-9 d-flex align-items-center">
                            <span>:&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<label class="form-label" id="detail_keperluan_3"></label></span>
                        </div>
                    </div>
                    <div class="row mb-1">
                        <label class="col-md-2 col-form-label">BERKAS PERSYARATAN</label>
                        <div class="col-md-9">
                            <div class="d-flex">
                                <span>:&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</span>
                                <ul class="list-unstyled mb-0 w-100">
                                    <li class="row align-items-center mb-1">
                                        <div class="col-md-6">
                                            <label class="form-label mb-0">Surat Pengantar RT/RW</label>
                                        </div>
                                        <div class="col-md-6">
                                            <a id="detail_bukti_suket_3" class="btn btn-primary btn-sm w-100" href="#" target="_blank">Unduh</a>
                                        </div>
                                    </li>
                                    <li class="row align-items-center mb-1">
                                        <div class="col-md-6">
                                            <label class="form-label mb-0">Kartu Keluarga (KK)</label>
                                        </div>
                                        <div class="col-md-6">
                                            <a id="detail_bukti_kk_3" class="btn btn-primary btn-sm w-100" href="#" target="_blank">Unduh</a>
                                        </div>
                                    </li>
                                    <li class="row align-items-center">
                                        <div class="col-md-6">
                                            <label class="form-label mb-0">Kartu Tanda Penduduk (KTP)</label>
                                        </div>
                                        <div class="col-md-6">
                                            <a id="detail_bukti_ktp_3" class="btn btn-primary btn-sm w-100" href="#" target="_blank">Unduh</a>
                                        </div>
                                    </li>
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Tutup</button>
                </div>
            </div>
        </div>
    </div>    

    {{-- DETAIL SKTM --}}
    <div class="modal fade" id="detailSKTM" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title"><strong>DETAIL SURAT KETERANGAN TIDAK MAMPU</strong></h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <input type="hidden" name="id_sk_tidak_mampu" id="id_sk_tidak_mampu" required>
                    <div class="row mb-1">
                        <label class="col-md-2 col-form-label">JENIS SURAT</label>
                        <div class="col-md-9 d-flex align-items-center">
                            <span>:&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<label class="form-label" id="detail_jenis_surat_4"></label></span>
                        </div>
                    </div>
                    <div class="row mb-1">
                        <label class="col-md-2 col-form-label">NAMA</label>
                        <div class="col-md-9 d-flex align-items-center">
                            <span>:&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<label class="form-label" id="detail_nama_4"></label></span>
                        </div>
                    </div>
                    <div class="row mb-1">
                        <label class="col-md-2 col-form-label">NIK</label>
                        <div class="col-md-9 d-flex align-items-center">
                            <span>:&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<label class="form-label" id="detail_nik_4"></label></span>
                        </div>
                    </div>
                    <div class="row mb-1">
                        <label class="col-md-2 col-form-label">TEMPAT, TANGGAL LAHIR</label>
                        <div class="col-md-9 d-flex align-items-center">
                            <span>:&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<label class="form-label" id="detail_ttl_4"></label></span>
                        </div>
                    </div>
                    <div class="row mb-1">
                        <label class="col-md-2 col-form-label">AGAMA</label>
                        <div class="col-md-9 d-flex align-items-center">
                            <span>:&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<label class="form-label" id="detail_agama_4"></label></span>
                        </div>
                    </div>
                    <div class="row mb-1">
                        <label class="col-md-2 col-form-label">PEKERJAAN</label>
                        <div class="col-md-9 d-flex align-items-center">
                            <span>:&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<label class="form-label" id="detail_pekerjaan_4"></label></span>
                        </div>
                    </div>
                    <div class="row mb-1">
                        <label class="col-md-2 col-form-label">ALAMAT</label>
                        <div class="col-md-9 d-flex align-items-center">
                            <span>:&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<label class="form-label" id="detail_alamat_4"></label></span>
                        </div>
                    </div>
                    <div class="row mb-1">
                        <label class="col-md-2 col-form-label">KEPERLUAN</label>
                        <div class="col-md-9 d-flex align-items-center">
                            <span>:&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<label class="form-label" id="detail_keperluan_4"></label></span>
                        </div>
                    </div>
                    <div class="row mb-1">
                        <label class="col-md-2 col-form-label">BERKAS PERSYARATAN</label>
                        <div class="col-md-9">
                            <div class="d-flex">
                                <span>:&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</span>
                                <ul class="list-unstyled mb-0 w-100">
                                    <li class="row align-items-center mb-1">
                                        <div class="col-md-6">
                                            <label class="form-label mb-0">Surat Pengantar RT/RW</label>
                                        </div>
                                        <div class="col-md-6">
                                            <a id="detail_bukti_suket_4" class="btn btn-primary btn-sm w-100" href="#" target="_blank">Unduh</a>
                                        </div>
                                    </li>
                                    <li class="row align-items-center mb-1">
                                        <div class="col-md-6">
                                            <label class="form-label mb-0">Kartu Keluarga (KK)</label>
                                        </div>
                                        <div class="col-md-6">
                                            <a id="detail_bukti_kk_4" class="btn btn-primary btn-sm w-100" href="#" target="_blank">Unduh</a>
                                        </div>
                                    </li>
                                    <li class="row align-items-center">
                                        <div class="col-md-6">
                                            <label class="form-label mb-0">Kartu Tanda Penduduk (KTP)</label>
                                        </div>
                                        <div class="col-md-6">
                                            <a id="detail_bukti_ktp_4" class="btn btn-primary btn-sm w-100" href="#" target="_blank">Unduh</a>
                                        </div>
                                    </li>
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Tutup</button>
                </div>
            </div>
        </div>
    </div>    
@endsection

@section('script')
    <script>
        $(document).ready(function() {
            var table = $('.table').DataTable({
                order: [[0, 'desc']], // Gantilah 3 dengan indeks kolom tanggal yang sesuai
                columnDefs: [
                    { orderable: false, targets: [5] }
                ],
                language: {
                    lengthMenu: "Tampilkan _MENU_ data per halaman",
                    zeroRecords: "Data tidak ditemukan.",
                    info: "Menampilkan _START_ - _END_ dari _TOTAL_ data",
                    infoEmpty: "Menampilkan 0 - 0 dari 0 data",
                    infoFiltered: "(difilter dari _MAX_ total data)",
                    search: "Cari",
                    decimal: ",",
                    thousands: ".",
                    paginate: {
                        previous: "Sebelumnya",
                        next: "Selanjutnya"
                    }
                }
            });
        });

        document.addEventListener('DOMContentLoaded', function () {
            $('#pesan_ditolak').on('show.bs.modal', function (event) {
                var button = $(event.relatedTarget);
                var pesan = button.data('bs-pesan');

                var modal = $(this);
                modal.find('.modal-body #pesanDitolakContent').text(pesan ? pesan : 'Pesan tidak tersedia.');
            });
        });

        document.addEventListener('DOMContentLoaded', function () {
            var pesanModal = document.getElementById('pesan_ditolak');
            pesanModal.addEventListener('show.bs.modal', function (event) {
                var button = event.relatedTarget; // Tombol yang memicu modal
                var pesan = button.getAttribute('data-bs-pesan'); // Ambil nilai data-bs-pesan

                var modalBody = pesanModal.querySelector('.modal-body'); // Elemen modal-body
                modalBody.textContent = pesan; // Isi modal-body dengan pesan
            });
        });

        // JENIS SURAT
        function showForm() {
            var jenisSurat = document.getElementById("jenis_surat").value;
            
            document.getElementById("jenis_surat_1").value = jenisSurat;
            document.getElementById("jenis_surat_2").value = jenisSurat;
            document.getElementById("jenis_surat_3").value = jenisSurat;
            document.getElementById("jenis_surat_4").value = jenisSurat;

            var formSurat = document.getElementsByClassName("form_surat");
            for (var i = 0; i < formSurat.length; i++) {
                formSurat[i].style.display = "none";
            }
            if (jenisSurat) {
                document.getElementById("form_surat_" + jenisSurat).style.display = "block";
            }
        }

        // PEKERJAAN LAINNYA SKU
        document.addEventListener('DOMContentLoaded', function () {
            var pekerjaanSelect = document.getElementById('pekerjaan');
            var pekerjaanLainnyaDiv = document.getElementById('pekerjaan_lainnya_div');
            var pekerjaanLainnyaInput = document.getElementById('pekerjaan_lainnya');

            pekerjaanSelect.addEventListener('change', function () {
                if (pekerjaanSelect.value === 'Lainnya') {
                    pekerjaanLainnyaDiv.style.display = 'block';
                    pekerjaanLainnyaInput.setAttribute('required', 'required');
                } else {
                    pekerjaanLainnyaDiv.style.display = 'none';
                    pekerjaanLainnyaInput.removeAttribute('required');
                }
            });
        });    

        // PEKERJAAN LAINNYA SKBM
        document.addEventListener('DOMContentLoaded', function () {
            var pekerjaanSelect = document.getElementById('pekerjaan_2');
            var pekerjaanLainnyaDiv = document.getElementById('pekerjaan_lainnya_div_2');
            var pekerjaanLainnyaInput = document.getElementById('pekerjaan_lainnya_2');

            pekerjaanSelect.addEventListener('change', function () {
                if (pekerjaanSelect.value === 'Lainnya') {
                    pekerjaanLainnyaDiv.style.display = 'block';
                    pekerjaanLainnyaInput.setAttribute('required', 'required');
                } else {
                    pekerjaanLainnyaDiv.style.display = 'none';
                    pekerjaanLainnyaInput.removeAttribute('required');
                }
            });
        }); 
        
        // PEKERJAAN LAINNYA SKD
        document.addEventListener('DOMContentLoaded', function () {
            var pekerjaanSelect = document.getElementById('pekerjaan_3');
            var pekerjaanLainnyaDiv = document.getElementById('pekerjaan_lainnya_div_3');
            var pekerjaanLainnyaInput = document.getElementById('pekerjaan_lainnya_3');

            pekerjaanSelect.addEventListener('change', function () {
                if (pekerjaanSelect.value === 'Lainnya') {
                    pekerjaanLainnyaDiv.style.display = 'block';
                    pekerjaanLainnyaInput.setAttribute('required', 'required');
                } else {
                    pekerjaanLainnyaDiv.style.display = 'none';
                    pekerjaanLainnyaInput.removeAttribute('required');
                }
            });
        });

        // PEKERJAAN LAINNYA SKTM
        document.addEventListener('DOMContentLoaded', function () {
            var pekerjaanSelect = document.getElementById('pekerjaan_4');
            var pekerjaanLainnyaDiv = document.getElementById('pekerjaan_lainnya_div_4');
            var pekerjaanLainnyaInput = document.getElementById('pekerjaan_lainnya_4');

            pekerjaanSelect.addEventListener('change', function () {
                if (pekerjaanSelect.value === 'Lainnya') {
                    pekerjaanLainnyaDiv.style.display = 'block';
                    pekerjaanLainnyaInput.setAttribute('required', 'required');
                } else {
                    pekerjaanLainnyaDiv.style.display = 'none';
                    pekerjaanLainnyaInput.removeAttribute('required');
                }
            });
        });    

        // DETAIL SKU
        $('#detailSKU').on('show.bs.modal', function (event) {
            var button = $(event.relatedTarget);
            $.ajax({
                url: '{{ route("get_data_sku") }}',
                type: 'POST',
                data: {
                    id: button.data('bs-id'),
                    _token: '{{ csrf_token() }}',
                },
                dataType: 'JSON',
                success: function(response) {
                    if (response.status == 'success') {
                        var surat = response.surat;
                        $("#detail_jenis_surat").html(surat.jenis_surat);
                        $("#detail_nama").html(surat.nama);
                        $("#detail_nik").html(surat.nik);
                        $("#detail_ttl").html(surat.ttl);
                        $("#detail_status_nikah").html(surat.status_nikah);
                        $("#detail_agama").html(surat.agama);
                        $("#detail_pekerjaan").html(surat.pekerjaan);
                        $("#detail_alamat").html(surat.alamat);
                        $("#detail_usaha").html(surat.usaha);
                        $("#detail_keperluan").html(surat.keperluan);
                        $("#detail_bukti_suket").attr("href", '/bukti_dokumen/SKU/' + surat.bukti_suket);
                        $("#detail_bukti_kk").attr("href", '/bukti_dokumen/SKU/' + surat.bukti_kk);
                        $("#detail_bukti_ktp").attr("href", '/bukti_dokumen/SKU/' + surat.bukti_ktp);

                        if (surat.pekerjaan === 'Lainnya') {
                            $("#detail_pekerjaan").html(surat.pekerjaan_lainnya);
                            $("#pekerjaan_lainnya_row").show();
                        } else {
                            $("#detail_pekerjaan").html(surat.pekerjaan);
                            $("#pekerjaan_lainnya_row").hide();
                        }
                    }
                }, 
            });
        });

        // DETAIL SKBM
        $('#detailSKBM').on('show.bs.modal', function (event) {
            var button = $(event.relatedTarget);
            $.ajax({
                url: '{{ route("get_data_skbm") }}',
                type: 'POST',
                data: {
                    id: button.data('bs-id'),
                    _token: '{{ csrf_token() }}',
                },
                dataType: 'JSON',
                success: function(response) {
                    if (response.status == 'success') {
                        var surat = response.surat;
                        $("#detail_jenis_surat_2").html(surat.jenis_surat);
                        $("#detail_nama_2").html(surat.nama);
                        $("#detail_nik_2").html(surat.nik);
                        $("#detail_ttl_2").html(surat.ttl);
                        $("#detail_status_nikah_2").html(surat.status_nikah);
                        $("#detail_agama_2").html(surat.agama);
                        $("#detail_alamat_2").html(surat.alamat);
                        $("#detail_keperluan_2").html(surat.keperluan);
                        $("#detail_bukti_suket_2").attr("href", '/bukti_dokumen/SKBM/' + surat.bukti_suket);
                        $("#detail_bukti_kk_2").attr("href", '/bukti_dokumen/SKBM/' + surat.bukti_kk);
                        $("#detail_bukti_ktp_2").attr("href", '/bukti_dokumen/SKBM/' + surat.bukti_ktp);
                        $("#detail_bukti_cerai_2").attr("href", '/bukti_dokumen/SKBM/' + surat.bukti_cerai);
                        $("#detail_bukti_kematian_2").attr("href", '/bukti_dokumen/SKBM/' + surat.bukti_kematian);

                        if (surat.pekerjaan === 'Lainnya') {
                            $("#detail_pekerjaan_2").html(surat.pekerjaan_lainnya);
                            $("#pekerjaan_lainnya_2_row").show();
                        } else {
                            $("#detail_pekerjaan_2").html(surat.pekerjaan);
                            $("#pekerjaan_lainnya_2_row").hide();
                        }

                        $("#suket").show();
                        $("#kk").show();
                        $("#ktp").show();
                        $("#akta_cerai").hide();
                        $("#akta_kematian").hide();

                        if (surat.status_nikah === 'Belum Kawin') {
                            $("#akta_cerai").hide();
                            $("#akta_kematian").hide();
                        } else if (surat.status_nikah === 'Cerai Hidup') {
                            $("#akta_cerai").show();
                            $("#akta_kematian").hide();
                        } else if (surat.status_nikah === 'Cerai Mati') {
                            $("#akta_cerai").hide();
                            $("#akta_kematian").show();
                        }
                    }
                },
            });
        });

        // DETAIL SKD
        $('#detailSKD').on('show.bs.modal', function (event) {
            var button = $(event.relatedTarget);
            $.ajax({
                url: '{{ route("get_data_skd") }}',
                type: 'POST',
                data: {
                    id: button.data('bs-id'),
                    _token: '{{ csrf_token() }}',
                },
                dataType: 'JSON',
                success: function(response) {
                    if (response.status == 'success') {
                        var surat = response.surat;
                        $("#detail_jenis_surat_3").html(surat.jenis_surat);
                        $("#detail_nama_3").html(surat.nama);
                        $("#detail_nik_3").html(surat.nik);
                        $("#detail_jenis_kelamin_3").html(surat.jenis_kelamin);
                        $("#detail_ttl_3").html(surat.ttl);
                        $("#detail_agama_3").html(surat.agama);
                        $("#detail_status_nikah_3").html(surat.status_nikah);
                        $("#detail_alamat_3").html(surat.alamat);
                        $("#detail_alamat_dom_3").html(surat.alamat_dom);
                        $("#detail_keperluan_3").html(surat.keperluan);
                        $("#detail_bukti_suket_3").attr("href", '/bukti_dokumen/SKD/' + surat.bukti_suket);
                        $("#detail_bukti_kk_3").attr("href", '/bukti_dokumen/SKD/' + surat.bukti_kk);
                        $("#detail_bukti_ktp_3").attr("href", '/bukti_dokumen/SKD/' + surat.bukti_ktp);

                        if (surat.pekerjaan === 'Lainnya') {
                            $("#detail_pekerjaan_3").html(surat.pekerjaan_lainnya);
                            $("#pekerjaan_lainnya_3_row").show();
                        } else {
                            $("#detail_pekerjaan_3").html(surat.pekerjaan);
                            $("#pekerjaan_lainnya_3_row").hide();
                        }
                    }
                },
            });
        });

        // DETAIL SKTM
        $('#detailSKTM').on('show.bs.modal', function (event) {
            var button = $(event.relatedTarget);
            $.ajax({
                url: '{{ route("get_data_sktm") }}',
                type: 'POST',
                data: {
                    id: button.data('bs-id'),
                    _token: '{{ csrf_token() }}',
                },
                dataType: 'JSON',
                success: function(response) {
                    if (response.status == 'success') {
                        var surat = response.surat;
                        $("#detail_jenis_surat_4").html(surat.jenis_surat);
                        $("#detail_nama_4").html(surat.nama);
                        $("#detail_nik_4").html(surat.nik);
                        $("#detail_ttl_4").html(surat.ttl);
                        $("#detail_agama_4").html(surat.agama);
                        $("#detail_alamat_4").html(surat.alamat);
                        $("#detail_keperluan_4").html(surat.keperluan);
                        $("#detail_bukti_suket_4").attr("href", '/bukti_dokumen/SKTM/' + surat.bukti_suket);
                        $("#detail_bukti_kk_4").attr("href", '/bukti_dokumen/SKTM/' + surat.bukti_kk);
                        $("#detail_bukti_ktp_4").attr("href", '/bukti_dokumen/SKTM/' + surat.bukti_ktp);

                        if (surat.pekerjaan === 'Lainnya') {
                            $("#detail_pekerjaan_4").html(surat.pekerjaan_lainnya);
                            $("#pekerjaan_lainnya_4_row").show();
                        } else {
                            $("#detail_pekerjaan_4").html(surat.pekerjaan);
                            $("#pekerjaan_lainnya_4_row").hide();
                        }
                    }
                },
            });
        });
    </script>
@endsection
