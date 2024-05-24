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
                    <div class="row mx-2">
                        <div class="col-12">
                            <div class="page-title-box d-flex align-items-center justify-content-between">
                                <ol class="breadcrumb m-0">
                                    <li class="breadcrumb-item"><a href="javascript: void(0);">Data Master</a></li>
                                    <li class="breadcrumb-item active">Pegawai</li>
                                </ol>
                            </div>
                        </div>
                    </div>
                    <div class="row bg-white rounded-3 pb-3 mb-3 mx-2">
                        <div class="page-title-box bg-light-subtle rounded-3 d-flex align-items-center justify-content-between px-3 py-2">
                            <h5>List Data Pegawai Kelurahan Kepolorejo</h5>
                            <button data-bs-toggle="modal" data-bs-target="#tambahpegawaibaru" class="btn btn-primary">Tambah Pegawai</button>
                        </div>
                        <div class="container-fluid table-responsive px-3 py-3">
                            <table class="table table-striped" style="width:100%">
                                <thead>
                                    <tr>
                                        <th class="text-center align-middle">NIK</th>
                                        <th class="text-center align-middle">Nama</th>
                                        <th class="text-center align-middle">Aksi</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach(\App\Models\User::where('role', 'Pegawai')->get() as $data)
                                        <tr>
                                            <td class="text-center align-middle">{{ $data->nik }}</td>
                                            <td class="text-center align-middle">{{ $data->nama }}</td>
                                            <td class="text-center align-middle">
                                                <div class="d-flex justify-content-center">
                                                    <a role="button" class="btn btn-warning me-2" title="Ubah Data" style="padding: 0.25rem 0.5rem; font-size: 18px;" data-bs-toggle="modal" data-bs-target="#ubahpegawai" data-bs-id="{{ $data->nik }}"><i class="bx bx-pencil"></i></a>
                                                    <form method="POST" action="{{ route('hapus_pegawai', $data->nik) }}" id="hapus-pegawai-{{ $data->nik }}">
                                                        @csrf
                                                        @method('DELETE')
                                                        <button type="submit" role="button" id="btnHps-{{ $data->nik }}" class="btn btn-danger" title="Hapus Data" style="padding: 0.25rem 0.5rem; font-size: 18px;"><i class="bx bx-trash-alt"></i></button>
                                                    </form>
                                                </div>
                                                <script>
                                                    $('#btnHps-{{ $data->nik }}').click(function(event){
                                                        event.preventDefault();
                                                        Swal.fire({
                                                            icon: "info",
                                                            title: "Konfirmasi",
                                                            text: "Apakah Anda yakin ingin menghapus pegawai {{$data->nama}}?",
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
                </div>
            </div>
            @include('layout.footer')
        </div>
    </div>
@endsection

@section('modal')
    {{-- MODAL TAMBAH PEGAWAI --}}
    <div class="modal fade" id="tambahpegawaibaru" tabindex="-1" aria-hidden="true" data-bs-backdrop="static" data-bs-keyboard="false">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Tambah Data Pegawai</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <form method="POST" action="{{ route('tambah_pegawai') }}"> 
                    @csrf
                    <div class="modal-body">
                        <div class="mb-3">
                            <label for="nik" class="col-form-label" name="nik"><strong>NIK</strong> - (Nomor Induk Kependudukan)</label>
                            <input type="text" class="form-control" id="nik" name="nik" placeholder="Masukkan NIK" required>
                        </div> 
                        <div class="mb-3">
                            <label for="nama" class="col-form-label" name="nama"><strong>NAMA LENGKAP</strong></label>
                            <input type="text" class="form-control" id="nama" name="nama" placeholder="Masukkan Nama Lengkap" required>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                        <button type="submit" class="btn btn-primary">Tambah</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    {{-- MODAL UBAH PEGAWAI --}}
    <div class="modal fade" id="ubahpegawai" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Ubah Data Pegawai</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <form method="POST" action="{{ route('ubah_pegawai') }}" id="ubah_pegawai">
                    @csrf
                    @method('PUT')
                    <input type="hidden" name="nik" id="nik2" required>
                    <div class="modal-body">
                        <div class="mb-3 row">
                            <label for="ubah_nik" class="col-md-2 col-form-label">NIK (Nomor Induk Kependudukan)</label>
                            <div class="col-md-9">
                                <textarea class="form-control" id="ubah_nik" name="ubah_nik" rows="1"></textarea>
                            </div>
                        </div>
                        <div class="mb-3 row">
                            <label for="ubah_nama" class="col-md-2 col-form-label">Nama</label>
                            <div class="col-md-9">
                                <textarea class="form-control" id="ubah_nama" name="ubah_nama" rows="1"></textarea>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Tutup</button>
                        <button type="submit" class="btn btn-warning" id="simpanpegawai">Simpan Perubahan</button>
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
            columnDefs: [
                { orderable: false, targets: [2] }
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

    $('#ubahpegawai').on('show.bs.modal', function (event) {
        var button = $(event.relatedTarget);
        var nik = button.data('nik');
        $.ajax({
            url: '{{ route("get_data_pegawai") }}',
            type: 'POST',
            data: {
                id: button.data('bs-id'),
                _token: '{{ csrf_token() }}',
            },
            dataType: 'JSON',
            success: function(response) {
                if (response.status == 'success') {
                    var pegawai = response.pegawai;
                    $("#nik2").val(pegawai.nik);
                    $("#ubah_nik").val(pegawai.nik);
                    $("#ubah_nama").val(pegawai.nama);
                }
            }, 
        });
    });

    $(document).on('click', '.btn-edit', function(e){
        e.preventDefault();
        var nik = $(this).val();
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });
        $.ajax({
            type: "GET",
            url: "/ubah_isi_pegawai/"+nik,
            data: { nik: nik },
            success: function (response) {
            console.log(response);
                $('#ubah_nik').val(response.pegawai.nik);
                $('#ubah_nama').val(response.pegawai.nama);
                $('#ubahpegawai').modal('show');                
            }
        });        
    });

    $(document).ready(function() {
        $('#simpanpegawai').click(function(event){
            event.preventDefault();
            var nik = document.getElementById("ubah_nik");
            var nama = document.getElementById("ubah_nama");
            if (!nik.value) {
                Swal.fire({
                    icon: "error",
                    title: "Oops...",
                    text: "Semua inputan wajib diisi!",
                });
            } else {
                Swal.fire({
                    icon: "info",
                    title: "Konfirmasi",
                    text: "Apakah Anda yakin data pegawai sudah benar?",
                    showCancelButton: true,
                    confirmButtonText: "Ya, Lanjutkan",
                    cancelButtonText: "Tidak, Batalkan",
                }).then(function (result) {
                    if (result.isConfirmed) {
                        $('#ubah_pegawai').submit();
                    }
                });
            }
        });
    });
</script>
@endsection