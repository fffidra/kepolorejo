@extends('layout.app')

@section('title')
    Data Surat
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
                            <h5>DATA SURAT MASUK</h5>
                        </div>
                        <div class="container-fluid table-responsive px-3 py-3">
                            <table class="table table-striped" id="tabelsurat" style="width:100%">
                                <thead>
                                    <tr>
                                        <th class="col-md-1 text-center align-middle">TANGGAL PENGAJUAN</th>                           
                                        <th class="col-md-2 text-center align-middle">JENIS SURAT</th>                           
                                        <th class="col-md-2 text-center align-middle">NIK</th>                           
                                        <th class="col-md-1 text-center align-middle">NAMA</th>                           
                                        <th class="col-md-1 text-center align-middle">STATUS</th>                           
                                        {{-- <th class="col-md-2 text-center align-middle">BUKTI</th>                            --}}
                                        <th class="col-md-3 text-center align-middle">AKSI</th>                           
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach(\App\Models\SKUsaha::where('status_surat', 'Diproses')->get() as $sk_usaha)
                                        <tr>
                                            <td class="text-center align-middle">{{ $sk_usaha->tanggal }}</td>
                                            <td class="text-center align-middle">{{ $sk_usaha->jenis_surat }}</td>
                                            <td class="text-center align-middle">{{ $sk_usaha->nik }}</td>
                                            <td class="text-center align-middle">{{ $sk_usaha->nama }}</td>
                                            <td class="text-center align-middle">{{ $sk_usaha->status_surat }}</td>
                                            {{-- <td class="text-center align-middle">
                                                <a href="{{ url('dokumen_bukti/' . $sk_usaha->bukti) }}">
                                                    <button class="btn btn-success" type="button">Unduh</button>
                                                </a>
                                            </td> --}}
                                            <td class="text-center">
                                                <div class="d-flex justify-content-center flex-wrap">
                                                    <button type="button" data-bs-toggle="modal" data-bs-target="#detailSKU" data-bs-id="{{ $sk_usaha->id_sk_usaha }}" class="btn btn-info btn-sm mx-1">Detail</button>
                                                    <a role="button" class="btn btn-warning btn-sm mx-1" title="Ubah Data" data-bs-toggle="modal" data-bs-target="#ubahSKU" data-bs-id="{{ $sk_usaha->id_sk_usaha }}">Ubah</a>
                                                    <form method="POST" action="{{ route('sku_setuju', $sk_usaha->id_sk_usaha) }}" id="setuju-surat-{{ $sk_usaha->id_sk_usaha }}" class="d-inline">
                                                        @csrf
                                                        @method('PUT')
                                                        <button type="button" id="btnSetuju-{{ $sk_usaha->id_sk_usaha }}" class="btn btn-success btn-sm mx-1">Setuju</button>
                                                    </form>
                                                    <form method="POST" action="{{ route('verifikasi_sk_usaha', $sk_usaha->id_sk_usaha) }}" id="verifikasi-surat-{{ $sk_usaha->id_sk_usaha }}" class="d-inline">
                                                        @csrf
                                                        @method('PUT')
                                                        <button type="button" id="btnTolak-{{ $sk_usaha->id_sk_usaha }}" class="btn btn-danger btn-sm mx-1">Tolak</button>
                                                    </form>
                                                    @if($sk_usaha->status_surat === 'Ditolak')
                                                        <form method="POST" action="{{ route('hapus_sk_usaha', $sk_usaha->id_sk_usaha) }}" id="hapus-surat-{{ $sk_usaha->id_sk_usaha }}" class="d-inline">
                                                            @csrf
                                                            @method('DELETE')
                                                            <button type="button" id="btnHapus-{{ $sk_usaha->id_sk_usaha }}" class="btn btn-danger btn-sm mx-1"><i class="bx bx-trash-alt"></i></button>
                                                        </form>
                                                    @endif
                                                </div>
                                                <script>
                                                    // BUTTON SETUJU
                                                    $('#btnSetuju-{{ $sk_usaha->id_sk_usaha  }}').click(function(event){
                                                        event.preventDefault();
                                                        Swal.fire({
                                                            icon: "info",
                                                            title: "Setujui Surat",
                                                            text: "Apakah Anda yakin ingin menyetujui surat ini?",
                                                            showCancelButton: true,
                                                            confirmButtonText: "Ya, Lanjutkan",
                                                            cancelButtonText: "Tidak, Batalkan",
                                                        }).then(function (result) {
                                                            if (result.isConfirmed) {
                                                                $('#setuju-surat-{{ $sk_usaha->id_sk_usaha}}').submit();
                                                            }
                                                        });
                                                    });

                                                    // BUTTON TOLAK
                                                    $('#btnTolak-{{ $sk_usaha->id_sk_usaha }}').click(function(event){
                                                        event.preventDefault();
                                                        Swal.fire({
                                                            icon: "info",
                                                            title: "Tolak Surat",
                                                            text: "Apakah Anda yakin ingin menolak surat ini?",
                                                            input: 'textarea',
                                                            inputPlaceholder: 'Masukkan pesan penolakan jika surat akan ditolak',
                                                            showCancelButton: true,
                                                            confirmButtonText: "Tolak",
                                                            cancelButtonText: "Kembali",
                                                        }).then((result) => {
                                                            if (result.isConfirmed) {
                                                                var pesan = result.value; // Ambil nilai dari input teks
                                                                $('#verifikasi-surat-{{ $sk_usaha->id_sk_usaha }}')
                                                                    .append('<input type="hidden" name="aksi" value="tolak">')
                                                                    .append('<input type="hidden" name="alasan_tolak" value="' + pesan + '">') // Kirim nilai pesan ke server
                                                                    .submit();
                                                            }
                                                        });
                                                    });

                                                    // BUTTON DELETE
                                                    $('#btnHapus-{{ $sk_usaha->id_sk_usaha }}').click(function(event){
                                                        event.preventDefault();
                                                        Swal.fire({
                                                            icon: "info",
                                                            title: "Hapus Surat",
                                                            text: "Apakah Anda yakin ingin menghapus surat ini?",
                                                            showCancelButton: true,
                                                            confirmButtonText: "Ya, Lanjutkan",
                                                            cancelButtonText: "Tidak, Batalkan",
                                                        }).then(function (result) {
                                                            if (result.isConfirmed) {
                                                                $('#hapus-surat-{{ $sk_usaha->id_sk_usaha }}').submit();
                                                            }
                                                        });
                                                    });
                                                </script>
                                            </td>
                                        </tr>
                                    @endforeach

                                    {{-- @foreach(\App\Models\SKBelumMenikah::where('status_surat', 'Diproses')->orWhere('status_surat', 'Ditolak')->get() as $sk_belum_menikah)
                                        <tr>
                                            <td class="text-center align-middle">{{ $sk_belum_menikah->tanggal }}</td>
                                            <td class="text-center align-middle">{{ $sk_belum_menikah->jenis_surat }}</td>
                                            <td class="text-center align-middle">{{ $sk_belum_menikah->nik }}</td>
                                            <td class="text-center align-middle">{{ $sk_belum_menikah->nama }}</td>
                                            <td class="text-center align-middle">{{ $sk_belum_menikah->status_surat }}</td>
                                            <td class="text-center">
                                                <div class="d-flex justify-content-center">
                                                    <button type="button" data-bs-toggle="modal" data-bs-target="#detailSKBM" data-bs-id="{{ $sk_belum_menikah->id_sk_belum_menikah }}" class="btn btn-info btn-sm">Detail</button>
                                                    @if($sk_belum_menikah->status_surat === 'Diproses')
                                                        <a role="button" class="btn btn-warning me-2" title="Ubah Data" style="padding: 0.25rem 0.5rem; font-size: 18px;" data-bs-toggle="modal" data-bs-target="#ubahSKBM" data-bs-id="{{ $sk_belum_menikah->id_sk_belum_menikah }}"><i class="bx bx-pencil"></i></a>
                                                        <form method="POST" action="{{ route('verifikasi_sk_belum_menikah', $sk_belum_menikah->id_sk_belum_menikah) }}" id="verifikasi-surat-{{ $sk_belum_menikah->id_sk_belum_menikah }}">
                                                            @csrf
                                                            @method('PUT')
                                                            <button type="button" id="btnVerifikasi-{{ $sk_belum_menikah->id_sk_belum_menikah }}" class="btn btn-primary btn-sm">Verifikasi</button>
                                                        </form>
                                                    @endif
                                                    @if($sk_belum_menikah->status_surat === 'Ditolak')
                                                        <form method="POST" action="{{ route('hapus_sk_belum_menikah', $sk_belum_menikah->id_sk_belum_menikah) }}" id="hapus-surat-{{ $sk_belum_menikah->id_sk_belum_menikah }}">
                                                            @csrf
                                                            @method('DELETE')
                                                            <a role="button" id="btnHapus-{{ $sk_belum_menikah->id_sk_belum_menikah }}" class="btn btn-danger" title="Hapus Data"style="padding: 0.25rem 0.5rem; font-size: 18px;"><i class="bx bx-trash-alt"></i></a>
                                                        </form>
                                                    @endif
                                                </div>
                                                <script>
                                                    // BUTTON VERIFIKASI
                                                    $('#btnVerifikasi-{{ $sk_belum_menikah->id_sk_belum_menikah }}').click(function(event){
                                                        event.preventDefault();
                                                        Swal.fire({
                                                            icon: "info",
                                                            title: "Verifikasi Surat",
                                                            text: "Apakah Anda yakin ingin verifikasi surat ini?",
                                                            showDenyButton: true,
                                                            showCancelButton: true,
                                                            confirmButtonText: "Setuju",
                                                            denyButtonText: "Tolak",
                                                            cancelButtonText: "Batal",
                                                        }).then((result) => {
                                                            if (result.isConfirmed) {
                                                                $('#verifikasi-surat-{{ $sk_belum_menikah->id_sk_belum_menikah }}')
                                                                    .append('<input type="hidden" name="aksi" value="setuju" required>')
                                                                    .submit();
                                                            } else if (result.isDenied) {
                                                                $('#verifikasi-surat-{{ $sk_belum_menikah->id_sk_belum_menikah }}')
                                                                    .append('<input type="hidden" name="aksi" value="tolak" required>')
                                                                    .submit();
                                                            }
                                                        });
                                                    });

                                                    // BUTTON DELETE
                                                    $('#btnHapus-{{ $sk_belum_menikah->id_sk_belum_menikah }}').click(function(event){
                                                        event.preventDefault();
                                                        Swal.fire({
                                                            icon: "info",
                                                            title: "Hapus Surat",
                                                            text: "Apakah Anda yakin ingin menghapus surat ini?",
                                                            showCancelButton: true,
                                                            confirmButtonText: "Ya, Lanjutkan",
                                                            cancelButtonText: "Tidak, Batalkan",
                                                        }).then(function (result) {
                                                            if (result.isConfirmed) {
                                                                $('#hapus-surat-{{ $sk_belum_menikah->id_sk_belum_menikah }}').submit();
                                                            }
                                                        });
                                                    });
                                                </script>
                                            </td>
                                        </tr>
                                    @endforeach --}}

                                    {{-- @foreach(\App\Models\SKDomisili::where('status_surat', 'Diproses')->orWhere('status_surat', 'Ditolak')->get() as $skd)
                                        <tr>
                                            <td class="text-center align-middle">{{ $skd->tanggal }}</td>
                                            <td class="text-center align-middle">{{ $skd->jenis_surat }}</td>
                                            <td class="text-center align-middle">{{ $skd->nik }}</td>
                                            <td class="text-center align-middle">{{ $skd->nama }}</td>
                                            <td class="text-center align-middle">{{ $skd->status_surat }}</td>
                                            <td class="text-center">
                                                <div class="d-flex justify-content-center">
                                                    <button type="button" data-bs-toggle="modal" data-bs-target="#detailSKD" data-bs-id="{{ $skd->id_sk_domisili }}" class="btn btn-info btn-sm">Detail</button>
                                                    @if($skd->status_surat === 'Diproses')
                                                        <a role="button" class="btn btn-warning me-2" title="Ubah Data" style="padding: 0.25rem 0.5rem; font-size: 18px;" data-bs-toggle="modal" data-bs-target="#ubahSKD" data-bs-id="{{ $skd->id_sk_domisili }}"><i class="bx bx-pencil"></i></a>
                                                        <form method="POST" action="{{ route('verifikasi_sk_domisili', $skd->id_sk_domisili) }}" id="verifikasi-surat-{{ $skd->id_sk_domisili }}">
                                                            @csrf
                                                            @method('PUT')
                                                            <button type="button" id="btnVerifikasi-{{ $skd->id_sk_domisili }}" class="btn btn-primary btn-sm">Verifikasi</button>
                                                        </form>
                                                    @endif
                                                    @if($skd->status_surat === 'Ditolak')
                                                        <form method="POST" action="{{ route('hapus_sk_domisili', $skd->id_sk_domisili) }}" id="hapus-surat-{{ $skd->id_sk_domisili }}">
                                                            @csrf
                                                            @method('DELETE')
                                                            <a role="button" id="btnHapus-{{ $skd->id_sk_domisili }}" class="btn btn-danger" title="Hapus Data"style="padding: 0.25rem 0.5rem; font-size: 18px;"><i class="bx bx-trash-alt"></i></a>
                                                        </form>
                                                    @endif
                                                </div>
                                                <script>
                                                    // BUTTON VERIFIKASI
                                                    $('#btnVerifikasi-{{ $skd->id_sk_domisili }}').click(function(event){
                                                        event.preventDefault();
                                                        Swal.fire({
                                                            icon: "info",
                                                            title: "Verifikasi Surat",
                                                            text: "Apakah Anda yakin ingin verifikasi surat ini?",
                                                            showDenyButton: true,
                                                            showCancelButton: true,
                                                            confirmButtonText: "Setuju",
                                                            denyButtonText: "Tolak",
                                                            cancelButtonText: "Batal",
                                                        }).then((result) => {
                                                            if (result.isConfirmed) {
                                                                $('#verifikasi-surat-{{ $skd->id_sk_domisili }}')
                                                                    .append('<input type="hidden" name="aksi" value="setuju" required>')
                                                                    .submit();
                                                            } else if (result.isDenied) {
                                                                $('#verifikasi-surat-{{ $skd->id_sk_domisili }}')
                                                                    .append('<input type="hidden" name="aksi" value="tolak" required>')
                                                                    .submit();
                                                            }
                                                        });
                                                    });

                                                    // BUTTON DELETE
                                                    $('#btnHapus-{{ $skd->id_sk_domisili }}').click(function(event){
                                                        event.preventDefault();
                                                        Swal.fire({
                                                            icon: "info",
                                                            title: "Hapus Surat",
                                                            text: "Apakah Anda yakin ingin menghapus surat ini?",
                                                            showCancelButton: true,
                                                            confirmButtonText: "Ya, Lanjutkan",
                                                            cancelButtonText: "Tidak, Batalkan",
                                                        }).then(function (result) {
                                                            if (result.isConfirmed) {
                                                                $('#hapus-surat-{{ $skd->id_sk_domisili }}').submit();
                                                            }
                                                        });
                                                    });
                                                </script>
                                            </td>
                                        </tr>
                                    @endforeach

                                    @foreach(\App\Models\SKTidakMampu::where('status_surat', 'Diproses')->orWhere('status_surat', 'Ditolak')->get() as $sktm)
                                        <tr>
                                            <td class="text-center align-middle">{{ $sktm->tanggal }}</td>
                                            <td class="text-center align-middle">{{ $sktm->jenis_surat }}</td>
                                            <td class="text-center align-middle">{{ $sktm->nik }}</td>
                                            <td class="text-center align-middle">{{ $sktm->nama }}</td>
                                            <td class="text-center align-middle">{{ $sktm->status_surat }}</td>
                                            <td class="text-center">
                                                <div class="d-flex justify-content-center">
                                                    <button type="button" data-bs-toggle="modal" data-bs-target="#detailSKTM" data-bs-id="{{ $sktm->id_sk_tidak_mampu }}" class="btn btn-info btn-sm">Detail</button>
                                                    @if($sktm->status_surat === 'Diproses')
                                                        <a role="button" class="btn btn-warning me-2" title="Ubah Data" style="padding: 0.25rem 0.5rem; font-size: 18px;" data-bs-toggle="modal" data-bs-target="#ubahSKTM" data-bs-id="{{ $sktm->id_sk_tidak_mampu }}"><i class="bx bx-pencil"></i></a>
                                                        <form method="POST" action="{{ route('verifikasi_sk_tidak_mampu', $sktm->id_sk_tidak_mampu) }}" id="verifikasi-surat-{{ $sktm->id_sk_tidak_mampu }}">
                                                            @csrf
                                                            @method('PUT')
                                                            <button type="button" id="btnVerifikasi-{{ $sktm->id_sk_tidak_mampu }}" class="btn btn-primary btn-sm">Verifikasi</button>
                                                        </form>                                                   
                                                    @endif
                                                    @if($sktm->status_surat === 'Ditolak')
                                                        <form method="POST" action="{{ route('hapus_sk_tidak_mampu', $sktm->id_sk_tidak_mampu) }}" id="hapus-surat-{{ $sktm->id_sk_tidak_mampu }}">
                                                            @csrf
                                                            @method('DELETE')
                                                            <a role="button" id="btnHapus-{{ $sktm->id_sk_tidak_mampu }}" class="btn btn-danger" title="Hapus Data"style="padding: 0.25rem 0.5rem; font-size: 18px;"><i class="bx bx-trash-alt"></i></a>
                                                        </form>
                                                    @endif
                                                </div>
                                                <script>
                                                    // BUTTON VERIFIKASI
                                                    $('#btnVerifikasi-{{ $sktm->id_sk_tidak_mampu }}').click(function(event){
                                                        event.preventDefault();
                                                        Swal.fire({
                                                            icon: "info",
                                                            title: "Verifikasi Surat",
                                                            text: "Apakah Anda yakin ingin verifikasi surat ini?",
                                                            showDenyButton: true,
                                                            showCancelButton: true,
                                                            confirmButtonText: "Setuju",
                                                            denyButtonText: "Tolak",
                                                            cancelButtonText: "Batal",
                                                        }).then((result) => {
                                                            if (result.isConfirmed) {
                                                                $('#verifikasi-surat-{{ $sktm->id_sk_tidak_mampu }}')
                                                                    .append('<input type="hidden" name="aksi" value="setuju" required>')
                                                                    .submit();
                                                            } else if (result.isDenied) {
                                                                $('#verifikasi-surat-{{ $sktm->id_sk_tidak_mampu }}')
                                                                    .append('<input type="hidden" name="aksi" value="tolak" required>')
                                                                    .submit();
                                                            }
                                                        });
                                                    });
                                                
                                                    // BUTTON DELETE
                                                    $('#btnHapus-{{ $sktm->id_sk_tidak_mampu }}').click(function(event){
                                                        event.preventDefault();
                                                        Swal.fire({
                                                            icon: "info",
                                                            title: "Hapus Surat",
                                                            text: "Apakah Anda yakin ingin menghapus surat ini?",
                                                            showCancelButton: true,
                                                            confirmButtonText: "Ya, Lanjutkan",
                                                            cancelButtonText: "Tidak, Batalkan",
                                                        }).then(function (result) {
                                                            if (result.isConfirmed) {
                                                                $('#hapus-surat-{{ $sktm->id_sk_tidak_mampu }}').submit();
                                                            }
                                                        });
                                                    });
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
    {{-- UBAH SKU --}}
    <div class="modal fade" id="ubahSKU" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">UBAH DATA SURAT KETERANGAN USAHA</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <form method="POST" action="{{ route('ubah_sku') }}" id="ubah_sku">
                    @csrf
                    @method('PUT')
                    <input type="hidden" name="id_sk_usaha" id="id_sk_usaha" required>
                    <div class="modal-body">
                        <div class="mb-3 row">
                            <label for="jenis_surat" class="col-md-2 col-form-label">Jenis Surat</label>
                            <div class="col-md-9">
                                <input type="text" class="form-control" id="jenis_surat" name="jenis_surat" readonly>
                            </div>
                        </div>
                        <div class="mb-3 row">
                            <label for="ubah_nama" class="col-md-2 col-form-label">Nama</label>
                            <div class="col-md-9">
                                <textarea class="form-control" id="ubah_nama" name="ubah_nama" rows="1"></textarea>
                            </div>
                        </div>
                        <div class="mb-3 row">
                            <label for="ubah_nik_warga" class="col-md-2 col-form-label">NIK</label>
                            <div class="col-md-9">
                                <textarea class="form-control" id="ubah_nik" name="ubah_nik" rows="1"></textarea>
                            </div>
                        </div>
                        <div class="mb-3 row">
                            <label for="ubah_ttl" class="col-md-2 col-form-label">Tempat, Tanggal Lahir</label>
                            <div class="col-md-9">
                                <textarea class="form-control" id="ubah_ttl" name="ubah_ttl" rows="1"></textarea>
                            </div>
                        </div>
                        <div class="mb-3 row">
                            <label for="ubah_status_nikah" class="col-md-2 col-form-label">Status Nikah</label>
                            <div class="col-md-9">
                                <select class="form-select" id="ubah_status_nikah" name="ubah_status_nikah">
                                    @foreach(\App\Models\Status::all() as $status_nikahs)
                                        <option value="{{ $status_nikahs->nama_status_nikah }}">{{ $status_nikahs->nama_status_nikah }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="mb-3 row">
                            <label for="ubah_agama" class="col-md-2 col-form-label">Agama</label>
                            <div class="col-md-9">
                                <select class="form-select" id="ubah_agama" name="ubah_agama">
                                    @foreach(\App\Models\Agama::all() as $agamas)
                                        <option value="{{ $agamas->nama_agama }}">{{ $agamas->nama_agama }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>                  
                        <div class="mb-3 row">
                            <label for="ubah_pekerjaan" class="col-md-2 col-form-label">Pekerjaan</label>
                            <div class="col-md-9">
                                <select class="form-select" id="ubah_pekerjaan" name="ubah_pekerjaan">
                                    @foreach(\App\Models\Pekerjaan::all() as $pekerjaans)
                                        <option value="{{ $pekerjaans->nama_pekerjaan }}">{{ $pekerjaans->nama_pekerjaan }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        {{-- <div class="mb-3 row">
                            <label for="ubah_jenis_kelamin" class="col-md-2 col-form-label">Jenis Kelamin</label>
                            <div class="col-md-9">
                                <select class="form-select" id="ubah_jenis_kelamin" name="ubah_jenis_kelamin">
                                    @foreach(\App\Models\JenisKelamin::all() as $jenis_kelamins)
                                        <option value="{{ $jenis_kelamins->nama_jenis_kelamin }}">{{ $jenis_kelamins->nama_jenis_kelamin }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div> --}}
                        <div class="mb-3 row">
                            <label for="ubah_alamat" class="col-md-2 col-form-label">Alamat</label>
                            <div class="col-md-9">
                                <textarea class="form-control" id="ubah_alamat" name="ubah_alamat" rows="1"></textarea>
                            </div>
                        </div>
                        <div class="mb-3 row">
                            <label for="ubah_usaha" class="col-md-2 col-form-label">Usaha</label>
                            <div class="col-md-9">
                                <textarea class="form-control" id="ubah_usaha" name="ubah_usaha" rows="1"></textarea>
                            </div>
                        </div>
                        {{-- <div class="mb-3 row">
                            <label for="ubah_alamat_dom" class="col-md-2 col-form-label">Alamat Domisili</label>
                            <div class="col-md-9">
                                <textarea class="form-control" id="ubah_alamat_dom" name="ubah_alamat_dom" rows="1"></textarea>
                            </div>
                        </div> --}}
                        <div class="mb-3 row">
                            <label for="ubah_keperluan" class="col-md-2 col-form-label">Keperluan</label>
                            <div class="col-md-9">
                                <textarea class="form-control" id="ubah_keperluan" name="ubah_keperluan" rows="1"></textarea>
                            </div>
                        </div>
                        <div class="mb-3 row">
                            <label for="ubah_jabatan" class="col-md-2 col-form-label">TTD Persetujuan</label>
                            <div class="col-md-9">
                                <select class="form-select" id="ubah_jabatan" name="ubah_jabatan">
                                    @foreach(\App\Models\Jabatan::all() as $jabatan)
                                        <option value="{{ $jabatan->nama }}">{{ $jabatan->nama }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Tutup</button>
                        <button type="submit" class="btn btn-warning" id="simpan_sku">Simpan Perubahan</button>
                    </div>
                </form>
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
                    <div class="row mb-1" id="pekerjaan_lainnya_row" style="display: none;">
                        <label class="col-md-2 col-form-label">Pekerjaan Lainnya</label>
                        <div class="col-md-9 d-flex align-items-center">
                            <span>:&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<label class="form-label" id="detail_pekerjaan_lainnya"></label></span>
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

    {{-- SURAT KETERANGAN BELUM MENIKAH --}}
    <div class="modal fade" id="ubahSKBM" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">UBAH DATA SURAT KETERANGAN BELUM MENIKAH</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <form method="POST" action="{{ route('ubah_skbm') }}" id="ubah_skbm">
                    @csrf
                    @method('PUT')
                    <input type="hidden" name="id_sk_belum_menikah" id="id_sk_belum_menikah" required>
                    <div class="modal-body">
                        <div class="mb-3 row">
                            <label for="jenis_surat" class="col-md-2 col-form-label">Jenis Surat</label>
                            <div class="col-md-9">
                                <input type="text" class="form-control" id="jenis_surat_2" name="jenis_surat_2" readonly>
                            </div>
                        </div>
                        <div class="mb-3 row">
                            <label for="ubah_nama" class="col-md-2 col-form-label">Nama</label>
                            <div class="col-md-9">
                                <textarea class="form-control" id="ubah_nama_2" name="ubah_nama_2" rows="1"></textarea>
                            </div>
                        </div>
                        <div class="mb-3 row">
                            <label for="ubah_nik" class="col-md-2 col-form-label">NIK</label>
                            <div class="col-md-9">
                                <textarea class="form-control" id="ubah_nik_2" name="ubah_nik_2" rows="1"></textarea>
                            </div>
                        </div>
                        <div class="mb-3 row">
                            <label for="ubah_ttl" class="col-md-2 col-form-label">Tempat, Tanggal Lahir</label>
                            <div class="col-md-9">
                                <textarea class="form-control" id="ubah_ttl_2" name="ubah_ttl_2" rows="1"></textarea>
                            </div>
                        </div>
                        <div class="mb-3 row">
                            <label for="ubah_status_nikah" class="col-md-2 col-form-label">Status Nikah</label>
                            <div class="col-md-9">
                                <select class="form-select" id="ubah_status_nikah_2" name="ubah_status_nikah_2">
                                    @foreach(\App\Models\Status::all() as $status_nikahs)
                                        <option value="{{ $status_nikahs->nama_status_nikah }}">{{ $status_nikahs->nama_status_nikah }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="mb-3 row">
                            <label for="ubah_agama" class="col-md-2 col-form-label">Agama</label>
                            <div class="col-md-9">
                                <select class="form-select" id="ubah_agama_2" name="ubah_agama_2">
                                    @foreach(\App\Models\Agama::all() as $agamas)
                                        <option value="{{ $agamas->nama_agama }}">{{ $agamas->nama_agama }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>                  
                        <div class="mb-3 row">
                            <label for="ubah_pekerjaan" class="col-md-2 col-form-label">Pekerjaan</label>
                            <div class="col-md-9">
                                <select class="form-select" id="ubah_pekerjaan_2" name="ubah_pekerjaan_2">
                                    @foreach(\App\Models\Pekerjaan::all() as $pekerjaans)
                                        <option value="{{ $pekerjaans->nama_pekerjaan }}">{{ $pekerjaans->nama_pekerjaan }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        {{-- <div class="mb-3 row">
                            <label for="ubah_jenis_kelamin" class="col-md-2 col-form-label">Jenis Kelamin</label>
                            <div class="col-md-9">
                                <select class="form-select" id="ubah_jenis_kelamin" name="ubah_jenis_kelamin">
                                    @foreach(\App\Models\JenisKelamin::all() as $jenis_kelamins)
                                        <option value="{{ $jenis_kelamins->nama_jenis_kelamin }}">{{ $jenis_kelamins->nama_jenis_kelamin }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div> --}}
                        <div class="mb-3 row">
                            <label for="ubah_alamat" class="col-md-2 col-form-label">Alamat</label>
                            <div class="col-md-9">
                                <textarea class="form-control" id="ubah_alamat_2" name="ubah_alamat_2" rows="1"></textarea>
                            </div>
                        </div>
                        {{-- <div class="mb-3 row">
                            <label for="ubah_alamat_dom" class="col-md-2 col-form-label">Alamat Domisili</label>
                            <div class="col-md-9">
                                <textarea class="form-control" id="ubah_alamat_dom" name="ubah_alamat_dom" rows="1"></textarea>
                            </div>
                        </div> --}}
                        <div class="mb-3 row">
                            <label for="ubah_keperluan" class="col-md-2 col-form-label">Keperluan</label>
                            <div class="col-md-9">
                                <textarea class="form-control" id="ubah_keperluan_2" name="ubah_keperluan_2" rows="1"></textarea>
                            </div>
                        </div>
                        <div class="mb-3 row">
                            <label for="ubah_jabatan" class="col-md-2 col-form-label">TTD Persetujuan</label>
                            <div class="col-md-9">
                                <select class="form-select" id="ubah_jabatan_2" name="ubah_jabatan_2">
                                    @foreach(\App\Models\Jabatan::all() as $jabatan)
                                        <option value="{{ $jabatan->nama }}">{{ $jabatan->nama }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Tutup</button>
                        <button type="submit" class="btn btn-warning" id="simpan_skbm">Simpan Perubahan</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    {{-- SURAT KETERANGAN DOMISILI --}}
    <div class="modal fade" id="ubahSKD" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">UBAH DATA SURAT KETERANGAN DOMISILI</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <form method="POST" action="{{ route('ubah_skd') }}" id="ubah_skd">
                    @csrf
                    @method('PUT')
                    <input type="hidden" name="id_sk_domisili" id="id_sk_domisili" required>
                    <div class="modal-body">
                        <div class="mb-3 row">
                            <label for="jenis_surat" class="col-md-2 col-form-label">Jenis Surat</label>
                            <div class="col-md-9">
                                <input type="text" class="form-control" id="jenis_surat_3" name="jenis_surat_3" readonly>
                            </div>
                        </div>
                        <div class="mb-3 row">
                            <label for="ubah_nama" class="col-md-2 col-form-label">Nama</label>
                            <div class="col-md-9">
                                <textarea class="form-control" id="ubah_nama_3" name="ubah_nama_3" rows="1"></textarea>
                            </div>
                        </div>
                        <div class="mb-3 row">
                            <label for="ubah_nik" class="col-md-2 col-form-label">NIK</label>
                            <div class="col-md-9">
                                <textarea class="form-control" id="ubah_nik_3" name="ubah_nik_3" rows="1"></textarea>
                            </div>
                        </div>
                        <div class="mb-3 row">
                            <label for="ubah_jenis_kelamin" class="col-md-2 col-form-label">Jenis Kelamin</label>
                            <div class="col-md-9">
                                <select class="form-select" id="ubah_jenis_kelamin" name="ubah_jenis_kelamin">
                                    @foreach(\App\Models\JenisKelamin::all() as $jenis_kelamins)
                                        <option value="{{ $jenis_kelamins->nama_jenis_kelamin }}">{{ $jenis_kelamins->nama_jenis_kelamin }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="mb-3 row">
                            <label for="ubah_ttl" class="col-md-2 col-form-label">Tempat, Tanggal Lahir</label>
                            <div class="col-md-9">
                                <textarea class="form-control" id="ubah_ttl_3" name="ubah_ttl_3" rows="1"></textarea>
                            </div>
                        </div>
                        <div class="mb-3 row">
                            <label for="ubah_agama" class="col-md-2 col-form-label">Agama</label>
                            <div class="col-md-9">
                                <select class="form-select" id="ubah_agama_3" name="ubah_agama_3">
                                    @foreach(\App\Models\Agama::all() as $agamas)
                                        <option value="{{ $agamas->nama_agama }}">{{ $agamas->nama_agama }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>  
                        <div class="mb-3 row">
                            <label for="ubah_status_nikah" class="col-md-2 col-form-label">Status Nikah</label>
                            <div class="col-md-9">
                                <select class="form-select" id="ubah_status_nikah_3" name="ubah_status_nikah_3">
                                    @foreach(\App\Models\Status::all() as $status_nikahs)
                                        <option value="{{ $status_nikahs->nama_status_nikah }}">{{ $status_nikahs->nama_status_nikah }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="mb-3 row">
                            <label for="ubah_pekerjaan" class="col-md-2 col-form-label">Pekerjaan</label>
                            <div class="col-md-9">
                                <select class="form-select" id="ubah_pekerjaan_3" name="ubah_pekerjaan_3">
                                    @foreach(\App\Models\Pekerjaan::all() as $pekerjaans)
                                        <option value="{{ $pekerjaans->nama_pekerjaan }}">{{ $pekerjaans->nama_pekerjaan }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="mb-3 row">
                            <label for="ubah_alamat" class="col-md-2 col-form-label">Alamat</label>
                            <div class="col-md-9">
                                <textarea class="form-control" id="ubah_alamat_3" name="ubah_alamat_3" rows="1"></textarea>
                            </div>
                        </div>
                        <div class="mb-3 row">
                            <label for="ubah_alamat_dom" class="col-md-2 col-form-label">Alamat Domisili</label>
                            <div class="col-md-9">
                                <textarea class="form-control" id="ubah_alamat_dom" name="ubah_alamat_dom" rows="1"></textarea>
                            </div>
                        </div>
                        <div class="mb-3 row">
                            <label for="ubah_keperluan" class="col-md-2 col-form-label">Keperluan</label>
                            <div class="col-md-9">
                                <textarea class="form-control" id="ubah_keperluan_3" name="ubah_keperluan_3" rows="1"></textarea>
                            </div>
                        </div>
                        <div class="mb-3 row">
                            <label for="ubah_jabatan" class="col-md-2 col-form-label">TTD Persetujuan</label>
                            <div class="col-md-9">
                                <select class="form-select" id="ubah_jabatan_3" name="ubah_jabatan_3">
                                    @foreach(\App\Models\Jabatan::all() as $jabatan)
                                        <option value="{{ $jabatan->nama }}">{{ $jabatan->nama }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Tutup</button>
                        <button type="submit" class="btn btn-warning" id="simpan_skbm">Simpan Perubahan</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    {{-- SURAT KETERANGAN TIDAK MAMPU --}}
    <div class="modal fade" id="ubahSKTM" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">UBAH DATA SURAT KETERANGAN TIDAK MAMPU</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <form method="POST" action="{{ route('ubah_sktm') }}" id="ubah_sktm">
                    @csrf
                    @method('PUT')
                    <input type="hidden" name="id_sk_tidak_mampu" id="id_sk_tidak_mampu" required>
                    <div class="modal-body">
                        <div class="mb-3 row">
                            <label for="jenis_surat" class="col-md-2 col-form-label">Jenis Surat</label>
                            <div class="col-md-9">
                                <input type="text" class="form-control" id="jenis_surat_4" name="jenis_surat_4" readonly>
                            </div>
                        </div>
                        <div class="mb-3 row">
                            <label for="ubah_nama" class="col-md-2 col-form-label">Nama</label>
                            <div class="col-md-9">
                                <textarea class="form-control" id="ubah_nama_4" name="ubah_nama_4" rows="1"></textarea>
                            </div>
                        </div>
                        <div class="mb-3 row">
                            <label for="ubah_nik" class="col-md-2 col-form-label">NIK</label>
                            <div class="col-md-9">
                                <textarea class="form-control" id="ubah_nik_4" name="ubah_nik_4" rows="1"></textarea>
                            </div>
                        </div>
                        <div class="mb-3 row">
                            <label for="ubah_ttl" class="col-md-2 col-form-label">Tempat, Tanggal Lahir</label>
                            <div class="col-md-9">
                                <textarea class="form-control" id="ubah_ttl_4" name="ubah_ttl_4" rows="1"></textarea>
                            </div>
                        </div>
                        <div class="mb-3 row">
                            <label for="ubah_agama" class="col-md-2 col-form-label">Agama</label>
                            <div class="col-md-9">
                                <select class="form-select" id="ubah_agama_4" name="ubah_agama_4">
                                    @foreach(\App\Models\Agama::all() as $agamas)
                                        <option value="{{ $agamas->nama_agama }}">{{ $agamas->nama_agama }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>  
                        <div class="mb-3 row">
                            <label for="ubah_pekerjaan" class="col-md-2 col-form-label">Pekerjaan</label>
                            <div class="col-md-9">
                                <select class="form-select" id="ubah_pekerjaan_4" name="ubah_pekerjaan_4">
                                    @foreach(\App\Models\Pekerjaan::all() as $pekerjaans)
                                        <option value="{{ $pekerjaans->nama_pekerjaan }}">{{ $pekerjaans->nama_pekerjaan }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="mb-3 row">
                            <label for="ubah_alamat" class="col-md-2 col-form-label">Alamat</label>
                            <div class="col-md-9">
                                <textarea class="form-control" id="ubah_alamat_4" name="ubah_alamat_4" rows="1"></textarea>
                            </div>
                        </div>
                        <div class="mb-3 row">
                            <label for="ubah_keperluan" class="col-md-2 col-form-label">Keperluan</label>
                            <div class="col-md-9">
                                <textarea class="form-control" id="ubah_keperluan_4" name="ubah_keperluan_4" rows="1"></textarea>
                            </div>
                        </div>
                        <div class="mb-3 row">
                            <label for="ubah_jabatan" class="col-md-2 col-form-label">TTD Persetujuan</label>
                            <div class="col-md-9">
                                <select class="form-select" id="ubah_jabatan_4" name="ubah_jabatan_4">
                                    @foreach(\App\Models\Jabatan::all() as $jabatan)
                                        <option value="{{ $jabatan->nama }}">{{ $jabatan->nama }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Tutup</button>
                        <button type="submit" class="btn btn-warning" id="simpan_sktm">Simpan Perubahan</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection

@section('script')
    <script>
        $(document).ready(function() {
            var table = $('.table').DataTable({
                order: [[0, 'desc']],
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


        // SURAT KETERANGAN USAHA
        $('#ubahSKU').on('show.bs.modal', function (event) {
            var button = $(event.relatedTarget);
            var id_sk_usaha = button.data('id_sk_usaha');
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
                        $("#id_sk_usaha").val(surat.id_sk_usaha);
                        $("#jenis_surat").val(surat.jenis_surat);
                        $("#ubah_nama").val(surat.nama);
                        $("#ubah_nik").val(surat.nik);
                        $("#ubah_ttl").val(surat.ttl);
                        $("#ubah_status_nikah").val(surat.status_nikah);
                        $("#ubah_agama").val(surat.agama);
                        $("#ubah_pekerjaan").val(surat.pekerjaan);
                        $("#ubah_alamat").val(surat.alamat);
                        $("#ubah_usaha").val(surat.usaha);
                        $("#ubah_keperluan").val(surat.keperluan);
                        $("#ubah_jabatan").val(surat.jabatan);
                    }
                }, 
            });
        });

        $(document).on('click', '.btn-edit', function(e){
            e.preventDefault();
            var id_sk_usaha = $(this).val();
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });
            $.ajax({
                type: "GET",
                url: "/ubah_isi_sku/"+id_sk_usaha,
                data: { id_sk_usaha: id_sk_usaha },
                success: function (response) {
                console.log(response);
                    $('#id_sk_usaha').val(response.surat.id_sk_usaha);
                    $('#jenis_surat').val(response.surat.jenis_surat);
                    $('#ubah_nama').val(response.surat.nama);
                    $('#ubah_nik').val(response.surat.nik);
                    $('#ubah_ttl').val(response.surat.ttl);
                    $('#ubah_status_nikah').val(response.surat.status_nikah);
                    $('#ubah_agama').val(response.surat.agama);
                    $('#ubah_pekerjaan').val(response.surat.pekerjaan);
                    $('#ubah_alamat').val(response.surat.alamat);
                    $('#ubah_usaha').val(response.surat.usaha);
                    $('#ubah_keperluan').val(response.surat.keperluan);
                    $('#ubah_jabatan').val(response.surat.jabatan);
                    $('#ubahSKU').modal('show');                
                }
            });        
        });

        $(document).ready(function() {
            $('#simpan_sku').click(function(event){
                event.preventDefault(); // Mencegah pengiriman formulir secara default
                var id_sk_usaha = document.getElementById("id_sk_usaha");
                var jenis_surat = document.getElementById("jenis_surat");
                var nama = document.getElementById("ubah_nama");
                var nik = document.getElementById("ubah_nik");
                var ttl = document.getElementById("ubah_ttl");
                var status_nikah = document.getElementById("ubah_status_nikah");
                var agama = document.getElementById("ubah_agama");
                var pekerjaan = document.getElementById("ubah_pekerjaan");
                var alamat = document.getElementById("ubah_alamat");
                var usaha = document.getElementById("ubah_usaha");
                var keperluan = document.getElementById("ubah_keperluan");
                var jabatan = document.getElementById("ubah_jabatan");
                if (!nama.value) {
                    // Tampilkan pesan kesalahan jika ada input yang kosong
                    Swal.fire({
                        icon: "error",
                        title: "Oops...",
                        text: "Semua inputan wajib diisi!",
                    });
                } else {
                    // Tampilkan pesan konfirmasi jika semua input telah diisi
                    Swal.fire({
                        icon: "info",
                        title: "Konfirmasi",
                        text: "Apakah Anda yakin data sudah benar?",
                        showCancelButton: true,
                        confirmButtonText: "Ya, Lanjutkan",
                        cancelButtonText: "Tidak, Batalkan",
                    }).then(function (result) {
                        if (result.isConfirmed) {
                            // Jika pengguna mengonfirmasi, lanjutkan dengan pengiriman formulir
                            $('#ubah_sku').submit();
                        }
                    });
                }
            });
        });


        // SURAT KETERANGAN BELUM MENIKAH
        $('#ubahSKBM').on('show.bs.modal', function (event) {
            var button = $(event.relatedTarget);
            var id_sk_belum_menikah = button.data('id_sk_belum_menikah');
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
                        $("#id_sk_belum_menikah").val(surat.id_sk_belum_menikah);
                        $("#jenis_surat_2").val(surat.jenis_surat);
                        $("#ubah_nama_2").val(surat.nama);
                        $("#ubah_nik_2").val(surat.nik);
                        $("#ubah_ttl_2").val(surat.ttl);
                        $("#ubah_status_nikah_2").val(surat.status_nikah);
                        $("#ubah_agama_2").val(surat.agama);
                        $("#ubah_pekerjaan_2").val(surat.pekerjaan);
                        $("#ubah_alamat_2").val(surat.alamat);
                        $("#ubah_keperluan_2").val(surat.keperluan);
                        $("#ubah_jabatan_2").val(surat.jabatan);
                    }
                }, 
            });
        });

        $(document).on('click', '.btn-edit', function(e){
            e.preventDefault();
            var id_sk_belum_menikah = $(this).val();
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });
            $.ajax({
                type: "GET",
                url: "/ubah_isi_skbm/"+id_sk_belum_menikah,
                data: { id_sk_belum_menikah: id_sk_belum_menikah },
                success: function (response) {
                console.log(response);
                    $('#id_sk_belum_menikah').val(response.surat.id_sk_belum_menikah);
                    $('#jenis_surat_2').val(response.surat.jenis_surat);
                    $('#ubah_nama_2').val(response.surat.nama);
                    $('#ubah_nik_2').val(response.surat.nik);
                    $('#ubah_ttl_2').val(response.surat.ttl);
                    $('#ubah_status_nikah_2').val(response.surat.status_nikah);
                    $('#ubah_agama_2').val(response.surat.agama);
                    $('#ubah_pekerjaan_2').val(response.surat.pekerjaan);
                    $('#ubah_alamat_2').val(response.surat.alamat);
                    $('#ubah_keperluan_2').val(response.surat.keperluan);
                    $('#ubah_jabatan_2').val(response.surat.jabatan);
                    $('#ubahSKBM').modal('show');                
                }
            });        
        });

        $(document).ready(function() {
            $('#simpan_skbm').click(function(event){
                event.preventDefault(); // Mencegah pengiriman formulir secara default
                var id_sk_belum_menikah = document.getElementById("id_sk_belum_menikah");
                var jenis_surat = document.getElementById("jenis_surat_2");
                var nama = document.getElementById("ubah_nama_2");
                var nik = document.getElementById("ubah_nik_2");
                var ttl = document.getElementById("ubah_ttl_2");
                var status_nikah = document.getElementById("ubah_status_nikah_2");
                var agama = document.getElementById("ubah_agama_2");
                var pekerjaan = document.getElementById("ubah_pekerjaan_2");
                var alamat = document.getElementById("ubah_alamat_2");
                var keperluan = document.getElementById("ubah_keperluan_2");
                var jabatan = document.getElementById("ubah_jabatan_2");
                if (!nama.value) {
                    // Tampilkan pesan kesalahan jika ada input yang kosong
                    Swal.fire({
                        icon: "error",
                        title: "Oops...",
                        text: "Semua inputan wajib diisi!",
                    });
                } else {
                    // Tampilkan pesan konfirmasi jika semua input telah diisi
                    Swal.fire({
                        icon: "info",
                        title: "Konfirmasi",
                        text: "Apakah Anda yakin data sudah benar?",
                        showCancelButton: true,
                        confirmButtonText: "Ya, Lanjutkan",
                        cancelButtonText: "Tidak, Batalkan",
                    }).then(function (result) {
                        if (result.isConfirmed) {
                            // Jika pengguna mengonfirmasi, lanjutkan dengan pengiriman formulir
                            $('#ubah_skbm').submit();
                        }
                    });
                }
            });
        });


        // SURAT KETERANGAN DOMISILI
        $('#ubahSKD').on('show.bs.modal', function (event) {
            var button = $(event.relatedTarget);
            var id_sk_domisili = button.data('id_sk_domisili');
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
                        $("#id_sk_domisili").val(surat.id_sk_domisili);
                        $("#jenis_surat_3").val(surat.jenis_surat);
                        $("#ubah_nama_3").val(surat.nama);
                        $("#ubah_nik_3").val(surat.nik);
                        $("#ubah_jenis_kelamin").val(surat.jenis_kelamin);
                        $("#ubah_ttl_3").val(surat.ttl);
                        $("#ubah_agama_3").val(surat.agama);
                        $("#ubah_status_nikah_3").val(surat.status_nikah);
                        $("#ubah_pekerjaan_3").val(surat.pekerjaan);
                        $("#ubah_alamat_3").val(surat.alamat);
                        $("#ubah_alamat_dom").val(surat.alamat_dom);
                        $("#ubah_keperluan_3").val(surat.keperluan);
                        $("#ubah_jabatan_3").val(surat.jabatan);
                    }
                }, 
            });
        });

        $(document).on('click', '.btn-edit', function(e){
            e.preventDefault();
            var id_sk_domisili = $(this).val();
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });
            $.ajax({
                type: "GET",
                url: "/ubah_isi_skd/"+id_sk_domisili,
                data: { id_sk_domisili: id_sk_domisili },
                success: function (response) {
                console.log(response);
                    $('#id_sk_domisili').val(response.surat.id_sk_domisili);
                    $('#jenis_surat_3').val(response.surat.jenis_surat);
                    $('#ubah_nama_3').val(response.surat.nama);
                    $('#ubah_nik_3').val(response.surat.nik);
                    $('#ubah_jenis_kelamin').val(response.surat.jenis_kelamin);
                    $('#ubah_ttl_3').val(response.surat.ttl);
                    $('#ubah_agama_3').val(response.surat.agama);
                    $('#ubah_status_nikah_3').val(response.surat.status_nikah);
                    $('#ubah_pekerjaan_3').val(response.surat.pekerjaan);
                    $('#ubah_alamat_3').val(response.surat.alamat);
                    $('#ubah_alamat_dom').val(response.surat.alamat_dom);
                    $('#ubah_keperluan_3').val(response.surat.keperluan);
                    $('#ubah_jabatan_3').val(response.surat.jabatan);
                    $('#ubahSKD').modal('show');                
                }
            });        
        });

        $(document).ready(function() {
            $('#simpan_skd').click(function(event){
                event.preventDefault(); // Mencegah pengiriman formulir secara default
                var id_sk_domisili = document.getElementById("id_sk_domisili");
                var jenis_surat = document.getElementById("jenis_surat_3");
                var nama = document.getElementById("ubah_nama_3");
                var nik = document.getElementById("ubah_nik_3");
                var jenis_kelamin = document.getElementById("ubah_jenis_kelamin");
                var ttl = document.getElementById("ubah_ttl_3");
                var agama = document.getElementById("ubah_agama_3");
                var status_nikah = document.getElementById("ubah_status_nikah_3");
                var pekerjaan = document.getElementById("ubah_pekerjaan_3");
                var alamat = document.getElementById("ubah_alamat_3");
                var alamat_dom = document.getElementById("ubah_alamat_dom");
                var keperluan = document.getElementById("ubah_keperluan_3");
                var jabatan = document.getElementById("ubah_jabatan_3");
                if (!nama.value) {
                    // Tampilkan pesan kesalahan jika ada input yang kosong
                    Swal.fire({
                        icon: "error",
                        title: "Oops...",
                        text: "Semua inputan wajib diisi!",
                    });
                } else {
                    // Tampilkan pesan konfirmasi jika semua input telah diisi
                    Swal.fire({
                        icon: "info",
                        title: "Konfirmasi",
                        text: "Apakah Anda yakin data sudah benar?",
                        showCancelButton: true,
                        confirmButtonText: "Ya, Lanjutkan",
                        cancelButtonText: "Tidak, Batalkan",
                    }).then(function (result) {
                        if (result.isConfirmed) {
                            // Jika pengguna mengonfirmasi, lanjutkan dengan pengiriman formulir
                            $('#ubah_skd').submit();
                        }
                    });
                }
            });
        });


        // SURAT KETERANGAN TIDAK MAMPU
        $('#ubahSKTM').on('show.bs.modal', function (event) {
            var button = $(event.relatedTarget);
            var id_sk_tidak_mampu = button.data('id_sk_tidak_mampu');
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
                        $("#id_sk_tidak_mampu").val(surat.id_sk_tidak_mampu);
                        $("#jenis_surat_4").val(surat.jenis_surat);
                        $("#ubah_nama_4").val(surat.nama);
                        $("#ubah_nik_4").val(surat.nik);
                        $("#ubah_ttl_4").val(surat.ttl);
                        $("#ubah_agama_4").val(surat.agama);
                        $("#ubah_pekerjaan_4").val(surat.pekerjaan);
                        $("#ubah_alamat_4").val(surat.alamat);
                        $("#ubah_keperluan_4").val(surat.keperluan);
                        $("#ubah_jabatan_4").val(surat.jabatan);
                    }
                }, 
            });
        });

        $(document).on('click', '.btn-edit', function(e){
            e.preventDefault();
            var id_sk_tidak_mampu = $(this).val();
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });
            $.ajax({
                type: "GET",
                url: "/ubah_isi_sktm/"+id_sk_tidak_mampu,
                data: { id_sk_tidak_mampu: id_sk_tidak_mampu },
                success: function (response) {
                console.log(response);
                    $('#id_sk_tidak_mampu').val(response.surat.id_sk_tidak_mampu);
                    $('#jenis_surat_4').val(response.surat.jenis_surat);
                    $('#ubah_nama_4').val(response.surat.nama);
                    $('#ubah_nik_4').val(response.surat.nik);
                    $('#ubah_ttl_4').val(response.surat.ttl);
                    $('#ubah_agama_4').val(response.surat.agama);
                    $('#ubah_pekerjaan_4').val(response.surat.pekerjaan);
                    $('#ubah_alamat_4').val(response.surat.alamat);
                    $('#ubah_keperluan_4').val(response.surat.keperluan);
                    $('#ubah_jabatan_4').val(response.surat.jabatan);
                    $('#ubahSKTM').modal('show');                
                }
            });        
        });

        $(document).ready(function() {
            $('#simpan_sktm').click(function(event){
                event.preventDefault(); // Mencegah pengiriman formulir secara default
                var id_sk_tidak_mampu = document.getElementById("id_sk_tidak_mampu");
                var jenis_surat = document.getElementById("jenis_surat_4");
                var nama = document.getElementById("ubah_nama_4");
                var nik = document.getElementById("ubah_nik_4");
                var ttl = document.getElementById("ubah_ttl_4");
                var agama = document.getElementById("ubah_agama_4");
                var pekerjaan = document.getElementById("ubah_pekerjaan_4");
                var alamat = document.getElementById("ubah_alamat_4");
                var keperluan = document.getElementById("ubah_keperluan_4");
                var jabatan = document.getElementById("ubah_jabatan_4");
                if (!nama.value) {
                    // Tampilkan pesan kesalahan jika ada input yang kosong
                    Swal.fire({
                        icon: "error",
                        title: "Oops...",
                        text: "Semua inputan wajib diisi!",
                    });
                } else {
                    // Tampilkan pesan konfirmasi jika semua input telah diisi
                    Swal.fire({
                        icon: "info",
                        title: "Konfirmasi",
                        text: "Apakah Anda yakin data sudah benar?",
                        showCancelButton: true,
                        confirmButtonText: "Ya, Lanjutkan",
                        cancelButtonText: "Tidak, Batalkan",
                    }).then(function (result) {
                        if (result.isConfirmed) {
                            // Jika pengguna mengonfirmasi, lanjutkan dengan pengiriman formulir
                            $('#ubah_sktm').submit();
                        }
                    });
                }
            });
        });


    // MODAL DETAIL DATA 1
    // $('#detailSKU').on('show.bs.modal', function (event) {
    //     var button = $(event.relatedTarget);
    //     var id_sk_usaha = button.data('id_sk_usaha');
    //     $.ajax({
    //         url: '{{ route("get_data_sku") }}',
    //         type: 'POST',
    //         data: {
    //             id_sk_usaha: id_sk_usaha, 
    //             _token: '{{ csrf_token() }}',
    //         },
    //         dataType: 'JSON',
    //         success: function(response) {
    //             if (response.status == 'success') {
    //                 var surat = response.surat;
    //                 $("#detail_jenis_surat").html(surat.jenis_surat);
    //                 $("#detail_nama").html(surat.nama);
    //                 $("#detail_nik").html(surat.nik);
    //                 $("#detail_ttl").html(surat.ttl);
    //                 $("#detail_status_nikah").html(surat.status_nikah);
    //                 $("#detail_agama").html(surat.agama);
    //                 $("#detail_pekerjaan").html(surat.pekerjaan);
    //                 $("#detail_alamat").html(surat.alamat);
    //                 $("#detail_usaha").html(surat.usaha);
    //                 $("#detail_keperluan").html(surat.keperluan);
    //                 $("#detail_status_surat").html(surat.status_surat);
    //                 $("#detail_tanggal").html(surat.tanggal);
    //                 $("#detail_jabatan").html(surat.jabatan);
    //             }
    //         }, 
    //     });

    // });

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

                if (surat.pekerjaan === 'Lainnya') {
                    $("#detail_pekerjaan_lainnya").html(surat.pekerjaan_lainnya);
                    $("#pekerjaan_lainnya_row").show();
                } else {
                    $("#pekerjaan_lainnya_row").hide();
                }
            }
        }, 
    });
});

    
    </script>
@endsection