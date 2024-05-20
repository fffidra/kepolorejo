@extends('layout.app')

@section('title')
    Data Surat Ditolak
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
                            <h5>Data Surat Ditolak</h5>
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
                                        <th class="col-md-2 text-center align-middle">AKSI</th>                           
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach(\App\Models\SKUsaha::where('status_surat', '=', 'Ditolak')->get() as $sk_usaha)
                                        <tr>
                                            <td class="text-center align-middle">{{ $sk_usaha->tanggal }}</td>
                                            <td class="text-center align-middle">{{ $sk_usaha->jenis_surat }}</td>
                                            <td class="text-center align-middle">{{ $sk_usaha->nik }}</td>
                                            <td class="text-center align-middle">{{ $sk_usaha->nama }}</td>
                                            <td class="text-center align-middle">{{ $sk_usaha->status_surat }}</td>
                                            <td class="text-center align-middle">{{ $sk_usaha->verifikator }}</td>
                                            <td class="text-center">
                                                <div class="d-flex justify-content-center">
                                                    <button type="button" data-bs-toggle="modal" data-bs-target="#pesan_ditolak" data-bs-id="{{ $sk_usaha->id_sk_usaha }}" data-bs-pesan="{{ $sk_usaha->pesan }}" class="btn btn-primary btn-sm me-1">Pesan Ditolak</button>
                                                    <form method="POST" action="{{ route('hapus_sk_usaha', $sk_usaha->id_sk_usaha) }}" id="hapus-surat-{{ $sk_usaha->id_sk_usaha }}" class="d-inline">
                                                        @csrf
                                                        @method('DELETE')
                                                        <button type="button" id="btnHapus-{{ $sk_usaha->id_sk_usaha }}" class="btn btn-danger btn-sm mx-1"><i class="bx bx-trash-alt"></i></button>
                                                    </form>
                                                </div>
                                                <script>
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

                                    @foreach(\App\Models\SKBelumMenikah::where('status_surat', '=', 'Ditolak')->get() as $skbm)
                                        <tr>
                                            <td class="text-center align-middle">{{ $skbm->tanggal }}</td>
                                            <td class="text-center align-middle">{{ $skbm->jenis_surat }}</td>
                                            <td class="text-center align-middle">{{ $skbm->nik }}</td>
                                            <td class="text-center align-middle">{{ $skbm->nama }}</td>
                                            <td class="text-center align-middle">{{ $skbm->status_surat }}</td>
                                            <td class="text-center align-middle">{{ $skbm->verifikator }}</td>
                                            <td class="text-center">
                                                <div class="d-flex justify-content-center">
                                                    <button type="button" data-bs-toggle="modal" data-bs-target="#pesan_ditolak" data-bs-id="{{ $skbm->id_sk_belum_menikah }}" data-bs-pesan="{{ $skbm->pesan }}" class="btn btn-primary btn-sm me-1">Pesan Ditolak</button>
                                                    <form method="POST" action="{{ route('hapus_skbm', $skbm->id_sk_belum_menikah) }}" id="hapus-surat-{{ $skbm->id_sk_belum_menikah }}" class="d-inline">
                                                        @csrf
                                                        @method('DELETE')
                                                        <button type="button" id="btnHapus-{{ $skbm->id_sk_belum_menikah }}" class="btn btn-danger btn-sm mx-1"><i class="bx bx-trash-alt"></i></button>
                                                    </form>
                                                </div>
                                                <script>
                                                    $('#btnHapus-{{ $skbm->id_sk_belum_menikah }}').click(function(event){
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
                                                                $('#hapus-surat-{{ $skbm->id_sk_belum_menikah }}').submit();
                                                            }
                                                        });
                                                    });
                                                </script>
                                            </td>
                                        </tr>
                                    @endforeach

                                    @foreach(\App\Models\SKDomisili::where('status_surat', '=', 'Ditolak')->get() as $skd)
                                        <tr>
                                            <td class="text-center align-middle">{{ $skd->tanggal }}</td>
                                            <td class="text-center align-middle">{{ $skd->jenis_surat }}</td>
                                            <td class="text-center align-middle">{{ $skd->nik }}</td>
                                            <td class="text-center align-middle">{{ $skd->nama }}</td>
                                            <td class="text-center align-middle">{{ $skd->status_surat }}</td>
                                            <td class="text-center align-middle">{{ $skd->verifikator }}</td>
                                            <td class="text-center">
                                                <div class="d-flex justify-content-center">
                                                    <button type="button" data-bs-toggle="modal" data-bs-target="#pesan_ditolak" data-bs-id="{{ $skd->id_sk_domisili }}" data-bs-pesan="{{ $skd->pesan }}" class="btn btn-primary btn-sm me-1">Pesan Ditolak</button>
                                                    <form method="POST" action="{{ route('hapus_skd', $skd->id_sk_domisili) }}" id="hapus-surat-{{ $skd->id_sk_domisili }}" class="d-inline">
                                                        @csrf
                                                        @method('DELETE')
                                                        <button type="button" id="btnHapus-{{ $skd->id_sk_domisili }}" class="btn btn-danger btn-sm mx-1"><i class="bx bx-trash-alt"></i></button>
                                                    </form>
                                                </div>
                                                <script>
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

                                    @foreach(\App\Models\SKTidakMampu::where('status_surat', '=', 'Ditolak')->get() as $sktm)
                                        <tr>
                                            <td class="text-center align-middle">{{ $sktm->tanggal }}</td>
                                            <td class="text-center align-middle">{{ $sktm->jenis_surat }}</td>
                                            <td class="text-center align-middle">{{ $sktm->nik }}</td>
                                            <td class="text-center align-middle">{{ $sktm->nama }}</td>
                                            <td class="text-center align-middle">{{ $sktm->status_surat }}</td>
                                            <td class="text-center align-middle">{{ $sktm->verifikator }}</td>
                                            <td class="text-center">
                                                <div class="d-flex justify-content-center">
                                                    <button type="button" data-bs-toggle="modal" data-bs-target="#pesan_ditolak" data-bs-id="{{ $sktm->id_sk_tidak_mampu }}" data-bs-pesan="{{ $sktm->pesan }}" class="btn btn-primary btn-sm me-1">Pesan Ditolak</button>
                                                    <form method="POST" action="{{ route('hapus_sktm', $sktm->id_sk_tidak_mampu) }}" id="hapus-surat-{{ $sktm->id_sk_tidak_mampu }}" class="d-inline">
                                                        @csrf
                                                        @method('DELETE')
                                                        <button type="button" id="btnHapus-{{ $sktm->id_sk_tidak_mampu }}" class="btn btn-danger btn-sm mx-1"><i class="bx bx-trash-alt"></i></button>
                                                    </form>
                                                </div>
                                                <script>
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

    </script>
@endsection