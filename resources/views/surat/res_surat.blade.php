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
                            <h5>Data Surat Masuk</h5>
                        </div>
                        <div class="container-fluid table-responsive px-3 py-3">
                            <table class="table table-striped" id="tabelSPT" style="width:100%">
                                <thead>
                                    <tr>
                                        <th class="col-md-2 text-center align-middle">Tanggal Pengajuan</th>                           
                                        <th class="col-md-2 text-center align-middle">NIK</th>                           
                                        <th class="col-md-2 text-center align-middle">Jenis Surat</th>                           
                                        <th class="col-md-2 text-center align-middle">Nama</th>                           
                                        <th class="col-md-2 text-center align-middle">Status</th>                           
                                        <th class="col-md-2 text-center align-middle">Aksi</th>                           
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach(\App\Models\Surat::where('status_surat', '=', 'Diproses')->orWhere('status_surat','=', 'Ditolak')->get() as $surat)
                                        <tr>
                                            <td class="text-center align-middle">{{ $surat->nik_warga }}</td>
                                            <td class="text-center align-middle">{{ $surat->nik_warga }}</td>
                                            <td class="text-center align-middle">{{ $surat->jenis_surat }}</td>
                                            <td class="text-center align-middle">{{ $surat->nama_warga }}</td>
                                            <td class="text-center align-middle">{{ $surat->status_surat }}</td>
                                            <td class="text-center">
                                                <div class="d-flex justify-content-center">
                                                    {{-- <a role="button" class="btn btn-warning me-2" title="Ubah Data" style="padding: 0.25rem 0.5rem; font-size: 18px;" data-bs-toggle="modal" data-bs-target="#modalUbah" data-bs-id="{{ $surat->id_surat }}"><i class="bx bx-pencil"></i></a> --}}

                                                    <button type="button" data-bs-toggle="modal" data-bs-target="#modalUbah" data-bs-id="{{ $surat->id_surat }}" class="btn btn-info btn-sm">Ubah</button>

                                                    <button type="button" data-bs-toggle="modal" data-bs-target="#modalDetail" data-bs-id="{{ $surat->id_surat }}" class="btn btn-info btn-sm">Detail</button>

                                                    @if($surat->status_surat === 'Diproses')
                                                        <form method="POST" action="{{ route('verifikasi_surat', $surat->id_surat) }}" id="verifikasi-surat-{{ $surat->id_surat }}">
                                                            @csrf
                                                            @method('PUT')
                                                            <button type="button" id="btnVerifikasi-{{ $surat->id_surat }}" class="btn btn-primary btn-sm">Verifikasi</button>
                                                        </form>
                                                    @endif
                                                    @if($surat->status_surat === 'Ditolak')
                                                        <form method="POST" action="{{ route('hapus_surat', $surat->id_surat) }}" id="hapus-surat-{{ $surat->id_surat }}">
                                                            @csrf
                                                            @method('DELETE')
                                                            <a role="button" id="btnHapus-{{ $surat->id_surat }}" class="btn btn-danger" title="Hapus Data"style="padding: 0.25rem 0.5rem; font-size: 18px;"><i class="bx bx-trash-alt"></i></a>
                                                        </form>
                                                    @endif
                                                </div>
                                                <script>
                                                    // BUTTON VERIFIKASI
                                                    $('#btnVerifikasi-{{ $surat->id_surat }}').click(function(event){
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
                                                                $('#verifikasi-surat-{{ $surat->id_surat }}')
                                                                    .append('<input type="hidden" name="aksi" value="setuju" required>')
                                                                    .submit();
                                                            } else if (result.isDenied) {
                                                                $('#verifikasi-surat-{{ $surat->id_surat }}')
                                                                    .append('<input type="hidden" name="aksi" value="tolak" required>')
                                                                    .submit();
                                                            }
                                                        });
                                                    });

                                                    // BUTTON DELETE
                                                    $('#btnHapus-{{ $surat->id_surat }}').click(function(event){
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
                                                                $('#hapus-surat-{{ $surat->id_surat }}').submit();
                                                            }
                                                        });
                                                    });
                                                </script>
                                            </td>
                                        </tr>
                                    @endforeach

                                    @foreach(\App\Models\SKUsaha::where('status_surat', 'Diproses')->orWhere('status_surat', 'Ditolak')->get() as $sk_usaha)
                                        <tr>
                                            <td class="text-center align-middle">{{ $sk_usaha->tanggal }}</td>
                                            <td class="text-center align-middle">{{ $sk_usaha->nik }}</td>
                                            <td class="text-center align-middle">{{ $sk_usaha->jenis_surat }}</td>
                                            <td class="text-center align-middle">{{ $sk_usaha->nama }}</td>
                                            <td class="text-center align-middle">{{ $sk_usaha->status_surat }}</td>
                                            <td class="text-center">
                                                <div class="d-flex justify-content-center">
                                                    {{-- <a role="button" class="btn btn-warning me-2" title="Ubah Data" style="padding: 0.25rem 0.5rem; font-size: 18px;" data-bs-toggle="modal" data-bs-target="#modalUbah" data-bs-id="{{ $surat->id_surat }}"><i class="bx bx-pencil"></i></a> --}}

                                                    <button type="button" data-bs-toggle="modal" data-bs-target="#modalUbah" data-bs-id="{{ $sk_usaha->id_sk_usaha }}" class="btn btn-info btn-sm">Ubah</button>

                                                    <button type="button" data-bs-toggle="modal" data-bs-target="#detail_sk_usaha" data-bs-id="{{ $sk_usaha->id_sk_usaha }}" class="btn btn-info btn-sm">Detail</button>

                                                    @if($sk_usaha->status_surat === 'Diproses')
                                                        <form method="POST" action="{{ route('verifikasi_sk_usaha', $sk_usaha->id_sk_usaha) }}" id="verifikasi-surat-{{ $sk_usaha->id_sk_usaha }}">
                                                            @csrf
                                                            @method('PUT')
                                                            <button type="button" id="btnVerifikasi-{{ $sk_usaha->id_sk_usaha }}" class="btn btn-primary btn-sm">Verifikasi</button>
                                                        </form>
                                                    @endif
                                                    @if($sk_usaha->status_surat === 'Ditolak')
                                                        <form method="POST" action="{{ route('hapus_sk_usaha', $sk_usaha->id_sk_usaha) }}" id="hapus-surat-{{ $sk_usaha->id_sk_usaha }}">
                                                            @csrf
                                                            @method('DELETE')
                                                            <a role="button" id="btnHapus-{{ $sk_usaha->id_sk_usaha }}" class="btn btn-danger" title="Hapus Data"style="padding: 0.25rem 0.5rem; font-size: 18px;"><i class="bx bx-trash-alt"></i></a>
                                                        </form>
                                                    @endif
                                                </div>
                                                <script>
                                                    // BUTTON VERIFIKASI
                                                    $('#btnVerifikasi-{{ $sk_usaha->id_sk_usaha }}').click(function(event){
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
                                                                $('#verifikasi-surat-{{ $sk_usaha->id_sk_usaha }}')
                                                                    .append('<input type="hidden" name="aksi" value="setuju" required>')
                                                                    .submit();
                                                            } else if (result.isDenied) {
                                                                $('#verifikasi-surat-{{ $sk_usaha->id_sk_usaha }}')
                                                                    .append('<input type="hidden" name="aksi" value="tolak" required>')
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

                                    @foreach(\App\Models\SKBelumMenikah::where('status_surat', 'Diproses')->orWhere('status_surat', 'Ditolak')->get() as $sk_belum_menikah)
                                        <tr>
                                            <td class="text-center align-middle">{{ $sk_belum_menikah->tanggal }}</td>
                                            <td class="text-center align-middle">{{ $sk_belum_menikah->nik }}</td>
                                            <td class="text-center align-middle">{{ $sk_belum_menikah->jenis_surat }}</td>
                                            <td class="text-center align-middle">{{ $sk_belum_menikah->nama }}</td>
                                            <td class="text-center align-middle">{{ $sk_belum_menikah->status_surat }}</td>
                                            <td class="text-center">
                                                <div class="d-flex justify-content-center">
                                                    {{-- <a role="button" class="btn btn-warning me-2" title="Ubah Data" style="padding: 0.25rem 0.5rem; font-size: 18px;" data-bs-toggle="modal" data-bs-target="#modalUbah" data-bs-id="{{ $surat->id_surat }}"><i class="bx bx-pencil"></i></a> --}}

                                                    <button type="button" data-bs-toggle="modal" data-bs-target="#modalUbah" data-bs-id="{{ $sk_belum_menikah->id_belum_menikah }}" class="btn btn-info btn-sm">Ubah</button>

                                                    <button type="button" data-bs-toggle="modal" data-bs-target="#detail_sk_usaha" data-bs-id="{{ $sk_belum_menikah->id_sk_belum_menikah }}" class="btn btn-info btn-sm">Detail</button>

                                                    @if($sk_belum_menikah->status_surat === 'Diproses')
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
                                    @endforeach

                                    @foreach(\App\Models\SKDomisili::where('status_surat', 'Diproses')->orWhere('status_surat', 'Ditolak')->get() as $skd)
                                        <tr>
                                            <td class="text-center align-middle">{{ $skd->tanggal }}</td>
                                            <td class="text-center align-middle">{{ $skd->nik }}</td>
                                            <td class="text-center align-middle">{{ $skd->jenis_surat }}</td>
                                            <td class="text-center align-middle">{{ $skd->nama }}</td>
                                            <td class="text-center align-middle">{{ $skd->status_surat }}</td>
                                            <td class="text-center">
                                                <div class="d-flex justify-content-center">
                                                    {{-- <a role="button" class="btn btn-warning me-2" title="Ubah Data" style="padding: 0.25rem 0.5rem; font-size: 18px;" data-bs-toggle="modal" data-bs-target="#modalUbah" data-bs-id="{{ $surat->id_surat }}"><i class="bx bx-pencil"></i></a> --}}

                                                    <button type="button" data-bs-toggle="modal" data-bs-target="#modalUbah" data-bs-id="{{ $skd->id_sk_domisili }}" class="btn btn-info btn-sm">Ubah</button>

                                                    <button type="button" data-bs-toggle="modal" data-bs-target="#detail_sk_usaha" data-bs-id="{{ $skd->id_sk_domisili }}" class="btn btn-info btn-sm">Detail</button>

                                                    @if($skd->status_surat === 'Diproses')
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
                                            <td class="text-center align-middle">{{ $sktm->nik }}</td>
                                            <td class="text-center align-middle">{{ $sktm->jenis_surat }}</td>
                                            <td class="text-center align-middle">{{ $sktm->nama }}</td>
                                            <td class="text-center align-middle">{{ $sktm->status_surat }}</td>
                                            <td class="text-center">
                                                <div class="d-flex justify-content-center">
                                                    {{-- <a role="button" class="btn btn-warning me-2" title="Ubah Data" style="padding: 0.25rem 0.5rem; font-size: 18px;" data-bs-toggle="modal" data-bs-target="#modalUbah" data-bs-id="{{ $surat->id_surat }}"><i class="bx bx-pencil"></i></a> --}}

                                                    <button type="button" data-bs-toggle="modal" data-bs-target="#modalUbah" data-bs-id="{{ $sktm->id_sk_tidak_mampu }}" class="btn btn-info btn-sm">Ubah</button>

                                                    <button type="button" data-bs-toggle="modal" data-bs-target="#detail_sk_usaha" data-bs-id="{{ $sktm->id_sk_tidak_mampu }}" class="btn btn-info btn-sm">Detail</button>

                                                    @if($sktm->status_surat === 'Diproses')
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
    {{-- MODAL UBAH DATA --}}
    <div class="modal fade" id="modalUbah" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">UBAH DATA SURAT</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <form method="POST" action="{{ route('edit_surat') }}" id="formUbah">
                    @csrf
                    @method('PUT')
                    <input type="hidden" name="id_surat" id="id_surat" required>
                    <div class="modal-body">
                        <div class="mb-3 row">
                            <label for="jenis_surat" class="col-md-2 col-form-label">Jenis Surat</label>
                            <div class="col-md-9">
                                <input type="text" class="form-control" id="jenis_surat" name="jenis_surat" readonly>
                            </div>
                        </div>
                        <div class="mb-3 row">
                            <label for="ubah_nama_warga" class="col-md-2 col-form-label">Nama</label>
                            <div class="col-md-9">
                                <textarea class="form-control" id="ubah_nama_warga" name="ubah_nama_warga" rows="1"></textarea>
                            </div>
                        </div>
                        <div class="mb-3 row">
                            <label for="ubah_nik_warga" class="col-md-2 col-form-label">NIK</label>
                            <div class="col-md-9">
                                <textarea class="form-control" id="ubah_nik_warga" name="ubah_nik_warga" rows="1"></textarea>
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
                            <label for="ubah_usaha" class="col-md-2 col-form-label">Usaha</label>
                            <div class="col-md-9">
                                <textarea class="form-control" id="ubah_usaha" name="ubah_usaha" rows="1"></textarea>
                            </div>
                        </div>
                        <div class="mb-3 row">
                            <label for="ubah_ttl" class="col-md-2 col-form-label">Tempat, Tanggal Lahir</label>
                            <div class="col-md-9">
                                <textarea class="form-control" id="ubah_ttl" name="ubah_ttl" rows="1"></textarea>
                            </div>
                        </div>
                        <div class="mb-3 row">
                            <label for="ubah_alamat" class="col-md-2 col-form-label">Alamat</label>
                            <div class="col-md-9">
                                <textarea class="form-control" id="ubah_alamat" name="ubah_alamat" rows="1"></textarea>
                            </div>
                        </div>
                        <div class="mb-3 row">
                            <label for="ubah_alamat_dom" class="col-md-2 col-form-label">Alamat Domisili</label>
                            <div class="col-md-9">
                                <textarea class="form-control" id="ubah_alamat_dom" name="ubah_alamat_dom" rows="1"></textarea>
                            </div>
                        </div>
                        <div class="mb-3 row">
                            <label for="ubah_alamat_dom" class="col-md-2 col-form-label">Keperluan</label>
                            <div class="col-md-9">
                                <textarea class="form-control" id="ubah_keperluan" name="ubah_keperluan" rows="1"></textarea>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Tutup</button>
                        <button type="submit" class="btn btn-warning" id="simpanPerubahan">Simpan Perubahan</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    {{-- MODAL DETAIL --}}
    <div class="modal fade" id="modalDetail" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">DETAIL SURAT</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="mb-3 row">
                        <label class="col-md-2 col-form-label">Jenis Surat</label>
                        <span class="col-md-9 col-form-label" style="padding-top: 0;display: flex;padding-top: calc(.47rem + var(--bs-border-width));">:&nbsp &nbsp &nbsp &nbsp &nbsp;
                            <label class="col-form-label" id="detail_jenis_surat" style="padding-top: 0;"></label>
                        </span>
                    </div>
                    <div class="mb-3 row">
                        <label class="col-md-2 col-form-label">Nama</label>
                        <span class="col-md-9 col-form-label" style="padding-top: 0;display: flex;padding-top: calc(.47rem + var(--bs-border-width));">:&nbsp &nbsp &nbsp &nbsp &nbsp;
                            <label class="col-form-label" id="detail_nama" style="padding-top: 0;"></label>
                        </span>
                    </div>
                    <div class="mb-3 row">
                        <label class="col-md-2 col-form-label">NIK</label>
                        <span class="col-md-9 col-form-label" style="padding-top: 0;display: flex;padding-top: calc(.47rem + var(--bs-border-width));">:&nbsp &nbsp &nbsp &nbsp &nbsp;
                            <label class="col-form-label" id="detail_nik" style="padding-top: 0;"></label>
                        </span>
                    </div>
                    <div class="mb-3 row">
                        <label class="col-md-2 col-form-label">Agama</label>
                        <span class="col-md-9 col-form-label" style="padding-top: 0;display: flex;padding-top: calc(.47rem + var(--bs-border-width));">:&nbsp &nbsp &nbsp &nbsp &nbsp;
                            <label class="col-form-label" id="detail_agama" style="padding-top: 0;"></label>
                        </span>
                    </div>
                    <div class="mb-3 row">
                        <label class="col-md-2 col-form-label">Pekerjaan</label>
                        <span class="col-md-9 col-form-label" style="padding-top: 0;display: flex;padding-top: calc(.47rem + var(--bs-border-width));">:&nbsp &nbsp &nbsp &nbsp &nbsp;
                            <label class="col-form-label" id="detail_pekerjaan" style="padding-top: 0;"></label>
                        </span>
                    </div>
                    <div class="mb-3 row">
                        <label class="col-md-2 col-form-label">Status Nikah</label>
                        <span class="col-md-9 col-form-label" style="padding-top: 0;display: flex;padding-top: calc(.47rem + var(--bs-border-width));">:&nbsp &nbsp &nbsp &nbsp &nbsp;
                            <label class="col-form-label" id="detail_status_nikah" style="padding-top: 0;"></label>
                        </span>
                    </div>
                    <div class="mb-3 row">
                        <label class="col-md-2 col-form-label">Jenis Kelamin</label>
                        <span class="col-md-9 col-form-label" style="padding-top: 0;display: flex;padding-top: calc(.47rem + var(--bs-border-width));">:&nbsp &nbsp &nbsp &nbsp &nbsp;
                            <label class="col-form-label" id="detail_jenis_kelamin" style="padding-top: 0;"></label>
                        </span>
                    </div>
                    <div class="mb-3 row">
                        <label class="col-md-2 col-form-label">Usaha</label>
                        <span class="col-md-9 col-form-label" style="padding-top: 0;display: flex;padding-top: calc(.47rem + var(--bs-border-width));">:&nbsp &nbsp &nbsp &nbsp &nbsp;
                            <label class="col-form-label" id="detail_usaha" style="padding-top: 0;"></label>
                        </span>
                    </div>
                    <div class="mb-3 row">
                        <label class="col-md-2 col-form-label">Tempat, Tanggal Lahir</label>
                        <span class="col-md-9 col-form-label" style="padding-top: 0;display: flex;padding-top: calc(.47rem + var(--bs-border-width));">:&nbsp &nbsp &nbsp &nbsp &nbsp;
                            <label class="col-form-label" id="detail_ttl" style="padding-top: 0;"></label>
                        </span>
                    </div>
                    <div class="mb-3 row">
                        <label class="col-md-2 col-form-label">Alamat</label>
                        <span class="col-md-9 col-form-label" style="padding-top: 0;display: flex;padding-top: calc(.47rem + var(--bs-border-width));">:&nbsp &nbsp &nbsp &nbsp &nbsp;
                            <label class="col-form-label" id="detail_alamat" style="padding-top: 0;"></label>
                        </span>
                    </div>
                    <div class="mb-3 row">
                        <label class="col-md-2 col-form-label">Alamat Domisili</label>
                        <span class="col-md-9 col-form-label" style="padding-top: 0;display: flex;padding-top: calc(.47rem + var(--bs-border-width));">:&nbsp &nbsp &nbsp &nbsp &nbsp;
                            <label class="col-form-label" id="detail_alamat_dom" style="padding-top: 0;"></label>
                        </span>
                    </div>
                    <div class="mb-3 row">
                        <label class="col-md-2 col-form-label">Keperluan</label>
                        <span class="col-md-9 col-form-label" style="padding-top: 0;display: flex;padding-top: calc(.47rem + var(--bs-border-width));">:&nbsp &nbsp &nbsp &nbsp &nbsp;
                            <label class="col-form-label" id="detail_keperluan" style="padding-top: 0;"></label>
                        </span>
                    </div>
                </div>               
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Tutup</button>
                </div>
            </div>
        </div>
    </div>

    {{-- <div class="modal fade" id="detail_sk_usaha" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">DETAIL SURAT KETERANGAN USAHA</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="mb-3 row">
                        <label class="col-md-2 col-form-label">Jenis Surat</label>
                        <span class="col-md-9 col-form-label" style="padding-top: 0;display: flex;padding-top: calc(.47rem + var(--bs-border-width));">:&nbsp &nbsp &nbsp &nbsp &nbsp;
                            <label class="col-form-label" id="detail_jenis_surat" style="padding-top: 0;"></label>
                        </span>
                    </div>
                    <div class="mb-3 row">
                        <label class="col-md-2 col-form-label">Nama</label>
                        <span class="col-md-9 col-form-label" style="padding-top: 0;display: flex;padding-top: calc(.47rem + var(--bs-border-width));">:&nbsp &nbsp &nbsp &nbsp &nbsp;
                            <label class="col-form-label" id="detail_nama" style="padding-top: 0;"></label>
                        </span>
                    </div>
                    <div class="mb-3 row">
                        <label class="col-md-2 col-form-label">NIK</label>
                        <span class="col-md-9 col-form-label" style="padding-top: 0;display: flex;padding-top: calc(.47rem + var(--bs-border-width));">:&nbsp &nbsp &nbsp &nbsp &nbsp;
                            <label class="col-form-label" id="detail_nik" style="padding-top: 0;"></label>
                        </span>
                    </div>
                    <div class="mb-3 row">
                        <label class="col-md-2 col-form-label">Tempat, Tanggal Lahir</label>
                        <span class="col-md-9 col-form-label" style="padding-top: 0;display: flex;padding-top: calc(.47rem + var(--bs-border-width));">:&nbsp &nbsp &nbsp &nbsp &nbsp;
                            <label class="col-form-label" id="detail_ttl" style="padding-top: 0;"></label>
                        </span>
                    </div>
                    <div class="mb-3 row">
                        <label class="col-md-2 col-form-label">Status Nikah</label>
                        <span class="col-md-9 col-form-label" style="padding-top: 0;display: flex;padding-top: calc(.47rem + var(--bs-border-width));">:&nbsp &nbsp &nbsp &nbsp &nbsp;
                            <label class="col-form-label" id="detail_status_nikah" style="padding-top: 0;"></label>
                        </span>
                    </div>
                    <div class="mb-3 row">
                        <label class="col-md-2 col-form-label">Agama</label>
                        <span class="col-md-9 col-form-label" style="padding-top: 0;display: flex;padding-top: calc(.47rem + var(--bs-border-width));">:&nbsp &nbsp &nbsp &nbsp &nbsp;
                            <label class="col-form-label" id="detail_agama" style="padding-top: 0;"></label>
                        </span>
                    </div>
                    <div class="mb-3 row">
                        <label class="col-md-2 col-form-label">Pekerjaan</label>
                        <span class="col-md-9 col-form-label" style="padding-top: 0;display: flex;padding-top: calc(.47rem + var(--bs-border-width));">:&nbsp &nbsp &nbsp &nbsp &nbsp;
                            <label class="col-form-label" id="detail_pekerjaan" style="padding-top: 0;"></label>
                        </span>
                    </div>
                    <div class="mb-3 row">
                        <label class="col-md-2 col-form-label">Alamat</label>
                        <span class="col-md-9 col-form-label" style="padding-top: 0;display: flex;padding-top: calc(.47rem + var(--bs-border-width));">:&nbsp &nbsp &nbsp &nbsp &nbsp;
                            <label class="col-form-label" id="detail_alamat" style="padding-top: 0;"></label>
                        </span>
                    </div>
                    <div class="mb-3 row">
                        <label class="col-md-2 col-form-label">Usaha</label>
                        <span class="col-md-9 col-form-label" style="padding-top: 0;display: flex;padding-top: calc(.47rem + var(--bs-border-width));">:&nbsp &nbsp &nbsp &nbsp &nbsp;
                            <label class="col-form-label" id="detail_usaha" style="padding-top: 0;"></label>
                        </span>
                    </div>
                    <div class="mb-3 row">
                        <label class="col-md-2 col-form-label">Keperluan</label>
                        <span class="col-md-9 col-form-label" style="padding-top: 0;display: flex;padding-top: calc(.47rem + var(--bs-border-width));">:&nbsp &nbsp &nbsp &nbsp &nbsp;
                            <label class="col-form-label" id="detail_keperluan" style="padding-top: 0;"></label>
                        </span>
                    </div>
                    <div class="mb-3 row">
                        <label class="col-md-2 col-form-label">Tanggal Pengajuan</label>
                        <span class="col-md-9 col-form-label" style="padding-top: 0;display: flex;padding-top: calc(.47rem + var(--bs-border-width));">:&nbsp &nbsp &nbsp &nbsp &nbsp;
                            <label class="col-form-label" id="detail_tanggal" style="padding-top: 0;"></label>
                        </span>
                    </div>
                </div>               
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Tutup</button>
                </div>
            </div>
        </div>
    </div> --}}
@endsection

@section('script')
<script>
    $(document).ready(function() {
        $('.table').DataTable({
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

    function showForm(jenisSurat) {
        var forms = document.querySelectorAll('.form_surat');
        
        forms.forEach(function(form) {
            var formId = form.id.split("_").pop(); 
            if (formId === jenisSurat) {
                form.style.display = "block";
            } else {
                form.style.display = "none";
            }
        });
    }

    // $(document).ready(function () {
    //     $('.open-ubah-modal').click(function () {
    //         var surat_id = $(this).data('id');
    //         $('#id_surat').val(surat_id);
    //         $('#modalUbah').modal('show');
    //     });
    // });

    // // // MODAL EDIT DATA SUCCEED
    // $('#modalUbah').on('show.bs.modal', function (event) {
    //     var button = $(event.relatedTarget);
    //     $.ajax({
    //         url: '{{ route("get_data_surat") }}',
    //         type: "POST",
    //         data: {
    //             id: button.data('bs-id'),
    //             _token: '{{ csrf_token() }}',
    //         },
    //         dataType: 'JSON',

    //         success: function(response) {
    //             console.log(response);
    //             fillModalWithData(response.surats);
    //         },
    //         error: function (xhr, status, error) {
    //             console.error(xhr.responseText);
    //         }
    //     });
    // });

    // function fillModalWithData(data) {
    //     $('#jenis_surat').val(data.jenis_surat);
    //     $('#ubah_nama_warga').val(data.nama_warga);
    //     $('#ubah_nik_warga').val(data.nik_warga);
    //     $('#ubah_agama').val(data.agama);
    //     $('#ubah_pekerjaan').val(data.pekerjaan);
    //     $('#ubah_usaha').val(data.usaha);
    //     $('#ubah_ttl').val(data.ttl);
    //     $('#ubah_alamat').val(data.alamat);
    //     $('#ubah_alamat_dom').val(data.alamat_dom);
    //     $('#ubah_status_surat').val(data.status_surat);
    //     $('#ubah_keperluan').val(data.keperluan);

    //     switch(data.jenis_surat) {
    //         case "SURAT KETERANGAN DOMISILI":
    //             $("#ubah_alamat_dom").closest('.form-group').show();
    //             break;
    //         case "SURAT KETERANGAN BELUM MENIKAH":
    //             $("#ubah_status_surat").closest('.form-group').show();
    //             break;
    //         // Tambahkan case untuk jenis surat lainnya di sini
    //         default:
    //             // Semua elemen disembunyikan jika jenis surat tidak sesuai
    //             $(".modal-body .form-group").hide();
    //     }
    // }

    // // Event listener untuk tombol "Simpan Perubahan"
    // $('#simpanPerubahan').click(function(event){
    //     event.preventDefault(); 

    //     var namawarga = document.getElementById("ubah_nama_warga");
    //     var nikwarga = document.getElementById("ubah_nik_warga");

    //     if (!namawarga.value || !nikwarga.value) {
    //         Swal.fire({
    //             icon: "error",
    //             title: "Oops...",
    //             text: "Nama warga dan NIK warga wajib diisi!",
    //         });
    //     } else {
    //         Swal.fire({
    //             icon: "info",
    //             title: "Konfirmasi",
    //             text: "Apakah Anda yakin data sudah benar?",
    //             showCancelButton: true,
    //             confirmButtonText: "Ya, Lanjutkan",
    //             cancelButtonText: "Tidak, Batalkan",
    //         }).then(function (result) {
    //             if (result.isConfirmed) {
    //                 $('#formUbah').submit();
    //             }
    //         });
    //     }
    // });


    
    $('#modalUbah').on('show.bs.modal', function (event) {
        var button = $(event.relatedTarget);
        var id = button.data('bs-id');
        $.ajax({
            url: '{{ route("get_data_surat") }}',
            type: 'POST',
            data: {
                id: button.data('bs-id'),
                _token: '{{ csrf_token() }}',
            },
            dataType: 'JSON',
            success: function(response) {
                if (response.status == 'success') {
                    var surats = response.surats;
                    $("#id_surat").val(surats.id_surat);
                    $("#jenis_surat").val(surats.jenis_surat);
                    $("#ubah_nama_warga").val(surats.nama_warga);
                    $("#ubah_nik_warga").val(surats.nik_warga);
                    $("#ubah_agama").val(surats.agama);
                    $("#ubah_pekerjaan").val(surats.pekerjaan);
                    $("#ubah_usaha").val(surats.usaha);
                    $("#ubah_ttl").val(surats.ttl);
                    $("#ubah_alamat").val(surats.alamat);
                    $("#ubah_alamat_dom").val(surats.alamat_dom);
                    $("#ubah_status_surat").val(surats.status_surat);
                }
            }, 
        });
    });


    $(document).on('click', '.btn-edit', function(e){
        e.preventDefault();
        var surat_id = $(this).val();
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });
        $.ajax({
            type: "GET",
            url: "/ubah_isi_surat/"+surat_id,
            success: function (response) {
            console.log(response);
                $('#jenis_surat').val(response.surats.jenis_surat);
                $('#ubah_nama_warga').val(response.surats.nama_warga);
                $('#ubah_nik_warga').val(response.surats.nik_warga);
                $('#ubah_agama').val(response.surats.agama);
                $('#ubah_pekerjaan').val(response.surats.pekerjaan);
                $('#ubah_usaha').val(response.surats.usaha);
                $('#ubah_ttl').val(response.surats.ttl);
                $('#ubah_alamat').val(response.surats.alamat);
                $('#ubah_alamat_dom').val(response.surats.alamat_dom);
                $('#ubah_status_surat').val(response.surats.status_surat);
                $('#modalUbah').modal('show');                
            }
        });        
    });

    // simpan
    $(document).ready(function() {
        $('#simpanPerubahan').click(function(event){
            event.preventDefault(); // Mencegah pengiriman formulir secara default
            // var jenissurat = document.getElementById("jenis_surat");
            var namawarga = document.getElementById("ubah_nama_warga");
            var nikwarga = document.getElementById("ubah_nama_warga");
            var agamawarga = document.getElementById("ubah_agama");
            var pekerjaanwarga = document.getElementById("ubah_pekerjaan");
            var usahawarga = document.getElementById("ubah_usaha");
            var ttlwarga = document.getElementById("ubah_ttl");
            var alamatwarga = document.getElementById("ubah_alamat");
            var alamatdomwarga = document.getElementById("ubah_alamat_dom");
            var statussurat = document.getElementById("ubah_status_surat");
            if (!namawarga.value) {
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
                        $('#formUbah').submit();
                    }
                });
            }
        });
    });










    // MODAL DETAIL DATA 1
    $('#modalDetail').on('show.bs.modal', function (event) {
        var button = $(event.relatedTarget);
        var id = button.data('bs-id');
        $.ajax({
            url: '{{ route("get_data_surat") }}',
            type: 'POST',
            data: {
                id: button.data('bs-id'),
                _token: '{{ csrf_token() }}',
            },
            dataType: 'JSON',
            success: function(response) {
                if (response.status == 'success') {
                    var surats = response.surats;
                    $("#detail_jenis_surat").html(surats.jenis_surat);
                    $("#detail_nama").html(surats.nama_warga);
                    $("#detail_nik").html(surats.nik_warga);
                    $("#detail_agama").html(surats.agama);
                    $("#detail_pekerjaan").html(surats.pekerjaan);
                    $("#detail_status_nikah").html(surats.status_nikah);
                    $("#detail_usaha").html(surats.usaha);
                    $("#detail_ttl").html(surats.ttl);
                    $("#detail_alamat").html(surats.alamat);
                    $("#detail_alamat_dom").html(surats.alamat_dom);
                    $("#detail_keperluan").html(surats.keperluan);
                    $("#detail_jenis_kelamin").html(surats.jenis_kelamin);
                }
            }, 
        });
    });

    // MODAL DETAIL DATA 2
    $('#modalDetail').on('show.bs.modal', function (event) {
        var button = $(event.relatedTarget);
        $.ajax({
            url: '{{ route("get_data_surat") }}',
            type: 'POST',
            data: {
                id: button.data('bs-id'),
                _token: '{{ csrf_token() }}',
            },
            dataType: 'JSON',
            success: function(response) {
                if (response.status == 'success') {
                    var surats = response.surats;
                    // Hide all detail elements initially
                    $(".modal-body .row").hide();
                    // Show specific detail elements based on the type of surat
                    switch(surats.jenis_surat) {
                        case "SURAT KETERANGAN DOMISILI":
                            $("#detail_jenis_surat").closest('.row').show();
                            $("#detail_nama").closest('.row').show();
                            $("#detail_nik").closest('.row').show();
                            $("#detail_jenis_kelamin").closest('.row').show();
                            $("#detail_ttl").closest('.row').show();
                            $("#detail_agama").closest('.row').show();
                            $("#detail_status_nikah").closest('.row').show();
                            $("#detail_pekerjaan").closest('.row').show();
                            $("#detail_alamat").closest('.row').show();
                            $("#detail_alamat_dom").closest('.row').show();
                            $("#detail_keperluan").closest('.row').show();
                            break;
                        case "SURAT KETERANGAN BELUM MENIKAH":
                            $("#detail_jenis_surat").closest('.row').show();
                            $("#detail_nama").closest('.row').show();
                            $("#detail_nik").closest('.row').show();
                            $("#detail_ttl").closest('.row').show();
                            $("#detail_status_nikah").closest('.row').show();
                            $("#detail_agama").closest('.row').show();
                            $("#detail_pekerjaan").closest('.row').show();
                            $("#detail_alamat").closest('.row').show();
                            $("#detail_keperluan").closest('.row').show();
                            break;
                        case "SURAT KETERANGAN USAHA":
                            $("#detail_jenis_surat").closest('.row').show();
                            $("#detail_nama").closest('.row').show();
                            $("#detail_nik").closest('.row').show();
                            $("#detail_ttl").closest('.row').show();
                            $("#detail_status_nikah").closest('.row').show();
                            $("#detail_agama").closest('.row').show();
                            $("#detail_pekerjaan").closest('.row').show();
                            $("#detail_alamat").closest('.row').show();
                            $("#detail_usaha").closest('.row').show();
                            $("#detail_keperluan").closest('.row').show();
                            break;
                        case "SURAT KETERANGAN TIDAK MAMPU":
                            $("#detail_jenis_surat").closest('.row').show();
                            $("#detail_nama").closest('.row').show();
                            $("#detail_nik").closest('.row').show();
                            $("#detail_ttl").closest('.row').show();
                            $("#detail_agama").closest('.row').show();
                            $("#detail_pekerjaan").closest('.row').show();
                            $("#detail_alamat").closest('.row').show();
                            $("#detail_keperluan").closest('.row').show();
                            break;
                        default:
                    }
                    $('#modalDetail').modal('show');
                }
            }, 
        });
    });

    // // MODAL DETAIL DATA 1
    // $('#detail_sk_usaha').on('show.bs.modal', function (event) {
    //     var button = $(event.relatedTarget);
    //     var id = button.data('bs-id');
    //     $.ajax({
    //         url: '{{ route("detail_sk_usaha") }}',
    //         type: 'POST',
    //         data: {
    //             id: button.data('bs-id'),
    //             _token: '{{ csrf_token() }}',
    //         },
    //         dataType: 'JSON',
    //         success: function(response) {
    //             if (response.status == 'success') {
    //                 var sk_usaha = response.sk_usaha;
    //                 $("#detail_jenis_surat").html(sk_usaha.jenis_surat);
    //                 $("#detail_nama").html(sk_usaha.nama);
    //                 $("#detail_nik").html(sk_usaha.nik);
    //                 $("#detail_ttl").html(sk_usaha.ttl);
    //                 $("#detail_status_nikah").html(sk_usaha.status_nikah);
    //                 $("#detail_agama").html(sk_usaha.agama);
    //                 $("#detail_pekerjaan").html(sk_usaha.pekerjaan);
    //                 $("#detail_alamat").html(sk_usaha.alamat);
    //                 $("#detail_usaha").html(sk_usaha.usaha);
    //                 $("#detail_keperluan").html(sk_usaha.keperluan);
    //                 $("#detail_tanggal").html(sk_usaha.tanggal);
    //             }
    //         }, 
    //     });
    // });

    // // MODAL DETAIL DATA 2
    // $('#detail_sk_usaha').on('show.bs.modal', function (event) {
    //     var button = $(event.relatedTarget);
    //     $.ajax({
    //         url: '{{ route("detail_sk_usaha") }}',
    //         type: 'POST',
    //         data: {
    //             id: button.data('bs-id'),
    //             _token: '{{ csrf_token() }}',
    //         },
    //         dataType: 'JSON',
    //         success: function(response) {
    //             if (response.status == 'success') {
    //                 var sk_usaha = response.sk_usaha;
    //                     $("#detail_jenis_surat").closest('.row').show();
    //                     $("#detail_nama").closest('.row').show();
    //                     $("#detail_nik").closest('.row').show();
    //                     $("#detail_ttl").closest('.row').show();
    //                     $("#detail_status_nikah").closest('.row').show();
    //                     $("#detail_agama").closest('.row').show();
    //                     $("#detail_pekerjaan").closest('.row').show();
    //                     $("#detail_alamat").closest('.row').show();
    //                     $("#detail_usaha").closest('.row').show();
    //                     $("#detail_keperluan").closest('.row').show();
    //                     $("#detail_tanggal").closest('.row').show();
    //                 }
    //                 $('#detail_sk_usaha').modal('show');
    //             }
    //         }), 
    //     });
    // </script>
@endsection