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
                                        <th class="col-md-2 text-center align-middle">Tanggal Pengajuan</th>                           
                                        <th class="col-md-2 text-center align-middle">Jenis Surat</th>                           
                                        <th class="col-md-2 text-center align-middle">NIK</th>                           
                                        <th class="col-md-2 text-center align-middle">Nama</th>                           
                                        <th class="col-md-2 text-center align-middle">Status</th>                           
                                        <th class="col-md-2 text-center align-middle">alasan ditolak</th>                           
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
                                            <td class="text-center align-middle">{{ $sk_usaha->pesan }}</td>
                                            <td class="text-center">
                                                <div class="d-flex justify-content-center">
                                                    <button type="button" data-bs-toggle="modal" data-bs-target="#detailSKU" data-bs-id="{{ $sk_usaha->id_sk_usaha }}" class="btn btn-info btn-sm">Detail</button>
                                                </div>
                                                <script>
                                                </script>
                                            </td>
                                        </tr>
                                    @endforeach
{{-- 
                                    @foreach(\App\Models\SKTidakMampu::where('pemohon', auth()->user()->nik)->get() as $sktm)
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
                                                    <button type="button" data-bs-toggle="modal" data-bs-target="#detailSKU" data-bs-id="{{ $skd->id_sk_domisili }}" class="btn btn-info btn-sm">Detail</button>
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
                                                    <button type="button" data-bs-toggle="modal" data-bs-target="#detailSKU" data-bs-id="{{ $sk_belum_menikah->id_sk_belum_menikah }}" class="btn btn-info btn-sm">Detail</button>
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
            {{-- <div class="container">
                <div class="d-flex flex-column min-vh-100 px-3 pt-4">
                    <div class="row justify-content-center my-auto">
                        <div class="col-md-8 col-lg-6 col-xl-5">
                            <div class="text-center mb-4">
                                <img src="{{ asset('assets/images/logo-kab-magetan.png') }}" alt="" height="35"> <span class="logo-txt">ESPO  ||  E-Surat Kepolorejo</span>
                            </div>
                            <div class="card">
                                <div class="card-body p-4"> 
                                    <div class="text-center mt-2">
                                        <h5 class="text-primary">Selamat Datang</h5>
                                    </div>
                                </div>
                            </div>
                            <div class="text-center mb-4">
                                <button data-bs-toggle="modal" data-bs-target="#ceksurat" class="btn btn-primary" style="background-color: white; color: black;">CEK SURAT</button>
                                <button data-bs-toggle="modal" data-bs-target="#tambahsuratbaru" class="btn btn-primary" style="background-color: white; color: black;">TAMBAH SURAT</button>
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-lg-12">
                            <div class="text-center text-muted p-4">
                                <p class="text-white-50">© <script>document.write(new Date().getFullYear())</script> E-Surat Kepolorejo</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div> --}}
@endsection

@section('modal')
    {{-- MODAL TAMBAH SURAT --}}
    <div class="modal fade" id="tambahsuratbaru" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Pengajuan Surat Baru</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <form method="POST" action="{{ route('buat_surat') }}" enctype="multipart/form-data"> 
                    @csrf
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

                        {{-- USAHA --}}
                        <div id="form_surat_SURAT KETERANGAN USAHA" class="form_surat" style="display: none;">
                            <div class="mb-3">
                                <label for="nama" class="form-label">Nama</label>
                                <input type="text" class="form-control" id="nama" name="nama">
                            </div>
                            <div class="mb-3">
                                <label for="nik" class="form-label">NIK</label>
                                <input type="text" class="form-control" id="nik" name="nik">
                            </div>
                            <div class="mb-3">
                                <label for="ttl" class="form-label">Tempat, Tanggal Lahir</label>
                                <input type="text" class="form-control" id="ttl" name="ttl">
                            </div>
                            <div class="mb-3">
                                <label for="status_nikah" class="form-label">Status</label>
                                <select class="form-select" id="status_nikah" name="status_nikah">
                                    <option value="" selected hidden>-- Pilih Status --</option>
                                    @foreach(\App\Models\Status::all() as $status_nikahs)
                                        <option value="{{ $status_nikahs->nama_status_nikah }}">{{ $status_nikahs->nama_status_nikah }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="mb-3">
                                <label for="agama" class="form-label">Agama</label>
                                <select class="form-select" id="agama" name="agama">
                                    <option value="" selected hidden>-- Pilih Agama --</option>
                                    @foreach(\App\Models\Agama::all() as $agamas)
                                        <option value="{{ $agamas->nama_agama }}">{{ $agamas->nama_agama }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="mb-3">
                                <label for="pekerjaan" class="form-label">Pekerjaan</label>
                                <select class="form-select" id="pekerjaan" name="pekerjaan">
                                    <option value="" selected hidden>-- Pilih Pekerjaan --</option>
                                    @foreach(\App\Models\Pekerjaan::all() as $pekerjaans)
                                        <option value="{{ $pekerjaans->nama_pekerjaan }}">{{ $pekerjaans->nama_pekerjaan }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="mb-3">
                                <label for="alamat" class="form-label">Alamat</label>
                                <input type="text" class="form-control" id="alamat" name="alamat">
                            </div>
                            <div class="mb-3">
                                <label for="usaha" class="form-label">Jenis Usaha</label>
                                <input type="text" class="form-control" id="usaha" name="usaha">
                            </div>
                            <div class="mb-3">
                                <label for="keperluan" class="form-label">Keperluan</label>
                                <input type="text" class="form-control" id="keperluan" name="keperluan">
                            </div>
                            <div class="mb-3">
                                <label for="bukti" class="form-label">Dokumen</label>
                                <input type="file" class="form-control" id="bukti" name="bukti" value="{{ old('bukti') }}" multiple>
                            </div>
                        </div>

                        {{-- DOMISILI --}}
                        <div id="form_surat_SURAT KETERANGAN DOMISILI" class="form_surat" style="display: none;">
                            <div class="mb-3">
                                <label for="nama" class="form-label">Nama</label>
                                <input type="text" class="form-control" id="nama" name="nama_2">
                            </div>
                            <div class="mb-3">
                                <label for="nik" class="form-label">NIK</label>
                                <input type="text" class="form-control" id="nik" name="nik_2">
                            </div>
                            <div class="mb-3">
                                <label for="jenis_kelamin" class="form-label">Jenis Kelamin</label>
                                <select class="form-select" id="jenis_kelamin" name="jenis_kelamin">
                                    <option value="" selected hidden>-- Pilih Jenis Kelamin --</option>
                                    @foreach(\App\Models\JenisKelamin::all() as $jenis_kelamins)
                                        <option value="{{ $jenis_kelamins->nama_jenis_kelamin }}">{{ $jenis_kelamins->nama_jenis_kelamin }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="mb-3">
                                <label for="ttl" class="form-label">Tempat, Tanggal Lahir</label>
                                <input type="text" class="form-control" id="ttl" name="ttl_2">
                            </div>
                            <div class="mb-3">
                                <label for="agama" class="form-label">Agama</label>
                                <select class="form-select" id="agama" name="agama_2">
                                    <option value="" selected hidden>-- Pilih Agama --</option>
                                    @foreach(\App\Models\Agama::all() as $agamas)
                                        <option value="{{ $agamas->nama_agama }}">{{ $agamas->nama_agama }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="mb-3">
                                <label for="status_nikah" class="form-label">Status</label>
                                <select class="form-select" id="status_nikah" name="status_nikah_2">
                                    <option value="" selected hidden>-- Pilih Status --</option>
                                    @foreach(\App\Models\Status::all() as $status_nikahs)
                                        <option value="{{ $status_nikahs->nama_status_nikah }}">{{ $status_nikahs->nama_status_nikah }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="mb-3">
                                <label for="pekerjaan" class="form-label">Pekerjaan</label>
                                <select class="form-select" id="pekerjaan" name="pekerjaan_2">
                                    <option value="" selected hidden>-- Pilih Pekerjaan --</option>
                                    @foreach(\App\Models\Pekerjaan::all() as $pekerjaans)
                                        <option value="{{ $pekerjaans->nama_pekerjaan }}">{{ $pekerjaans->nama_pekerjaan }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="mb-3">
                                <label for="alamat" class="form-label">Alamat</label>
                                <input type="text" class="form-control" id="alamat" name="alamat_2">
                            </div>
                            <div class="mb-3">
                                <label for="alamat_dom" class="form-label">Alamat Domisili</label>
                                <input type="text" class="form-control" id="alamat_dom" name="alamat_dom">
                            </div>
                            <div class="mb-3">
                                <label for="keperluan" class="form-label">Keperluan</label>
                                <input type="text" class="form-control" id="keperluan" name="keperluan_2">
                            </div>
                            <div class="mb-3">
                                <label for="bukti" class="form-label">Dokumen</label>
                                <input type="file" class="form-control" id="bukti" name="bukti_2" value="{{ old('bukti') }}" multiple>
                            </div>
                        </div>

                        {{-- BELUM MENIKAH --}}
                        <div id="form_surat_SURAT KETERANGAN BELUM MENIKAH" class="form_surat" style="display: none;">
                            <div class="mb-3">
                                <label for="nama" class="form-label">Nama</label>
                                <input type="text" class="form-control" id="nama" name="nama_3">
                            </div>
                            <div class="mb-3">
                                <label for="nik" class="form-label">NIK</label>
                                <input type="text" class="form-control" id="nik" name="nik_3">
                            </div>
                            <div class="mb-3">
                                <label for="ttl" class="form-label">Tempat, Tanggal Lahir</label>
                                <input type="text" class="form-control" id="ttl" name="ttl_3">
                            </div>
                            <div class="mb-3">
                                <label for="status_nikah" class="form-label">Status</label>
                                <select class="form-select" id="status_nikah" name="status_nikah_3">
                                    <option value="" selected hidden>-- Pilih Status --</option>
                                    @foreach(\App\Models\Status::all() as $status_nikahs)
                                        <option value="{{ $status_nikahs->nama_status_nikah }}">{{ $status_nikahs->nama_status_nikah }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="mb-3">
                                <label for="agama" class="form-label">Agama</label>
                                <select class="form-select" id="agama" name="agama_3">
                                    <option value="" selected hidden>-- Pilih Agama --</option>
                                    @foreach(\App\Models\Agama::all() as $agamas)
                                        <option value="{{ $agamas->nama_agama }}">{{ $agamas->nama_agama }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="mb-3">
                                <label for="pekerjaan" class="form-label">Pekerjaan</label>
                                <select class="form-select" id="pekerjaan" name="pekerjaan_3">
                                    <option value="" selected hidden>-- Pilih Pekerjaan --</option>
                                    @foreach(\App\Models\Pekerjaan::all() as $pekerjaans)
                                        <option value="{{ $pekerjaans->nama_pekerjaan }}">{{ $pekerjaans->nama_pekerjaan }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="mb-3">
                                <label for="alamat" class="form-label">Alamat</label>
                                <input type="text" class="form-control" id="alamat" name="alamat_3">
                            </div>
                            <div class="mb-3">
                                <label for="keperluan" class="form-label">Keperluan</label>
                                <input type="text" class="form-control" id="keperluan" name="keperluan_3">
                            </div>
                            <div class="mb-3">
                                <label for="bukti" class="form-label">Dokumen</label>
                                <input type="file" class="form-control" id="bukti" name="bukti_3" value="{{ old('bukti') }}" multiple>
                            </div>
                        </div>

                        {{-- TIDAK MAMPU --}}
                        <div id="form_surat_SURAT KETERANGAN TIDAK MAMPU" class="form_surat" style="display: none;">
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
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Tutup</button>
                        <button type="submit" class="btn btn-primary">Simpan</button>                
                    </div>
                </form>
            </div>
        </div>
    </div>

    {{-- MODAL CEK SURAT --}}
    <div class="modal fade" id="ceksurat" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Cek Surat</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <!-- Form pencarian -->
                    <form id="searchForm">
                        <div class="mb-3">
                            <label for="nikWarga" class="form-label">NIK Warga</label>
                            <input type="text" class="form-control" id="nikWarga" placeholder="Masukkan NIK warga">
                        </div>
                        <button type="submit" class="btn btn-primary">Cari</button>
                    </form>

                    <p id="nikNotFound" class="text-danger" style="display: none;">Surat tidak ditemukan</p>

                    <div id="searchResults" class="mt-3" style="display: none;">
                        <div class="mb-3 row">
                            <label class="col-md-3 col-form-label">Jenis Surat</label>
                            <span class="col-md-9 col-form-label" style="padding-top: 0;display: flex;padding-top: calc(.47rem + var(--bs-border-width));">:&nbsp;
                                <label class="col-form-label" id="detail_jenis_surat" style="padding-top: 0;"></label>
                            </span>
                        </div>
                        {{-- <div class="mb-3 row">
                            <label class="col-md-3 col-form-label">NIK</label>
                            <span class="col-md-9 col-form-label" style="padding-top: 0;display: flex;padding-top: calc(.47rem + var(--bs-border-width));">:&nbsp;
                                <label class="col-form-label" id="detail_nik" style="padding-top: 0;"></label>
                            </span>
                        </div> --}}
                        <div class="mb-3 row">
                            <label class="col-md-3 col-form-label">Nama</label>
                            <span class="col-md-9 col-form-label" style="padding-top: 0;display: flex;padding-top: calc(.47rem + var(--bs-border-width));">:&nbsp;
                                <label class="col-form-label" id="detail_nama" style="padding-top: 0;"></label>
                            </span>
                        </div>
                        <div class="mb-3 row">
                            <label class="col-md-3 col-form-label">Status</label>
                            <span class="col-md-9 col-form-label" style="padding-top: 0;display: flex;padding-top: calc(.47rem + var(--bs-border-width));">:&nbsp;
                                <label class="col-form-label" id="detail_status" style="padding-top: 0;"></label>
                            </span>
                        </div>
                        
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('script')
    <script>
        $(document).ready(function() {
            var table = $('.table').DataTable({
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

        function showForm() {
            var selectedOption = document.getElementById("jenis_surat").value;
            console.log("Selected option: ", selectedOption);
            
            var forms = document.querySelectorAll('.form_surat');
            console.log("Forms: ", forms);

            forms.forEach(function(form) {
                var formId = form.id.split("_").pop(); 
                if (formId === selectedOption) {
                    form.style.display = "block";
                } else {
                    form.style.display = "none";
                }
            });
        }

        // CEK SURAT NOT SUCCEDD YET
        $(document).ready(function() {
            $('#searchForm').submit(function(event) {
                event.preventDefault(); // Prevent standard form submission
                var nikWarga = $('#nikWarga').val(); // Get the value of NIK input

                // Send an AJAX request to the server with NIK as a parameter
                $.ajax({
                    url: 'cari_surat', 
                    method: 'GET',
                    data: { nik_warga: nikWarga },
                    success: function(response) {
                        if (response.error) {
                            // Perbarui elemen HTML dengan pesan error
                            $('#nikNotFound').text('NIK tidak ditemukan').show();
                            // Sembunyikan elemen searchResults jika sebelumnya ditampilkan
                            $('#searchResults').hide();
                        } else {
                            $('#detail_jenis_surat').text(response.jenis_surat);
                            $('#detail_nama').text(response.nama_warga);
                            // $('#detail_nik').text(response.nik_warga);
                            $('#detail_status').text(response.status_surat);
                            
                            // Sembunyikan pesan error jika sebelumnya ditampilkan
                            $('#nikNotFound').hide();
                            // Tampilkan elemen searchResults setelah hasil pencarian tersedia
                            $('#searchResults').show();
                        }
                    },
                    error: function(xhr, status, error) {
                        console.error(xhr.responseText);
                    }
                });
            });
        });
    </script>
@endsection
