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
                                        <th class="col-md-2 text-center align-middle">NAMA</th>                           
                                        <th class="col-md-1 text-center align-middle">STATUS</th>                           
                                        <th class="col-md-3 text-center align-middle">AKSI</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach(\App\Models\SKUsaha::where('status_surat', 'Diproses')->get() as $sk_usaha)
                                        <tr>
                                            <td class="text-center align-middle">{{ $sk_usaha->tanggal }}</td>
                                            <td class="text-center align-middle">{{ $sk_usaha->sk_usaha_ibfk_4->nama_jenis_surat }}</td>
                                            <td class="text-center align-middle">{{ $sk_usaha->nik }}</td>
                                            <td class="text-center align-middle">{{ $sk_usaha->nama }}</td>
                                            <td class="text-center align-middle">{{ $sk_usaha->status_surat }}</td>
                                            <td class="text-center align-middle">
                                                <div class="d-flex justify-content-center flex-wrap">
                                                    <button type="button" data-bs-toggle="modal" data-bs-target="#detailSKU" data-bs-id="{{ $sk_usaha->id_sk_usaha }}" class="btn btn-primary btn-sm me-1">Detail</button>

                                                    <button class="btn-unduh-sku btn btn-warning btn-sm mx-1" data-id="{{ $sk_usaha->id_sk_usaha }}">Unduh</button>

                                                    <form method="POST" action="{{ route('sku_setuju', $sk_usaha->id_sk_usaha) }}" id="setuju-surat-{{ $sk_usaha->id_sk_usaha }}" class="d-inline">
                                                        @csrf
                                                        @method('PUT')
                                                        <button type="button" id="btnSetuju-{{ $sk_usaha->id_sk_usaha }}" class="btn btn-success btn-sm mx-1">Setuju</button>
                                                    </form>

                                                    <form method="POST" action="{{ route('sku_tolak', $sk_usaha->id_sk_usaha) }}" id="tolak-surat-{{ $sk_usaha->id_sk_usaha }}" class="d-inline">
                                                        @csrf
                                                        @method('PUT')
                                                        <button type="button" id="btnTolak-{{ $sk_usaha->id_sk_usaha }}" class="btn btn-danger btn-sm mx-1">Tolak</button>
                                                    </form> 
                                                </div>
                                                <script>
                                                    $(document).ready(function() {
                                                        // BUTTON UNDUH
                                                        $('.btn-unduh-sku').on('click', function () {
                                                            var sku_id = $(this).data('id');
                                                            var penandaTangan = {{ \App\Models\Jabatan::where('peran', 'Penanda Tangan')->exists() ? 'true' : 'false' }};
                                                            
                                                            if (!penandaTangan) {
                                                                Swal.fire({
                                                                    icon: "error",
                                                                    title: "Unduh Gagal",
                                                                    text: "Peran Penanda Tangan belum dipilih!",
                                                                });
                                                                return;
                                                            }

                                                            var url = "{{ route('unduh_sku', ['id_sk_usaha' => 'SKU_ID']) }}";
                                                            url = url.replace('SKU_ID', sku_id);
                                                            window.open(url, '_blank');
                                                        });

                                                        // BUTTON SETUJU
                                                        $('#btnSetuju-{{ $sk_usaha->id_sk_usaha }}').click(function(event){
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
                                                        $('#btnTolak-{{ $sk_usaha->id_sk_usaha }}').click(function(event) {
                                                            event.preventDefault();
                                                            Swal.fire({
                                                                icon: "info",
                                                                title: "Tolak Surat",
                                                                text: "Apakah Anda yakin ingin menolak surat ini?",
                                                                input: 'textarea',
                                                                inputPlaceholder: 'Masukkan pesan penolakan jika surat akan ditolak',
                                                                inputAttributes: {
                                                                    'aria-label': 'Masukkan pesan penolakan',
                                                                    'required': 'required'
                                                                },
                                                                inputValidator: (value) => {
                                                                    if (!value) {
                                                                        return 'Anda harus memasukkan pesan penolakan!' 
                                                                    }
                                                                },
                                                                showCancelButton: true,
                                                                confirmButtonText: "Tolak",
                                                                cancelButtonText: "Kembali",
                                                            }).then((result) => {
                                                                if (result.isConfirmed) {
                                                                    var pesan = result.value; 
                                                                    $('#tolak-surat-{{ $sk_usaha->id_sk_usaha }}')
                                                                        .append('<input type="hidden" name="aksi" value="tolak">')
                                                                        .append('<input type="hidden" name="alasan_tolak" value="' + pesan + '">')
                                                                        .submit();
                                                                }
                                                            });
                                                        });
                                                    });
                                                </script>
                                            </td>
                                        </tr>
                                    @endforeach

                                    @foreach(\App\Models\SKBelumMenikah::where('status_surat', 'Diproses')->get() as $skbm)
                                        <tr>
                                            <td class="text-center align-middle">{{ $skbm->tanggal }}</td>
                                            <td class="text-center align-middle">{{ $skbm->sk_belum_menikah_ibfk_4->nama_jenis_surat }}</td>
                                            <td class="text-center align-middle">{{ $skbm->nik }}</td>
                                            <td class="text-center align-middle">{{ $skbm->nama }}</td>
                                            <td class="text-center align-middle">{{ $skbm->status_surat }}</td>
                                            <td class="text-center align-middle">
                                                <div class="d-flex justify-content-center flex-wrap">
                                                    <button type="button" data-bs-toggle="modal" data-bs-target="#detailSKBM" data-bs-id="{{ $skbm->id_sk_belum_menikah }}" class="btn btn-primary btn-sm me-1">Detail</button>

                                                    <button class="btn-unduh-skbm btn btn-warning btn-sm mx-1" data-id="{{ $skbm->id_sk_belum_menikah }}" style="margin-right: 10px;">Unduh</button>

                                                    <form method="POST" action="{{ route('skbm_setuju', $skbm->id_sk_belum_menikah) }}" id="setuju-surat-{{ $skbm->id_sk_belum_menikah }}" class="d-inline">
                                                        @csrf
                                                        @method('PUT')
                                                        <button type="button" id="btnSetuju-{{ $skbm->id_sk_belum_menikah }}" class="btn btn-success btn-sm mx-1">Setuju</button>
                                                    </form>

                                                    <form method="POST" action="{{ route('skbm_tolak', $skbm->id_sk_belum_menikah) }}" id="tolak-surat-{{ $skbm->id_sk_belum_menikah }}" class="d-inline">
                                                        @csrf
                                                        @method('PUT')
                                                        <button type="button" id="btnTolak-{{ $skbm->id_sk_belum_menikah }}" class="btn btn-danger btn-sm mx-1">Tolak</button>
                                                    </form>
                                                </div>
                                                <script>
                                                    $(document).ready(function() {
                                                        // BUTTON UNDUH
                                                        $('.btn-unduh-skbm').on('click', function () {
                                                            var skbm_id = $(this).data('id');
                                                            var penandaTangan = {{ \App\Models\Jabatan::where('peran', 'Penanda Tangan')->exists() ? 'true' : 'false' }};
                                                            
                                                            if (!penandaTangan) {
                                                                Swal.fire({
                                                                    icon: "error",
                                                                    title: "Unduh Gagal",
                                                                    text: "Peran Penanda Tangan belum dipilih!",
                                                                });
                                                                return;
                                                            }

                                                            var url = "{{ route('unduh_skbm', ['id_sk_belum_menikah' => 'SKBM_ID']) }}";
                                                            url = url.replace('SKBM_ID', skbm_id);
                                                            window.open(url, '_blank');
                                                        });

                                                        // BUTTON SETUJU
                                                        $('#btnSetuju-{{ $skbm->id_sk_belum_menikah }}').click(function(event){
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
                                                                    $('#setuju-surat-{{ $skbm->id_sk_belum_menikah}}').submit();
                                                                }
                                                            });
                                                        });

                                                        // BUTTON TOLAK
                                                        $('#btnTolak-{{ $skbm->id_sk_belum_menikah }}').click(function(event) {
                                                            event.preventDefault();
                                                            Swal.fire({
                                                                icon: "info",
                                                                title: "Tolak Surat",
                                                                text: "Apakah Anda yakin ingin menolak surat ini?",
                                                                input: 'textarea',
                                                                inputPlaceholder: 'Masukkan pesan penolakan jika surat akan ditolak',
                                                                inputAttributes: {
                                                                    'aria-label': 'Masukkan pesan penolakan',
                                                                    'required': 'required'
                                                                },
                                                                inputValidator: (value) => {
                                                                    if (!value) {
                                                                        return 'Anda harus memasukkan pesan penolakan!' 
                                                                    }
                                                                },
                                                                showCancelButton: true,
                                                                confirmButtonText: "Tolak",
                                                                cancelButtonText: "Kembali",
                                                            }).then((result) => {
                                                                if (result.isConfirmed) {
                                                                    var pesan = result.value; 
                                                                    $('#tolak-surat-{{ $skbm->id_sk_belum_menikah }}')
                                                                        .append('<input type="hidden" name="aksi" value="tolak">')
                                                                        .append('<input type="hidden" name="alasan_tolak" value="' + pesan + '">')
                                                                        .submit();
                                                                }
                                                            });
                                                        });
                                                    });
                                                </script>
                                            </td>
                                        </tr>
                                    @endforeach

                                    @foreach(\App\Models\SKDomisili::where('status_surat', 'Diproses')->get() as $skd)
                                        <tr>
                                            <td class="text-center align-middle">{{ $skd->tanggal }}</td>
                                            <td class="text-center align-middle">{{ $skd->sk_domisili_ibfk_3->nama_jenis_surat }}</td>
                                            <td class="text-center align-middle">{{ $skd->nik }}</td>
                                            <td class="text-center align-middle">{{ $skd->nama }}</td>
                                            <td class="text-center align-middle">{{ $skd->status_surat }}</td>
                                            <td class="text-center align-middle">
                                                <div class="d-flex justify-content-center flex-wrap">
                                                    <button type="button" data-bs-toggle="modal" data-bs-target="#detailSKD" data-bs-id="{{ $skd->id_sk_domisili }}" class="btn btn-primary btn-sm me-1">Detail</button>

                                                    <button class="btn-unduh-skd btn btn-warning btn-sm mx-1" data-id="{{ $skd->id_sk_domisili }}" style="margin-right: 10px;">Unduh</button>

                                                    <form method="POST" action="{{ route('skd_setuju', $skd->id_sk_domisili) }}" id="setuju-surat-{{ $skd->id_sk_domisili }}" class="d-inline">
                                                        @csrf
                                                        @method('PUT')
                                                        <button type="button" id="btnSetuju-{{ $skd->id_sk_domisili }}" class="btn btn-success btn-sm mx-1">Setuju</button>
                                                    </form>
                                                    
                                                    <form method="POST" action="{{ route('skd_tolak', $skd->id_sk_domisili) }}" id="tolak-surat-{{ $skd->id_sk_domisili }}" class="d-inline">
                                                        @csrf
                                                        @method('PUT')
                                                        <button type="button" id="btnTolak-{{ $skd->id_sk_domisili }}" class="btn btn-danger btn-sm mx-1">Tolak</button>
                                                    </form>
                                                </div>
                                                <script>
                                                    $(document).ready(function() {
                                                        // BUTTON UNDUH
                                                        $('.btn-unduh-skd').on('click', function () {
                                                            var skd_id = $(this).data('id');
                                                            var penandaTangan = {{ \App\Models\Jabatan::where('peran', 'Penanda Tangan')->exists() ? 'true' : 'false' }};
                                                            
                                                            if (!penandaTangan) {
                                                                Swal.fire({
                                                                    icon: "error",
                                                                    title: "Unduh Gagal",
                                                                    text: "Peran Penanda Tangan belum dipilih!",
                                                                });
                                                                return;
                                                            }

                                                            var url = "{{ route('unduh_skd', ['id_sk_domisili' => 'SKD_ID']) }}";
                                                            url = url.replace('SKD_ID', skd_id);
                                                            window.open(url, '_blank');
                                                        });

                                                        // BUTTON SETUJU
                                                        $('#btnSetuju-{{ $skd->id_sk_domisili }}').click(function(event){
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
                                                                    $('#setuju-surat-{{ $skd->id_sk_domisili}}').submit();
                                                                }
                                                            });
                                                        });

                                                        // BUTTON TOLAK
                                                        $('#btnTolak-{{ $skd->id_sk_domisili }}').click(function(event) {
                                                            event.preventDefault();
                                                            Swal.fire({
                                                                icon: "info",
                                                                title: "Tolak Surat",
                                                                text: "Apakah Anda yakin ingin menolak surat ini?",
                                                                input: 'textarea',
                                                                inputPlaceholder: 'Masukkan pesan penolakan jika surat akan ditolak',
                                                                inputAttributes: {
                                                                    'aria-label': 'Masukkan pesan penolakan',
                                                                    'required': 'required'
                                                                },
                                                                inputValidator: (value) => {
                                                                    if (!value) {
                                                                        return 'Anda harus memasukkan pesan penolakan!' 
                                                                    }
                                                                },
                                                                showCancelButton: true,
                                                                confirmButtonText: "Tolak",
                                                                cancelButtonText: "Kembali",
                                                            }).then((result) => {
                                                                if (result.isConfirmed) {
                                                                    var pesan = result.value; 
                                                                    $('#tolak-surat-{{ $skd->id_sk_domisili }}')
                                                                        .append('<input type="hidden" name="aksi" value="tolak">')
                                                                        .append('<input type="hidden" name="alasan_tolak" value="' + pesan + '">')
                                                                        .submit();
                                                                }
                                                            });
                                                        });
                                                    });
                                                </script>
                                            </td>
                                        </tr>
                                    @endforeach

                                    @foreach(\App\Models\SKTidakMampu::where('status_surat', 'Diproses')->get() as $sktm)
                                        <tr>
                                            <td class="text-center align-middle">{{ $sktm->tanggal }}</td>
                                            <td class="text-center align-middle">{{ $sktm->sk_tidak_mampu_ibfk_1->nama_jenis_surat }}</td>
                                            <td class="text-center align-middle">{{ $sktm->nik }}</td>
                                            <td class="text-center align-middle">{{ $sktm->nama }}</td>
                                            <td class="text-center align-middle">{{ $sktm->status_surat }}</td>
                                            <td class="text-center align-middle">
                                                <div class="d-flex justify-content-center flex-wrap">
                                                    <button type="button" data-bs-toggle="modal" data-bs-target="#detailSKTM" data-bs-id="{{ $sktm->id_sk_tidak_mampu }}" class="btn btn-primary btn-sm me-1">Detail</button>

                                                    <button class="btn-unduh-sktm btn btn-warning btn-sm mx-1" data-id="{{ $sktm->id_sk_tidak_mampu }}" style="margin-right: 10px;">Unduh</button>

                                                    <form method="POST" action="{{ route('sktm_setuju', $sktm->id_sk_tidak_mampu) }}" id="setuju-surat-{{ $sktm->id_sk_tidak_mampu }}" class="d-inline">
                                                        @csrf
                                                        @method('PUT')
                                                        <button type="button" id="btnSetuju-{{ $sktm->id_sk_tidak_mampu }}" class="btn btn-success btn-sm mx-1">Setuju</button>
                                                    </form>
                                                    
                                                    <form method="POST" action="{{ route('sktm_tolak', $sktm->id_sk_tidak_mampu) }}" id="tolak-surat-{{ $sktm->id_sk_tidak_mampu }}" class="d-inline">
                                                        @csrf
                                                        @method('PUT')
                                                        <button type="button" id="btnTolak-{{ $sktm->id_sk_tidak_mampu }}" class="btn btn-danger btn-sm mx-1">Tolak</button>
                                                    </form>
                                                </div>
                                                <script>
                                                    $(document).ready(function() {
                                                        // BUTTON UNDUH
                                                        $('.btn-unduh-sktm').on('click', function () {
                                                            var sktm_id = $(this).data('id');
                                                            var penandaTangan = {{ \App\Models\Jabatan::where('peran', 'Penanda Tangan')->exists() ? 'true' : 'false' }};
                                                            
                                                            if (!penandaTangan) {
                                                                Swal.fire({
                                                                    icon: "error",
                                                                    title: "Unduh Gagal",
                                                                    text: "Peran Penanda Tangan belum dipilih!",
                                                                });
                                                                return;
                                                            }

                                                            var url = "{{ route('unduh_sktm', ['id_sk_tidak_mampu' => 'SKTM_ID']) }}";
                                                            url = url.replace('SKTM_ID', sktm_id);
                                                            window.open(url, '_blank');
                                                        });

                                                        // BUTTON SETUJU
                                                        $('#btnSetuju-{{ $sktm->id_sk_tidak_mampu }}').click(function(event){
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
                                                                    $('#setuju-surat-{{ $sktm->id_sk_tidak_mampu }}').submit();
                                                                }
                                                            });
                                                        });

                                                        // BUTTON TOLAK
                                                        $('#btnTolak-{{ $sktm->id_sk_tidak_mampu }}').click(function(event) {
                                                            event.preventDefault();
                                                            Swal.fire({
                                                                icon: "info",
                                                                title: "Tolak Surat",
                                                                text: "Apakah Anda yakin ingin menolak surat ini?",
                                                                input: 'textarea',
                                                                inputPlaceholder: 'Masukkan pesan penolakan jika surat akan ditolak',
                                                                inputAttributes: {
                                                                    'aria-label': 'Masukkan pesan penolakan',
                                                                    'required': 'required'
                                                                },
                                                                inputValidator: (value) => {
                                                                    if (!value) {
                                                                        return 'Anda harus memasukkan pesan penolakan!' 
                                                                    }
                                                                },
                                                                showCancelButton: true,
                                                                confirmButtonText: "Tolak",
                                                                cancelButtonText: "Kembali",
                                                            }).then((result) => {
                                                                if (result.isConfirmed) {
                                                                    var pesan = result.value; 
                                                                    $('#tolak-surat-{{ $sktm->id_sk_tidak_mampu }}')
                                                                        .append('<input type="hidden" name="aksi" value="tolak">')
                                                                        .append('<input type="hidden" name="alasan_tolak" value="' + pesan + '">')
                                                                        .submit();
                                                                }
                                                            });
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
    {{-- DETAIL SKU --}}
    <div class="modal fade" id="detailSKU" tabindex="-1" aria-hidden="true" data-bs-backdrop="static">
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
    <div class="modal fade" id="detailSKBM" tabindex="-1" aria-hidden="true" data-bs-backdrop="static">
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
                        <label class="col-md-2 col-form-label">TEMPAT, TANGGAL LAHIR</label>
                        <div class="col-md-9 d-flex align-items-center">
                            <span>:&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<label class="form-label" id="detail_ttl_3"></label></span>
                        </div>
                    </div>
                    <div class="row mb-1">
                        <label class="col-md-2 col-form-label">STATUS NIKAH</label>
                        <div class="col-md-9 d-flex align-items-center">
                            <span>:&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<label class="form-label" id="detail_status_nikah_3"></label></span>
                        </div>
                    </div>
                    <div class="row mb-1">
                        <label class="col-md-2 col-form-label">AGAMA</label>
                        <div class="col-md-9 d-flex align-items-center">
                            <span>:&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<label class="form-label" id="detail_agama_3"></label></span>
                        </div>
                    </div>
                    <div class="row mb-1">
                        <label class="col-md-2 col-form-label">PEKERJAAN</label>
                        <div class="col-md-9 d-flex align-items-center">
                            <span>:&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<label class="form-label" id="detail_pekerjaan_3"></label></span>
                        </div>
                    </div>
                    <div class="row mb-1">
                        <label class="col-md-2 col-form-label">ALAMAT</label>
                        <div class="col-md-9 d-flex align-items-center">
                            <span>:&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<label class="form-label" id="detail_alamat_3"></label></span>
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
                                    <li id="suket" class="row align-items-center mb-2">
                                        <div class="col-md-6">
                                            <label class="form-label mb-0">Surat Pengantar RT/RW</label>
                                        </div>
                                        <div class="col-md-6">
                                            <a id="detail_bukti_suket_3" class="btn btn-primary btn-sm w-100" href="#" target="_blank">Unduh</a>
                                        </div>
                                    </li>
                                    <li id="kk" class="row align-items-center mb-2">
                                        <div class="col-md-6">
                                            <label class="form-label mb-0">Kartu Keluarga (KK)</label>
                                        </div>
                                        <div class="col-md-6">
                                            <a id="detail_bukti_kk_3" class="btn btn-primary btn-sm w-100" href="#" target="_blank">Unduh</a>
                                        </div>
                                    </li>
                                    <li id="ktp" class="row align-items-center mb-2">
                                        <div class="col-md-6">
                                            <label class="form-label mb-0">Kartu Tanda Penduduk (KTP)</label>
                                        </div>
                                        <div class="col-md-6">
                                            <a id="detail_bukti_ktp_3" class="btn btn-primary btn-sm w-100" href="#" target="_blank">Unduh</a>
                                        </div>
                                    </li>
                                    <li id="akta_cerai" class="row align-items-center mb-2">
                                        <div class="col-md-6">
                                            <label class="form-label mb-0">Akta Cerai</label>
                                        </div>
                                        <div class="col-md-6">
                                            <a id="detail_bukti_cerai_3" class="btn btn-primary btn-sm w-100" href="#" target="_blank">Unduh</a>
                                        </div>
                                    </li>
                                    <li id="akta_kematian" class="row align-items-center mb-2">
                                        <div class="col-md-6">
                                            <label class="form-label mb-0">Akta Kematian</label>
                                        </div>
                                        <div class="col-md-6">
                                            <a id="detail_bukti_kematian_3" class="btn btn-primary btn-sm w-100" href="#" target="_blank">Unduh</a>
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
    <div class="modal fade" id="detailSKD" tabindex="-1" aria-hidden="true" data-bs-backdrop="static">
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
                        <label class="col-md-2 col-form-label">JENIS KELAMIN</label>
                        <div class="col-md-9 d-flex align-items-center">
                            <span>:&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<label class="form-label" id="detail_jenis_kelamin_2"></label></span>
                        </div>
                    </div>
                    <div class="row mb-1">
                        <label class="col-md-2 col-form-label">TEMPAT, TANGGAL LAHIR</label>
                        <div class="col-md-9 d-flex align-items-center">
                            <span>:&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<label class="form-label" id="detail_ttl_2"></label></span>
                        </div>
                    </div>
                    <div class="row mb-1">
                        <label class="col-md-2 col-form-label">AGAMA</label>
                        <div class="col-md-9 d-flex align-items-center">
                            <span>:&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<label class="form-label" id="detail_agama_2"></label></span>
                        </div>
                    </div>
                    <div class="row mb-1">
                        <label class="col-md-2 col-form-label">STATUS NIKAH</label>
                        <div class="col-md-9 d-flex align-items-center">
                            <span>:&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<label class="form-label" id="detail_status_nikah_2"></label></span>
                        </div>
                    </div>
                    <div class="row mb-1">
                        <label class="col-md-2 col-form-label">PEKERJAAN</label>
                        <div class="col-md-9 d-flex align-items-center">
                            <span>:&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<label class="form-label" id="detail_pekerjaan_2"></label></span>
                        </div>
                    </div>
                    <div class="row mb-1">
                        <label class="col-md-2 col-form-label">ALAMAT KTP</label>
                        <div class="col-md-9 d-flex align-items-center">
                            <span>:&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<label class="form-label" id="detail_alamat_2"></label></span>
                        </div>
                    </div>
                    <div class="row mb-1">
                        <label class="col-md-2 col-form-label">ALAMAT DOMISILI</label>
                        <div class="col-md-9 d-flex align-items-center">
                            <span>:&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<label class="form-label" id="detail_alamat_dom_2"></label></span>
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
                                    <li class="row align-items-center mb-1">
                                        <div class="col-md-6">
                                            <label class="form-label mb-0">Surat Pengantar RT/RW</label>
                                        </div>
                                        <div class="col-md-6">
                                            <a id="detail_bukti_suket_2" class="btn btn-primary btn-sm w-100" href="#" target="_blank">Unduh</a>
                                        </div>
                                    </li>
                                    <li class="row align-items-center mb-1">
                                        <div class="col-md-6">
                                            <label class="form-label mb-0">Kartu Keluarga (KK)</label>
                                        </div>
                                        <div class="col-md-6">
                                            <a id="detail_bukti_kk_2" class="btn btn-primary btn-sm w-100" href="#" target="_blank">Unduh</a>
                                        </div>
                                    </li>
                                    <li class="row align-items-center">
                                        <div class="col-md-6">
                                            <label class="form-label mb-0">Kartu Tanda Penduduk (KTP)</label>
                                        </div>
                                        <div class="col-md-6">
                                            <a id="detail_bukti_ktp_2" class="btn btn-primary btn-sm w-100" href="#" target="_blank">Unduh</a>
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
    <div class="modal fade" id="detailSKTM" tabindex="-1" aria-hidden="true" data-bs-backdrop="static">
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

            // $('#jenis_surat_filter').on('change', function() {
            //     var jenis_surat_id = $(this).val();
            //     $('#selected_jenis_surat').val(jenis_surat_id); // Set nilai input tersembunyi dengan nilai jenis surat yang dipilih
            //     // Mengaplikasikan filter ke kolom 'JENIS SURAT'
            //     table.column(1).search(jenis_surat_id).draw();
            // });
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
                        $("#detail_jenis_surat").html(response.jenis_surat);
                        $("#detail_nama").html(surat.nama);
                        $("#detail_nik").html(surat.nik);
                        $("#detail_ttl").html(surat.ttl);
                        $("#detail_status_nikah").html(response.status_nikah);                        
                        $("#detail_agama").html(response.agama);
                        $("#detail_pekerjaan").html(response.pekerjaan);
                        $("#detail_alamat").html(surat.alamat);
                        $("#detail_usaha").html(surat.usaha);
                        $("#detail_keperluan").html(surat.keperluan);
                        $("#detail_bukti_suket").attr("href", '/bukti_dokumen/SKU/' + surat.bukti_suket);
                        $("#detail_bukti_kk").attr("href", '/bukti_dokumen/SKU/' + surat.bukti_kk);
                        $("#detail_bukti_ktp").attr("href", '/bukti_dokumen/SKU/' + surat.bukti_ktp);

                        if (response.pekerjaan === 'Lainnya') {
                            $("#detail_pekerjaan").html(response.pekerjaan_lainnya);
                            $("#pekerjaan_lainnya_row").show();
                        } else {
                            $("#detail_pekerjaan").html(response.pekerjaan);
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
                        $("#detail_jenis_surat_3").html(response.jenis_surat);
                        $("#detail_nama_3").html(surat.nama);
                        $("#detail_nik_3").html(surat.nik);
                        $("#detail_ttl_3").html(surat.ttl);
                        $("#detail_status_nikah_3").html(response.status_nikah);
                        $("#detail_agama_3").html(response.agama);
                        $("#detail_pekerjaan_3").html(response.pekerjaan);
                        $("#detail_alamat_3").html(surat.alamat);
                        $("#detail_keperluan_3").html(surat.keperluan);
                        $("#detail_bukti_suket_3").attr("href", '/bukti_dokumen/SKBM/' + surat.bukti_suket);
                        $("#detail_bukti_kk_3").attr("href", '/bukti_dokumen/SKBM/' + surat.bukti_kk);
                        $("#detail_bukti_ktp_3").attr("href", '/bukti_dokumen/SKBM/' + surat.bukti_ktp);
                        $("#detail_bukti_cerai_3").attr("href", '/bukti_dokumen/SKBM/' + surat.bukti_cerai);
                        $("#detail_bukti_kematian_3").attr("href", '/bukti_dokumen/SKBM/' + surat.bukti_kematian);

                        if (response.pekerjaan === 'Lainnya') {
                            $("#detail_pekerjaan_3").html(response.pekerjaan_lainnya);
                            $("#pekerjaan_lainnya_3_row").show();
                        } else {
                            $("#detail_pekerjaan_3").html(response.pekerjaan);
                            $("#pekerjaan_lainnya_3_row").hide();
                        }

                        $("#suket").show();
                        $("#kk").show();
                        $("#ktp").show();
                        $("#akta_cerai").hide();
                        $("#akta_kematian").hide();

                        if (response.status_nikah === 'Belum Kawin') {
                            $("#akta_cerai").hide();
                            $("#akta_kematian").hide();
                        } else if (response.status_nikah === 'Cerai Hidup') {
                            $("#akta_cerai").show();
                            $("#akta_kematian").hide();
                        } else if (response.status_nikah === 'Cerai Mati') {
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
                        $("#detail_jenis_surat_2").html(response.jenis_surat);
                        $("#detail_nama_2").html(surat.nama);
                        $("#detail_nik_2").html(surat.nik);
                        $("#detail_jenis_kelamin_2").html(response.jenis_kelamin);
                        $("#detail_ttl_2").html(surat.ttl);
                        $("#detail_agama_2").html(response.agama);
                        $("#detail_pekerjaan_2").html(response.pekerjaan);
                        $("#detail_status_nikah_2").html(response.status_nikah);
                        $("#detail_alamat_2").html(surat.alamat);
                        $("#detail_alamat_dom_2").html(surat.alamat_dom);
                        $("#detail_keperluan_2").html(surat.keperluan);
                        $("#detail_bukti_suket_2").attr("href", '/bukti_dokumen/SKD/' + surat.bukti_suket);
                        $("#detail_bukti_kk_2").attr("href", '/bukti_dokumen/SKD/' + surat.bukti_kk);
                        $("#detail_bukti_ktp_2").attr("href", '/bukti_dokumen/SKD/' + surat.bukti_ktp);

                        if (response.pekerjaan === 'Lainnya') {
                            $("#detail_pekerjaan_2").html(response.pekerjaan_lainnya);
                            $("#pekerjaan_lainnya_2_row").show();
                        } else {
                            $("#detail_pekerjaan_2").html(response.pekerjaan);
                            $("#pekerjaan_lainnya_2_row").hide();
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
                        $("#detail_jenis_surat_4").html(response.jenis_surat);
                        $("#detail_nama_4").html(surat.nama);
                        $("#detail_nik_4").html(surat.nik);
                        $("#detail_ttl_4").html(surat.ttl);
                        $("#detail_agama_4").html(response.agama);
                        $("#detail_pekerjaan_4").html(response.pekerjaan);
                        $("#detail_alamat_4").html(surat.alamat);
                        $("#detail_keperluan_4").html(surat.keperluan);
                        $("#detail_bukti_suket_4").attr("href", '/bukti_dokumen/SKTM/' + surat.bukti_suket);
                        $("#detail_bukti_kk_4").attr("href", '/bukti_dokumen/SKTM/' + surat.bukti_kk);
                        $("#detail_bukti_ktp_4").attr("href", '/bukti_dokumen/SKTM/' + surat.bukti_ktp);

                        if (response.pekerjaan === 'Lainnya') {
                            $("#detail_pekerjaan_4").html(response.pekerjaan_lainnya);
                            $("#pekerjaan_lainnya_4_row").show();
                        } else {
                            $("#detail_pekerjaan_4").html(response.pekerjaan);
                            $("#pekerjaan_lainnya_4_row").hide();
                        }
                    }
                },
            });
        });
    </script>
@endsection