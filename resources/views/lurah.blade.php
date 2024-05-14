@extends('layout.app')

@section('title')
    Data Jabatan
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
                                    <li class="breadcrumb-item active">Jabatan</li>
                                </ol>
                            </div>
                        </div>
                    </div>
                    <div class="row bg-white rounded-3 pb-3 mb-3 mx-2">
                        <div class="page-title-box bg-light-subtle rounded-3 d-flex align-items-center justify-content-between px-3 py-2">
                            <h5>List Data Jabatan Kelurahan Kepolorejo</h5>
                            <button data-bs-toggle="modal" data-bs-target="#tambahjabatan" class="btn btn-primary">Tambah Jabatan</button>
                        </div>
                        <div class="container-fluid table-responsive px-3 py-3">
                            <table class="table table-striped" style="width:100%">
                                <thead>
                                    <tr>
                                        <th>NIP</th>
                                        <th>Nama</th>
                                        <th>Posisi</th>
                                        <th>Aksi</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach(\App\Models\Jabatan::all() as $data)
                                        <tr>
                                            <td>{{ $data->nip }}</td>
                                            <td>{{ $data->nama }}</td>
                                            <td>{{ $data->posisi }}</td>
                                            <td>
                                                <div class="d-flex">
                                                    <a role="button" class="btn btn-warning me-2" title="Ubah Data" style="padding: 0.25rem 0.5rem; font-size: 18px;" data-bs-toggle="modal" data-bs-target="#ubahjabatan" data-bs-id="{{ $data->id_jabatan }}"><i class="bx bx-pencil"></i></a>
                                                    <form method="POST" action="{{ route('hapus_jabatan', $data->id_jabatan) }}" id="hapus-jabatan-{{ $data->id_jabatan }}">
                                                        @csrf
                                                        @method('DELETE')
                                                        <button type="submit" role="button" id="btnHps-{{ $data->id_jabatan }}" class="btn btn-danger" title="Hapus Data" style="padding: 0.25rem 0.5rem; font-size: 18px;"><i class="bx bx-trash-alt"></i></button>
                                                    </form>
                                                </div>
                                                <script>
                                                    $('#btnHps-{{ $data->id_jabatan }}').click(function(event){
                                                        event.preventDefault();
                                                        Swal.fire({
                                                            icon: "info",
                                                            title: "Konfirmasi",
                                                            text: "Apakah Anda yakin ingin menghapus jabatan {{$data->nama}}?",
                                                            showCancelButton: true,
                                                            confirmButtonText: "Ya, Lanjutkan",
                                                            cancelButtonText: "Tidak, Batalkan",
                                                        }).then(function (result) {
                                                            if (result.isConfirmed) {
                                                                $('#hapus-jabatan-{{ $data->id_jabatan }}').submit();
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
    {{-- MODAL TAMBAH JABATAN --}}
    <div class="modal fade" id="tambahjabatan" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Tambah Data Jabatan</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <form method="POST" action="{{ route('tambah_jabatan') }}"> 
                    @csrf
                    <div class="modal-body">
                        <div class="mb-3">
                            <label for="nip" class="col-form-label" name="nik">NIP (Nomor Induk Pegawai)</label>
                            <input type="text" class="form-control" id="nip" name="nip" required>
                        </div> 
                        <div class="mb-3">
                            <label for="nama" class="col-form-label" name="nama">Nama (Tambahkan Gelar)</label>
                            <input type="text" class="form-control" id="nama" name="nama" required>
                        </div>
                        <div class="mb-3">
                            <label for="posisi" class="col-form-label" name="posisi">Jabatan</label>
                            <input type="text" class="form-control" id="posisi" name="posisi" required>
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

    {{-- MODAL UBAH JABATAN --}}
    <div class="modal fade" id="ubahjabatan" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Ubah Data Jabatan</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <form method="POST" action="{{ route('ubah_jabatan') }}" id="ubah_jabatan">
                    @csrf
                    @method('PUT')
                    <input type="hidden" name="id_jabatan" id="id_jabatan" required>
                    <div class="modal-body">
                        <div class="mb-3 row">
                            <label for="ubah_nip" class="col-md-2 col-form-label">NIP (Nomor Induk Pegawai)</label>
                            <div class="col-md-9">
                                <textarea class="form-control" id="ubah_nip" name="ubah_nip" rows="1"></textarea>
                            </div>
                        </div>
                        <div class="mb-3 row">
                            <label for="ubah_nama" class="col-md-2 col-form-label">Nama (Tambahkan Gelar)</label>
                            <div class="col-md-9">
                                <textarea class="form-control" id="ubah_nama" name="ubah_nama" rows="1"></textarea>
                            </div>
                        </div>
                        <div class="mb-3 row">
                            <label for="ubah_posisi" class="col-md-2 col-form-label">Posisi</label>
                            <div class="col-md-9">
                                <textarea class="form-control" id="ubah_posisi" name="ubah_posisi" rows="1"></textarea>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Tutup</button>
                        <button type="submit" class="btn btn-warning" id="simpanjabatan">Simpan Perubahan</button>
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
                { orderable: false, targets: [3] }
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

    $('#ubahjabatan').on('show.bs.modal', function (event) {
        var button = $(event.relatedTarget);
        var id_jabatan = button.data('id_jabatan');
        $.ajax({
            url: '{{ route("get_data_jabatan") }}',
            type: 'POST',
            data: {
                id: button.data('bs-id'),
                _token: '{{ csrf_token() }}',
            },
            dataType: 'JSON',
            success: function(response) {
                if (response.status == 'success') {
                    var jabatan = response.jabatan;
                    $("#id_jabatan").val(jabatan.id_jabatan);
                    $("#ubah_nip").val(jabatan.nip);
                    $("#ubah_nama").val(jabatan.nama);
                    $("#ubah_posisi").val(jabatan.posisi);
                }
            }, 
        });
    });

    $(document).on('click', '.btn-edit', function(e){
        e.preventDefault();
        var id_jabatan = $(this).val();
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });
        $.ajax({
            type: "GET",
            url: "/ubah_isi_jabatan/"+id_jabatan,
            data: { id_jabatan: id_jabatan },
            success: function (response) {
            console.log(response);
                $('#id_jabatan').val(response.jabatan.id_jabatan);
                $('#ubah_nip').val(response.jabatan.nip);
                $('#ubah_nama').val(response.jabatan.nama);
                $('#ubah_posisi').val(response.jabatan.posisi);
                $('#ubahjabatan').modal('show');                
            }
        });        
    });

    $(document).ready(function() {
        $('#simpanjabatan').click(function(event){
            event.preventDefault(); // Mencegah pengiriman formulir secara default
            var id_jabatan = document.getElementById("id_jabatan");
            var nip = document.getElementById("ubah_nip");
            var nama = document.getElementById("ubah_nama");
            var posisi = document.getElementById("ubah_posisi");
            if (!nip.value) {
                Swal.fire({
                    icon: "error",
                    title: "Oops...",
                    text: "Semua inputan wajib diisi!",
                });
            } else {
                Swal.fire({
                    icon: "info",
                    title: "Konfirmasi",
                    text: "Apakah Anda yakin data jabatan sudah benar?",
                    showCancelButton: true,
                    confirmButtonText: "Ya, Lanjutkan",
                    cancelButtonText: "Tidak, Batalkan",
                }).then(function (result) {
                    if (result.isConfirmed) {
                        $('#ubah_jabatan').submit();
                    }
                });
            }
        });
    });
</script>
@endsection