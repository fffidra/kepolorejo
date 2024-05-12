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

                    <!-- start page title -->
                    <div class="row mx-2">
                        <div class="col-12">
                            <div class="page-title-box d-flex align-items-center justify-content-between">
                                <ol class="breadcrumb m-0">
                                    <li class="breadcrumb-item"><a href="javascript: void(0);">Data Master</a></li>
                                    <li class="breadcrumb-item active">Pegawai</li>
                                </ol>
                            </div>
                        </div>
                    </div><!-- end page title -->

                    <div class="row bg-white rounded-3 pb-3 mb-3 mx-2">
                        <div class="page-title-box bg-light-subtle rounded-3 d-flex align-items-center justify-content-between px-3 py-2">
                            <h5>List Data Pegawai</h5>
                            <button data-bs-toggle="modal" data-bs-target="#tambahpegawaibaru" class="btn btn-primary">Tambah Pegawai</button>
                        </div>
                        <div class="container-fluid table-responsive px-3 py-3">
                            <table class="table table-striped" style="width:100%">
                                <thead>
                                    <tr>
                                        <th>NIP</th>
                                        <th>Nama</th>
                                        <th>Bidang</th>
                                        <th>Aksi</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach(\App\Models\Pegawai::where('role', 'Pegawai')->get() as $data)
                                        <tr>
                                            <td>{{ $data->nik }}</td>
                                            <td>{{ $data->nama }}</td>
                                            <td>{{ $data->bidang }}</td>
                                            <td>
                                                <div class="d-flex">
                                                    <a role="button" class="btn btn-warning me-2" title="Ubah Data" style="padding: 0.25rem 0.5rem; font-size: 18px;" data-bs-toggle="modal" data-bs-target="#modalUbah" data-bs-id="{{ $data->nik }}"><i class="bx bx-pencil"></i></a>
                                                    <form method="POST" action="" id="hapus-pegawai-{{ $data->nip }}">
                                                        @csrf
                                                        @method('DELETE')
                                                        <a role="button" id="btnHps-{{ $data->nik }}" class="btn btn-danger" title="Hapus Data"style="padding: 0.25rem 0.5rem; font-size: 18px;"><i class="bx bx-trash-alt"></i></a>
                                                    </form>
                                                </div>
                                                <script>
                                                    $('#btnHps-{{ $data->nik }}').click(function(event){
                                                        event.preventDefault();
                                                        Swal.fire({
                                                            icon: "info",
                                                            title: "Konfirmasi",
                                                            text: "Apakah Anda yakin ingin menghapus data ini?",
                                                            showCancelButton: true,
                                                            confirmButtonText: "Ya, Lanjutkan",
                                                            cancelButtonText: "Tidak, Batalkan",
                                                        }).then(function (result) {
                                                            if (result.isConfirmed) {
                                                                $('#hapus-pegawai-{{ $data->nik }}').submit();
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
                </div> <!-- container-fluid -->
            </div>
            @include('layout.footer')
        </div>
    </div>
@endsection

@section('modal')
    {{-- MODAL DETAIL --}}
    <div class="modal fade" id="tambahpegawaibaru" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Form Tambah Data Pegawai</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <form method="POST" action="{{ route('tambah_pegawai') }}"> 
                    @csrf
                    <div class="modal-body">
                        <div class="mb-3">
                            <label for="nik" class="col-form-label" name="nik">nik</label>
                            <input type="text" class="form-control" id="nik" name="nik" required>
                        </div> 
                        <div class="mb-3">
                            <label for="nama" class="col-form-label" name="nama">Nama</label>
                            <input type="text" class="form-control" id="nama" name="nama" required>
                        </div>
                        {{-- <div class="mb-3">
                            <label for="nama_bidang" class="col-form-label">Bidang</label>
                            <select class="form-select" id="nama_bidang" name="nama_bidang" required>
                                <option value="" selected hidden>-- Pilih Bidang --</option>
                                    @foreach ($bidang as $data)
                                        <option value="{{ $data->nama_bidang }}">{{ $data->nama_bidang }}</option>
                                    @endforeach
                            </select>
                        </div> --}}
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                        <button type="submit" class="btn btn-primary">Tambah</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection

@section('script')
<script>
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