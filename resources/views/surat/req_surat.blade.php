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
                            <h5>Data Pengajuan Surat</h5>
                        </div>
                        <div class="text-end mb-4">
                            <button data-bs-toggle="modal" data-bs-target="#tambahsuratbaru" class="btn btn-primary">AJUKAN SURAT</button>
                        </div>                    
                        <div class="container-fluid table-responsive px-3 py-3">
                            <table class="table table-striped" id="tabelSPT" style="width:100%">
                                <thead>
                                    <tr>
                                        <th class="col-md-1 text-center align-middle">Tanggal Pengajuan</th>                           
                                        <th class="col-md-2 text-center align-middle">Jenis Surat</th>                           
                                        <th class="col-md-2 text-center align-middle">NIK</th>                           
                                        <th class="col-md-2 text-center align-middle">Nama</th>                           
                                        <th class="col-md-2 text-center align-middle">Status</th>                           
                                        <th class="col-md-2 text-center align-middle">Aksi</th>                           
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
                                            <td class="text-center">
                                                <div class="d-flex justify-content-center">
                                                    <button type="button" data-bs-toggle="modal" data-bs-target="#detailSKU" data-bs-id="{{ $sk_usaha->id_sk_usaha }}" class="btn btn-info btn-sm">Detail</button>
                                                    @if($sk_usaha->status_surat === 'Ditolak')
                                                        <button type="button" data-bs-toggle="modal" data-bs-target="#pesan_ditolak" data-bs-id="{{ $sk_usaha->id_sk_usaha }}" data-bs-pesan="{{ $sk_usaha->pesan }}" class="btn btn-info btn-sm">Pesan Ditolak</button>
                                                    @endif
                                                </div>
                                                <script>
                                                </script>
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
                                            <td class="text-center">
                                                <div class="d-flex justify-content-center">
                                                    <button type="button" data-bs-toggle="modal" data-bs-target="#detailSKBM" data-bs-id="{{ $sk_belum_menikah->id_sk_belum_menikah }}" class="btn btn-info btn-sm">Detail</button>
                                                    @if($sk_belum_menikah->status_surat === 'Ditolak')
                                                        <button type="button" data-bs-toggle="modal" data-bs-target="#pesan_ditolak" data-bs-id="{{ $sk_belum_menikah->id_sk_belum_menikah }}" data-bs-pesan="{{ $sk_belum_menikah->pesan }}" class="btn btn-info btn-sm">Pesan Ditolak</button>
                                                    @endif
                                                </div>
                                                <script>
                                                </script>
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
                                            <td class="text-center">
                                                <div class="d-flex justify-content-center">
                                                    <button type="button" data-bs-toggle="modal" data-bs-target="#detailSKD" data-bs-id="{{ $skd->id_sk_domisili }}" class="btn btn-info btn-sm">Detail</button>
                                                    @if($skd->status_surat === 'Ditolak')
                                                        <button type="button" data-bs-toggle="modal" data-bs-target="#pesan_ditolak" data-bs-id="{{ $skd->id_sk_domisili }}" data-bs-pesan="{{ $skd->pesan }}" class="btn btn-info btn-sm">Pesan Ditolak</button>
                                                    @endif
                                                </div>
                                                <script>
                                                </script>
                                            </td>
                                        </tr>
                                    @endforeach

                                    {{-- @foreach(\App\Models\SKTidakMampu::where('pemohon', auth()->user()->nik)->get() as $sktm)
                                        <tr>      
                                            <td class="text-center align-middle">{{ $sktm->tanggal }}</td>
                                            <td class="text-center align-middle">{{ $sktm->jenis_surat }}</td>
                                            <td class="text-center align-middle">{{ $sktm->nik }}</td>
                                            <td class="text-center align-middle">{{ $sktm->nama }}</td>
                                            <td class="text-center align-middle">{{ $sktm->status_surat }}</td>
                                            <td class="text-center">
                                                <div class="d-flex justify-content-center">
                                                    <button type="button" data-bs-toggle="modal" data-bs-target="#detailSKU" data-bs-id="{{ $sktm->id_sk_tidak_mampu }}" class="btn btn-info btn-sm">Detail</button>
                                                </div>
                                                <script>
                                                </script>
                                            </td>
                                        </tr>
                                    @endforeach --}}
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
    <div class="modal fade" id="tambahsuratbaru" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Pengajuan Surat Baru</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="mb-3">
                        <label for="jenis_surat" class="form-label">Jenis Surat</label>
                        <select class="form-select" id="jenis_surat" name="jenis_surat" required onchange="showForm()" required>
                            <option value="" selected hidden>-- Pilih Jenis Surat --</option>
                            @foreach(\App\Models\JenisSurat::all() as $jenis_surats)
                                <option value="{{ $jenis_surats->nama_jenis_surat }}">{{ $jenis_surats->nama_jenis_surat }}</option>
                            @endforeach
                        </select>
                    </div>

                    {{-- SKU --}}
                    <form method="POST" action="{{ route('buat_sku') }}" enctype="multipart/form-data">
                        @csrf
                        <div id="form_surat_SURAT KETERANGAN USAHA" class="form_surat" style="display: none;">
                            <input type="hidden" id="jenis_surat" name="jenis_surat" value="">
                            <div class="mb-3">
                                <label for="nama" class="form-label">Nama</label>
                                <input type="text" class="form-control" id="nama" name="nama" value="{{ auth()->user()->nama }}" readonly>
                            </div>
                            <div class="mb-3">
                                <label for="nik" class="form-label">NIK</label>
                                <input type="text" class="form-control" id="nik" name="nik" value="{{ auth()->user()->nik }}" readonly>
                            </div>
                            <div class="mb-3">
                                <label for="ttl" class="form-label">Tempat, Tanggal Lahir (Contoh Format: Magetan, 30 Maret 1999)</label>
                                <input type="text" class="form-control" id="ttl" name="ttl" placeholder="Contoh: Magetan, 30 Maret 1999" required>
                            </div>
                            <div class="mb-3">
                                <label for="status_nikah" class="form-label">Status</label>
                                <select class="form-select" id="status_nikah" name="status_nikah" required>
                                    <option value="" selected hidden>-- Pilih Status --</option>
                                    @foreach(\App\Models\Status::all() as $status_nikahs)
                                        <option value="{{ $status_nikahs->nama_status_nikah }}">{{ $status_nikahs->nama_status_nikah }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="mb-3">
                                <label for="agama" class="form-label">Agama</label>
                                <select class="form-select" id="agama" name="agama" required>
                                    <option value="" selected hidden>-- Pilih Agama --</option>
                                    @foreach(\App\Models\Agama::all() as $agamas)
                                        <option value="{{ $agamas->nama_agama }}">{{ $agamas->nama_agama }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="mb-3">
                                <label for="pekerjaan" class="form-label">Pekerjaan</label>
                                <select class="form-select" id="pekerjaan" name="pekerjaan" required onchange="togglePekerjaanLainnya(this)">
                                    <option value="" selected hidden>-- Pilih Pekerjaan --</option>
                                    @foreach(\App\Models\Pekerjaan::all() as $pekerjaan)
                                        <option value="{{ $pekerjaan->nama_pekerjaan }}">{{ $pekerjaan->nama_pekerjaan }}</option>
                                    @endforeach
                                    <option value="Lainnya">Lainnya</option>
                                </select>
                            </div>
                            <div class="mb-3" id="pekerjaan_lainnya_div" style="display: none;">
                                <label for="pekerjaan_lainnya" class="form-label">Pekerjaan Lainnya</label>
                                <input type="text" class="form-control" id="pekerjaan_lainnya" name="pekerjaan_lainnya" placeholder="Isikan pekerjaan lainnya yang belum ada di pilihan">
                            </div>
                            <div class="mb-3">
                                <label for="alamat" class="form-label">Alamat</label>
                                <input type="text" class="form-control" id="alamat" name="alamat" placeholder="Isikan alamat lengkap" required>
                            </div>
                            <div class="mb-3">
                                <label for="usaha" class="form-label">Jenis Usaha</label>
                                <input type="text" class="form-control" id="usaha" name="usaha" placeholder="Isikan jenis dan nama usaha" required>
                            </div>
                            <div class="mb-3">
                                <label for="keperluan" class="form-label">Keperluan</label>
                                <input type="text" class="form-control" id="keperluan" name="keperluan" placeholder="Isikan keperluan pengajuan surat" required>
                            </div>
                            <div class="mb-3">
                                <label for="bukti" class="form-label">Dokumen</label>
                                <input type="file" class="form-control" id="bukti" name="bukti" value="{{ old('bukti') }}" multiple required>
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
                                <label for="nama" class="form-label">Nama</label>
                                <input type="text" class="form-control" id="nama" name="nama" value="{{ auth()->user()->nama }}" readonly>
                            </div>
                            <div class="mb-3">
                                <label for="nik" class="form-label">NIK</label>
                                <input type="text" class="form-control" id="nik" name="nik" value="{{ auth()->user()->nik }}" readonly>
                            </div>
                            <div class="mb-3">
                                <label for="ttl" class="form-label">Tempat, Tanggal Lahir (Contoh Format: Magetan, 30 Maret 1999)</label>
                                <input type="text" class="form-control" id="ttl" name="ttl" placeholder="Contoh: Magetan, 30 Maret 1999" required>
                            </div>
                            <div class="mb-3">
                                <label for="status_nikah" class="form-label">Status</label>
                                <select class="form-select" id="status_nikah" name="status_nikah">
                                    <option value="" selected hidden>-- Pilih Status --</option>
                                    @foreach(\App\Models\Status::where('nama_status_nikah', '=', 'Belum Kawin')->get() as $status_nikahs)
                                        <option value="{{ $status_nikahs->nama_status_nikah }}">{{ $status_nikahs->nama_status_nikah }}</option>
                                    @endforeach
                                </select>
                            </div>                        
                            <div class="mb-3">
                                <label for="agama" class="form-label">Agama</label>
                                <select class="form-select" id="agama" name="agama" required>
                                    <option value="" selected hidden>-- Pilih Agama --</option>
                                    @foreach(\App\Models\Agama::all() as $agamas)
                                        <option value="{{ $agamas->nama_agama }}">{{ $agamas->nama_agama }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="mb-3">
                                <label for="pekerjaan_2" class="form-label">Pekerjaan</label>
                                <select class="form-select" id="pekerjaan_2" name="pekerjaan_2" required>
                                    <option value="" selected hidden>-- Pilih Pekerjaan --</option>
                                    @foreach(\App\Models\Pekerjaan::all() as $pekerjaans)
                                        <option value="{{ $pekerjaans->nama_pekerjaan }}">{{ $pekerjaans->nama_pekerjaan }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="mb-3" id="pekerjaan_lainnya_div_2" style="display: none;">
                                <label for="pekerjaan_lainnya_2" class="form-label">Pekerjaan Lainnya</label>
                                <input type="text" class="form-control" id="pekerjaan_lainnya_2" name="pekerjaan_lainnya_2" placeholder="Isikan pekerjaan lainnya yang belum ada di pilihan" required>
                            </div>
                            <div class="mb-3">
                                <label for="alamat" class="form-label">Alamat</label>
                                <input type="text" class="form-control" id="alamat" name="alamat" placeholder="Isikan alamat lengkap" required>
                            </div>
                            <div class="mb-3">
                                <label for="keperluan" class="form-label">Keperluan</label>
                                <input type="text" class="form-control" id="keperluan" name="keperluan" placeholder="Isikan keperluan pengajuan surat" required>
                            </div>
                            <div class="mb-3">
                                <label for="bukti" class="form-label">Dokumen</label>
                                <input type="file" class="form-control" id="bukti" name="bukti" value="{{ old('bukti') }}" multiple required>
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
                                <label for="nama" class="form-label">Nama</label>
                                <input type="text" class="form-control" id="nama" name="nama" value="{{ auth()->user()->nama }}" readonly>
                            </div>
                            <div class="mb-3">
                                <label for="nik" class="form-label">NIK</label>
                                <input type="text" class="form-control" id="nik" name="nik" value="{{ auth()->user()->nik }}" readonly>
                            </div>
                            <div class="mb-3">
                                <label for="jenis_kelamin" class="form-label">Jenis Kelamin</label>
                                <select class="form-select" id="jenis_kelamin" name="jenis_kelamin" required>
                                    <option value="" selected hidden>-- Pilih Jenis Kelamin --</option>
                                    @foreach(\App\Models\JenisKelamin::all() as $jenis_kelamins)
                                        <option value="{{ $jenis_kelamins->nama_jenis_kelamin }}">{{ $jenis_kelamins->nama_jenis_kelamin }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="mb-3">
                                <label for="ttl" class="form-label">Tempat, Tanggal Lahir (Contoh Format: Magetan, 30 Maret 1999)</label>
                                <input type="text" class="form-control" id="ttl" name="ttl" placeholder="Contoh: Magetan, 30 Maret 1999" required>
                            </div>
                            <div class="mb-3">
                                <label for="agama" class="form-label">Agama</label>
                                <select class="form-select" id="agama" name="agama" required>
                                    <option value="" selected hidden>-- Pilih Agama --</option>
                                    @foreach(\App\Models\Agama::all() as $agamas)
                                        <option value="{{ $agamas->nama_agama }}">{{ $agamas->nama_agama }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="mb-3">
                                <label for="status_nikah" class="form-label">Status</label>
                                <select class="form-select" id="status_nikah" name="status_nikah" required>
                                    <option value="" selected hidden>-- Pilih Status --</option>
                                    @foreach(\App\Models\Status::all() as $status_nikahs)
                                        <option value="{{ $status_nikahs->nama_status_nikah }}">{{ $status_nikahs->nama_status_nikah }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="mb-3">
                                <label for="pekerjaan_3" class="form-label">Pekerjaan</label>
                                <select class="form-select" id="pekerjaan_3" name="pekerjaan_3" required>
                                    <option value="" selected hidden>-- Pilih Pekerjaan --</option>
                                    @foreach(\App\Models\Pekerjaan::all() as $pekerjaans)
                                        <option value="{{ $pekerjaans->nama_pekerjaan }}">{{ $pekerjaans->nama_pekerjaan }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="mb-3" id="pekerjaan_lainnya_div_3" style="display: none;">
                                <label for="pekerjaan_lainnya_3" class="form-label">Pekerjaan Lainnya</label>
                                <input type="text" class="form-control" id="pekerjaan_lainnya_3" name="pekerjaan_lainnya_3" placeholder="Isikan pekerjaan lainnya yang belum ada di pilihan" required>
                            </div>
                            <div class="mb-3">
                                <label for="alamat" class="form-label">Alamat</label>
                                <input type="text" class="form-control" id="alamat" name="alamat" placeholder="Isikan alamat lengkap" required>
                            </div>
                            <div class="mb-3">
                                <label for="alamat_dom" class="form-label">Alamat Domisili</label>
                                <input type="text" class="form-control" id="alamat_dom" name="alamat_dom" required>
                            </div>
                            <div class="mb-3">
                                <label for="keperluan" class="form-label">Keperluan</label>
                                <input type="text" class="form-control" id="keperluan" name="keperluan" placeholder="Isikan keperluan pengajuan surat" required>
                            </div>
                            <div class="mb-3">
                                <label for="bukti" class="form-label">Dokumen</label>
                                <input type="file" class="form-control" id="bukti" name="bukti" value="{{ old('bukti') }}" multiple required>
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Tutup</button>
                                <button type="submit" class="btn btn-primary">Simpan</button>
                            </div>
                        </div>
                    </form>

                    {{-- TIDAK MAMPU --}}
                    {{-- <div id="form_surat_SURAT KETERANGAN TIDAK MAMPU" class="form_surat" style="display: none;">
                        <div class="mb-3">
                            <label for="nama" class="form-label">Nama</label>
                            <input type="text" class="form-control" id="nama" name="nama_4">
                        </div>
                        <div class="mb-3">
                            <label for="nik" class="form-label">NIK</label>
                            <input type="text" class="form-control" id="nik" name="nik_4">
                        </div>
                        <div class="mb-3">
                            <label for="ttl" class="form-label">Tempat, Tanggal Lahir</label>
                            <input type="text" class="form-control" id="ttl" name="ttl_4">
                        </div>
                        <div class="mb-3">
                            <label for="agama" class="form-label">Agama</label>
                            <select class="form-select" id="agama" name="agama_4">
                                <option value="" selected hidden>-- Pilih Agama --</option>
                                @foreach(\App\Models\Agama::all() as $agamas)
                                    <option value="{{ $agamas->nama_agama }}">{{ $agamas->nama_agama }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="mb-3">
                            <label for="pekerjaan" class="form-label">Pekerjaan</label>
                            <select class="form-select" id="pekerjaan" name="pekerjaan_4">
                                <option value="" selected hidden>-- Pilih Pekerjaan --</option>
                                @foreach(\App\Models\Pekerjaan::all() as $pekerjaans)
                                    <option value="{{ $pekerjaans->nama_pekerjaan }}">{{ $pekerjaans->nama_pekerjaan }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="mb-3">
                            <label for="alamat" class="form-label">Alamat</label>
                            <input type="text" class="form-control" id="alamat" name="alamat_4">
                        </div>
                        <div class="mb-3">
                            <label for="keperluan" class="form-label">Keperluan</label>
                            <input type="text" class="form-control" id="keperluan" name="keperluan_4">
                        </div>
                        <div class="mb-3">
                            <label for="bukti" class="form-label">Dokumen</label>
                            <input type="file" class="form-control" id="bukti" name="bukti_4" value="{{ old('bukti') }}" multiple>
                        </div>
                    </div> --}}
                </div>
            </div>
        </div>
    </div>

    {{-- ALASAN DITOLAK --}}
    <div class="modal fade" id="pesan_ditolak" tabindex="-1" aria-labelledby="pesanDitolakLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered"> <!-- Add modal-dialog-centered class here -->
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
                    <h5 class="modal-title">DETAIL SURAT KETERANGAN USAHA</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <input type="hidden" name="id_sk_usaha" id="id_sk_usaha" required>
                    <div class="row mb-1">
                        <label class="col-md-2 col-form-label">Jenis Surat</label>
                        <div class="col-md-9 d-flex align-items-center">
                            <span>:&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<label class="form-label" id="detail_jenis_surat"></label></span>
                        </div>
                    </div>
                    <div class="row mb-1">
                        <label class="col-md-2 col-form-label">Nama</label>
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
                        <label class="col-md-2 col-form-label">Tempat, Tanggal Lahir</label>
                        <div class="col-md-9 d-flex align-items-center">
                            <span>:&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<label class="form-label" id="detail_ttl"></label></span>
                        </div>
                    </div>
                    <div class="row mb-1">
                        <label class="col-md-2 col-form-label">Status Nikah</label>
                        <div class="col-md-9 d-flex align-items-center">
                            <span>:&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<label class="form-label" id="detail_status_nikah"></label></span>
                        </div>
                    </div>
                    <div class="row mb-1">
                        <label class="col-md-2 col-form-label">Agama</label>
                        <div class="col-md-9 d-flex align-items-center">
                            <span>:&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<label class="form-label" id="detail_agama"></label></span>
                        </div>
                    </div>
                    <div class="row mb-1">
                        <label class="col-md-2 col-form-label">Pekerjaan</label>
                        <div class="col-md-9 d-flex align-items-center">
                            <span>:&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<label class="form-label" id="detail_pekerjaan"></label></span>
                        </div>
                    </div>
                    <div class="row mb-1">
                        <label class="col-md-2 col-form-label">Alamat</label>
                        <div class="col-md-9 d-flex align-items-center">
                            <span>:&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<label class="form-label" id="detail_alamat"></label></span>
                        </div>
                    </div>
                    <div class="row mb-1">
                        <label class="col-md-2 col-form-label">Usaha</label>
                        <div class="col-md-9 d-flex align-items-center">
                            <span>:&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<label class="form-label" id="detail_usaha"></label></span>
                        </div>
                    </div>
                    <div class="row mb-1">
                        <label class="col-md-2 col-form-label">Keperluan</label>
                        <div class="col-md-9 d-flex align-items-center">
                            <span>:&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<label class="form-label" id="detail_keperluan"></label></span>
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
                    <h5 class="modal-title">DETAIL SURAT KETERANGAN BELUM MENIKAH</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <input type="hidden" name="id_sk_belum_menikah" id="id_sk_belum_menikah" required>
                    <div class="row mb-1">
                        <label class="col-md-2 col-form-label">Jenis Surat</label>
                        <div class="col-md-9 d-flex align-items-center">
                            <span>:&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<label class="form-label" id="detail_jenis_surat_2"></label></span>
                        </div>
                    </div>
                    <div class="row mb-1">
                        <label class="col-md-2 col-form-label">Nama</label>
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
                        <label class="col-md-2 col-form-label">Tempat, Tanggal Lahir</label>
                        <div class="col-md-9 d-flex align-items-center">
                            <span>:&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<label class="form-label" id="detail_ttl_2"></label></span>
                        </div>
                    </div>
                    <div class="row mb-1">
                        <label class="col-md-2 col-form-label">Status Nikah</label>
                        <div class="col-md-9 d-flex align-items-center">
                            <span>:&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<label class="form-label" id="detail_status_nikah_2"></label></span>
                        </div>
                    </div>
                    <div class="row mb-1">
                        <label class="col-md-2 col-form-label">Agama</label>
                        <div class="col-md-9 d-flex align-items-center">
                            <span>:&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<label class="form-label" id="detail_agama_2"></label></span>
                        </div>
                    </div>
                    <div class="row mb-1">
                        <label class="col-md-2 col-form-label">Pekerjaan</label>
                        <div class="col-md-9 d-flex align-items-center">
                            <span>:&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<label class="form-label" id="detail_pekerjaan_2"></label></span>
                        </div>
                    </div>
                    <div class="row mb-1">
                        <label class="col-md-2 col-form-label">Alamat</label>
                        <div class="col-md-9 d-flex align-items-center">
                            <span>:&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<label class="form-label" id="detail_alamat_2"></label></span>
                        </div>
                    </div>
                    <div class="row mb-1">
                        <label class="col-md-2 col-form-label">Keperluan</label>
                        <div class="col-md-9 d-flex align-items-center">
                            <span>:&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<label class="form-label" id="detail_keperluan_2"></label></span>
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
                    <h5 class="modal-title">DETAIL SURAT KETERANGAN DOMISILI</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <input type="hidden" name="id_sk_domisili" id="id_sk_domisili" required>
                    <div class="row mb-1">
                        <label class="col-md-2 col-form-label">Jenis Surat</label>
                        <div class="col-md-9 d-flex align-items-center">
                            <span>:&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<label class="form-label" id="detail_jenis_surat_3"></label></span>
                        </div>
                    </div>
                    <div class="row mb-1">
                        <label class="col-md-2 col-form-label">Nama</label>
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
                        <label class="col-md-2 col-form-label">Jenis Kelamin</label>
                        <div class="col-md-9 d-flex align-items-center">
                            <span>:&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<label class="form-label" id="detail_jenis_kelamin_3"></label></span>
                        </div>
                    </div>
                    <div class="row mb-1">
                        <label class="col-md-2 col-form-label">Tempat, Tanggal Lahir</label>
                        <div class="col-md-9 d-flex align-items-center">
                            <span>:&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<label class="form-label" id="detail_ttl_3"></label></span>
                        </div>
                    </div>
                    <div class="row mb-1">
                        <label class="col-md-2 col-form-label">Agama</label>
                        <div class="col-md-9 d-flex align-items-center">
                            <span>:&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<label class="form-label" id="detail_agama_3"></label></span>
                        </div>
                    </div>
                    <div class="row mb-1">
                        <label class="col-md-2 col-form-label">Status Nikah</label>
                        <div class="col-md-9 d-flex align-items-center">
                            <span>:&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<label class="form-label" id="detail_status_nikah_3"></label></span>
                        </div>
                    </div>
                    <div class="row mb-1">
                        <label class="col-md-2 col-form-label">Pekerjaan</label>
                        <div class="col-md-9 d-flex align-items-center">
                            <span>:&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<label class="form-label" id="detail_pekerjaan_3"></label></span>
                        </div>
                    </div>
                    <div class="row mb-1">
                        <label class="col-md-2 col-form-label">Alamat</label>
                        <div class="col-md-9 d-flex align-items-center">
                            <span>:&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<label class="form-label" id="detail_alamat_3"></label></span>
                        </div>
                    </div>
                    <div class="row mb-1">
                        <label class="col-md-2 col-form-label">Alamat Domisili</label>
                        <div class="col-md-9 d-flex align-items-center">
                            <span>:&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<label class="form-label" id="detail_alamat_dom_3"></label></span>
                        </div>
                    </div>
                    <div class="row mb-1">
                        <label class="col-md-2 col-form-label">Keperluan</label>
                        <div class="col-md-9 d-flex align-items-center">
                            <span>:&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<label class="form-label" id="detail_keperluan_3"></label></span>
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
            
            document.getElementById("jenis_surat").value = jenisSurat;
            document.getElementById("jenis_surat_2").value = jenisSurat;
            document.getElementById("jenis_surat_3").value = jenisSurat;

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
                        $("#detail_alamat").html(surat.alamat);
                        $("#detail_usaha").html(surat.usaha);
                        $("#detail_keperluan").html(surat.keperluan);

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

                        if (surat.pekerjaan === 'Lainnya') {
                            $("#detail_pekerjaan_2").html(surat.pekerjaan_lainnya);
                            $("#pekerjaan_lainnya_2_row").show();
                        } else {
                            $("#detail_pekerjaan_2").html(surat.pekerjaan);
                            $("#pekerjaan_lainnya_2_row").hide();
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
    </script>
@endsection
