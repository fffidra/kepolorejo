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
                            <h5>DATA SURAT DISETUJUI</h5>
                        </div>
                        <div class="container-fluid table-responsive px-3 py-3">
                            <table class="table table-striped" id="tabelSPT" style="width:100%">
                                <thead>
                                    <tr>
                                        <th class="col-md-1 text-center align-middle">TANGGAL PENGAJUAN</th>                           
                                        <th class="col-md-2 text-center align-middle">JENIS SURAT</th>                           
                                        <th class="col-md-2 text-center align-middle">NIK</th>                           
                                        <th class="col-md-2 text-center align-middle">NAMA</th>                           
                                        <th class="col-md-1 text-center align-middle">STATUS</th>                           
                                        <th class="col-md-2 text-center align-middle">VERIFIKATOR</th>                           
                                        <th class="col-md-1 text-center align-middle">AKSI</th>
                                        <th class="col-md-1 text-center align-middle">FILE SURAT</th>                           
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach(\App\Models\SKUsaha::where('status_surat', '=', 'Disetujui')->get() as $sk_usaha)
                                        <tr>
                                            <td class="text-center align-middle">{{ $sk_usaha->tanggal }}</td>
                                            <td class="text-center align-middle">{{ $sk_usaha->sk_usaha_ibfk_4->nama_jenis_surat }}</td>
                                            <td class="text-center align-middle">{{ $sk_usaha->nik }}</td>
                                            <td class="text-center align-middle">{{ $sk_usaha->nama }}</td>
                                            <td class="text-center align-middle">{{ $sk_usaha->status_surat }}</td>
                                            <td class="text-center align-middle">{{ $sk_usaha->verifikator }}</td>
                                            <td class="text-center align-middle">
                                                <div class="d-flex justify-content-center">
                                                    <button type="button" data-bs-toggle="modal" data-bs-target="#upload_sku" data-bs-id="{{ $sk_usaha->id_sk_usaha }}" class="btn btn-info btn-sm me-2">Upload</button>

                                                    <form method="POST" action="{{ route('sku_selesai', $sk_usaha->id_sk_usaha) }}" id="selesai-surat-{{ $sk_usaha->id_sk_usaha }}">
                                                        @csrf
                                                        @method('PUT')
                                                        <button type="button" id="btnSelesai-{{ $sk_usaha->id_sk_usaha }}" class="btn btn-warning btn-sm">Selesai</button>
                                                    </form>
                                                </div>
                                                <script>
                                                    // BUTTON SELESAI
                                                    $('#btnSelesai-{{ $sk_usaha->id_sk_usaha  }}').click(function(event){
                                                        event.preventDefault();
                                                        Swal.fire({
                                                            icon: "info",
                                                            title: "Konfirmasi",
                                                            text: "Apakah Anda yakin ingin menyelesaikan surat ini?",
                                                            showCancelButton: true,
                                                            confirmButtonText: "Ya, Lanjutkan",
                                                            cancelButtonText: "Tidak, Batalkan",
                                                        }).then(function (result) {
                                                            if (result.isConfirmed) {
                                                                $('#selesai-surat-{{ $sk_usaha->id_sk_usaha  }}').submit();
                                                            }
                                                        });
                                                    });
                                                </script>
                                            </td>
                                            <td class="text-center align-middle">
                                                @if($sk_usaha->surat_selesai)
                                                    <a href="{{ asset('surat_selesai/SKU/' . $sk_usaha->surat_selesai) }}" class="btn btn-success btn-sm" target="_blank">Unduh</a>
                                                @else
                                                    <button type="button" class="btn btn-secondary btn-sm" disabled>Unduh</button>
                                                @endif
                                            </td>
                                        </tr>
                                    @endforeach

                                    @foreach(\App\Models\SKBelumMenikah::where('status_surat', '=', 'Disetujui')->get() as $skbm)
                                        <tr>
                                            <td class="text-center align-middle">{{ $skbm->tanggal }}</td>
                                            <td class="text-center align-middle">{{ $skbm->sk_belum_menikah_ibfk_4->nama_jenis_surat }}</td>
                                            <td class="text-center align-middle">{{ $skbm->nik }}</td>
                                            <td class="text-center align-middle">{{ $skbm->nama }}</td>
                                            <td class="text-center align-middle">{{ $skbm->status_surat }}</td>
                                            <td class="text-center align-middle">{{ $skbm->verifikator }}</td>
                                            <td class="text-center align-middle">
                                                <div class="d-flex justify-content-center">
                                                    <button type="button" data-bs-toggle="modal" data-bs-target="#upload_skbm" data-bs-id="{{ $skbm->id_sk_belum_menikah }}" class="btn btn-info btn-sm me-2">Upload</button>

                                                    <form method="POST" action="{{ route('skbm_selesai', $skbm->id_sk_belum_menikah) }}" id="selesai-surat-{{ $skbm->id_sk_belum_menikah }}">
                                                        @csrf
                                                        @method('PUT')
                                                        <button type="button" id="btnSelesai-{{ $skbm->id_sk_belum_menikah }}" class="btn btn-warning btn-sm">Selesai</button>
                                                    </form>
                                                </div>                                                
                                                <script>
                                                    // BUTTON SELESAI
                                                    $('#btnSelesai-{{ $skbm->id_sk_belum_menikah  }}').click(function(event){
                                                        event.preventDefault();
                                                        Swal.fire({
                                                            icon: "info",
                                                            title: "Konfirmasi",
                                                            text: "Apakah Anda yakin ingin menyelesaikan surat ini?",
                                                            showCancelButton: true,
                                                            confirmButtonText: "Ya, Lanjutkan",
                                                            cancelButtonText: "Tidak, Batalkan",
                                                        }).then(function (result) {
                                                            if (result.isConfirmed) {
                                                                $('#selesai-surat-{{ $skbm->id_sk_belum_menikah  }}').submit();
                                                            }
                                                        });
                                                    });
                                                </script>
                                            </td>
                                            <td class="text-center align-middle">
                                                @if($skbm->surat_selesai)
                                                    <a href="{{ asset('surat_selesai/SKBM/' . $skbm->surat_selesai) }}" class="btn btn-success btn-sm" target="_blank">Unduh</a>
                                                @else
                                                    <button type="button" class="btn btn-secondary btn-sm" disabled>Unduh</button>
                                                @endif
                                            </td>                                        
                                        </tr>
                                    @endforeach

                                    @foreach(\App\Models\SKDomisili::where('status_surat', '=', 'Disetujui')->get() as $skd)
                                        <tr>
                                            <td class="text-center align-middle">{{ $skd->tanggal }}</td>
                                            <td class="text-center align-middle">{{ $skd->sk_domisili_ibfk_3->nama_jenis_surat }}</td>
                                            <td class="text-center align-middle">{{ $skd->nik }}</td>
                                            <td class="text-center align-middle">{{ $skd->nama }}</td>
                                            <td class="text-center align-middle">{{ $skd->status_surat }}</td>
                                            <td class="text-center align-middle">{{ $skd->verifikator }}</td>
                                            <td class="text-center align-middle">
                                                <div class="d-flex justify-content-center">
                                                    <button type="button" data-bs-toggle="modal" data-bs-target="#upload_skd" data-bs-id="{{ $skd->id_sk_domisili }}" class="btn btn-info btn-sm me-2">Upload</button>
                                                                                                    
                                                    <form method="POST" action="{{ route('skd_selesai', $skd->id_sk_domisili) }}" id="selesai-surat-{{ $skd->id_sk_domisili }}">
                                                        @csrf
                                                        @method('PUT')
                                                        <button type="button" id="btnSelesai-{{ $skd->id_sk_domisili }}" class="btn btn-warning btn-sm">Selesai</button>
                                                    </form>
                                                </div>                                                
                                                <script>
                                                    // BUTTON SELESAI
                                                    $('#btnSelesai-{{ $skd->id_sk_domisili }}').click(function(event){
                                                        event.preventDefault();
                                                        Swal.fire({
                                                            icon: "info",
                                                            title: "Konfirmasi",
                                                            text: "Apakah Anda yakin ingin menyelesaikan surat ini?",
                                                            showCancelButton: true,
                                                            confirmButtonText: "Ya, Lanjutkan",
                                                            cancelButtonText: "Tidak, Batalkan",
                                                        }).then(function (result) {
                                                            if (result.isConfirmed) {
                                                                $('#selesai-surat-{{ $skd->id_sk_domisili }}').submit();
                                                            }
                                                        });
                                                    });
                                                </script>
                                            </td>
                                            <td class="text-center align-middle">
                                                @if($skd->surat_selesai)
                                                    <a href="{{ asset('surat_selesai/SKD/' . $skd->surat_selesai) }}" class="btn btn-success btn-sm" target="_blank">Unduh</a>
                                                @else
                                                    <button type="button" class="btn btn-secondary btn-sm" disabled>Unduh</button>
                                                @endif
                                            </td>
                                        </tr>
                                    @endforeach

                                    @foreach(\App\Models\SKTidakMampu::where('status_surat', '=', 'Disetujui')->get() as $sktm)
                                        <tr>
                                            <td class="text-center align-middle">{{ $sktm->tanggal }}</td>
                                            <td class="text-center align-middle">{{ $sktm->sk_tidak_mampu_ibfk_1->nama_jenis_surat }}</td>
                                            <td class="text-center align-middle">{{ $sktm->nik }}</td>
                                            <td class="text-center align-middle">{{ $sktm->nama }}</td>
                                            <td class="text-center align-middle">{{ $sktm->status_surat }}</td>
                                            <td class="text-center align-middle">{{ $sktm->verifikator }}</td>
                                            <td class="text-center align-middle">
                                                <div class="d-flex justify-content-center">
                                                    <button type="button" data-bs-toggle="modal" data-bs-target="#upload_sktm" data-bs-id="{{ $sktm->id_sk_tidak_mampu }}" class="btn btn-info btn-sm me-2">Upload</button>
                                                
                                                    <form method="POST" action="{{ route('sktm_selesai', $sktm->id_sk_tidak_mampu) }}" id="selesai-surat-{{ $sktm->id_sk_tidak_mampu }}">
                                                        @csrf
                                                        @method('PUT')
                                                        <button type="button" id="btnSelesai-{{ $sktm->id_sk_tidak_mampu }}" class="btn btn-warning btn-sm">Selesai</button>
                                                    </form>
                                                </div>
                                                <script>
                                                    // BUTTON SELESAI
                                                    $(document).ready(function() {
                                                        $('#btnSelesai-{{ $sktm->id_sk_tidak_mampu }}').click(function(event){
                                                            event.preventDefault();
                                                            Swal.fire({
                                                                icon: "info",
                                                                title: "Konfirmasi",
                                                                text: "Apakah Anda yakin ingin menyelesaikan surat ini?",
                                                                showCancelButton: true,
                                                                confirmButtonText: "Ya, Lanjutkan",
                                                                cancelButtonText: "Tidak, Batalkan",
                                                            }).then(function (result) {
                                                                if (result.isConfirmed) {
                                                                    $('#selesai-surat-{{ $sktm->id_sk_tidak_mampu }}').submit();
                                                                }
                                                            });
                                                        });
                                                    });
                                                </script>
                                            </td>
                                            <td class="text-center align-middle">
                                                @if($sktm->surat_selesai)
                                                    <a href="{{ asset('surat_selesai/SKTM/' . $sktm->surat_selesai) }}" class="btn btn-success btn-sm" target="_blank">Unduh</a>
                                                @else
                                                    <button type="button" class="btn btn-secondary btn-sm" disabled>Unduh</button>
                                                @endif
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
    {{-- UPLOAD SKU --}}
    <div class="modal fade" id="upload_sku" tabindex="-1" aria-labelledby="uploadSuratModalLabel" data-bs-backdrop="static">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="uploadSuratModalLabel">Upload Surat Keterangan Usaha</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <form action="{{ route('upload_sku') }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    <div class="modal-body">
                        <input type="hidden" name="id_sk_usaha" id="id_sk_usaha">
                        <div class="mb-3">
                            <label for="surat_selesai" class="form-label">Pilih File Surat</label>
                            <input type="file" class="form-control" name="surat_selesai" id="surat_selesai" required>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                        <button type="submit" class="btn btn-primary">Upload</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    {{-- UPLOAD SKBM --}}
    <div class="modal fade" id="upload_skbm" tabindex="-1" aria-labelledby="uploadSuratModalLabel" data-bs-backdrop="static">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="uploadSuratModalLabel">Upload Surat Keterangan Belum Menikah</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <form action="{{ route('upload_skbm') }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    <div class="modal-body">
                        <input type="hidden" name="id_sk_belum_menikah" id="id_sk_belum_menikah">
                        <div class="mb-3">
                            <label for="surat_selesai" class="form-label">Pilih File Surat</label>
                            <input type="file" class="form-control" name="surat_selesai" id="surat_selesai" required>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                        <button type="submit" class="btn btn-primary">Upload</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    {{-- UPLOAD SKD --}}
    <div class="modal fade" id="upload_skd" tabindex="-1" aria-labelledby="uploadSuratModalLabel" data-bs-backdrop="static">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="uploadSuratModalLabel">Upload Surat Keterangan Domisili</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <form action="{{ route('upload_skd') }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    <div class="modal-body">
                        <input type="hidden" name="id_sk_domisili" id="id_sk_domisili">
                        <div class="mb-3">
                            <label for="surat_selesai" class="form-label">Pilih File Surat</label>
                            <input type="file" class="form-control" name="surat_selesai" id="surat_selesai" required>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                        <button type="submit" class="btn btn-primary">Upload</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    {{-- UPLOAD SKTM --}}
    <div class="modal fade" id="upload_sktm" tabindex="-1" aria-labelledby="uploadSuratModalLabel" data-bs-backdrop="static">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="uploadSuratModalLabel">Upload Surat Keterangan Tidak Mampu</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <form action="{{ route('upload_sktm') }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    <div class="modal-body">
                        <input type="hidden" name="id_sk_tidak_mampu" id="id_sk_tidak_mampu">
                        <div class="mb-3">
                            <label for="surat_selesai" class="form-label">Pilih File Surat</label>
                            <input type="file" class="form-control" name="surat_selesai" id="surat_selesai" required>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                        <button type="submit" class="btn btn-primary">Upload</button>
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
                    { orderable: false, targets: [6] }
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

        // UPLOAD SKU
        $(document).ready(function() {
            $('#upload_sku').on('show.bs.modal', function (event) {
                var button = $(event.relatedTarget);
                var id = button.data('bs-id');
                var modal = $(this);
                modal.find('#id_sk_usaha').val(id);
            });
        });

        // UPLOAD SKBM
        $(document).ready(function() {
            $('#upload_skbm').on('show.bs.modal', function (event) {
                var button = $(event.relatedTarget);
                var id = button.data('bs-id');
                var modal = $(this);
                modal.find('#id_sk_belum_menikah').val(id);
            });
        });

        // UPLOAD SKD
        $(document).ready(function() {
            $('#upload_skd').on('show.bs.modal', function (event) {
                var button = $(event.relatedTarget);
                var id = button.data('bs-id');
                var modal = $(this);
                modal.find('#id_sk_domisili').val(id);
            });
        });

        // UPLOAD SKTM
        $(document).ready(function() {
            $('#upload_sktm').on('show.bs.modal', function (event) {
                var button = $(event.relatedTarget);
                var id = button.data('bs-id');
                var modal = $(this);
                modal.find('#id_sk_tidak_mampu').val(id);
            });
        });
    </script>
@endsection