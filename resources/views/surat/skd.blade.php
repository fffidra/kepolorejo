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
                            <h5>Data Riwayat Surat</h5>
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
                                        <th class="col-md-2 text-center align-middle">Aksi</th>                           
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach(\App\Models\SKDomisili::where('status_surat', 'Selesai')->get() as $skd)
                                        <tr>      
                                            <td class="text-center align-middle">{{ $skd->tanggal }}</td>
                                            <td class="text-center align-middle">{{ $skd->jenis_surat }}</td>
                                            <td class="text-center align-middle">{{ $skd->nik }}</td>
                                            <td class="text-center align-middle">{{ $skd->nama }}</td>
                                            <td class="text-center align-middle">{{ $skd->status_surat }}</td>
                                            <td class="text-center">
                                                <div class="d-flex justify-content-center">
                                                    <button type="button" data-bs-toggle="modal" data-bs-target="#detailSKU" data-bs-id="{{ $skd->id_sk_belum_menikah }}" class="btn btn-info btn-sm">Detail</button>
                                                </div>
                                                <script>
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
</script>
@endsection