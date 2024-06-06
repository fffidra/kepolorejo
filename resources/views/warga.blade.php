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
                            <h5>DATA WARGA KELURAHAN KEPOLOREJO</h5>
                            <button data-bs-toggle="modal" data-bs-target="#tambahwargabaru" class="btn btn-primary">TAMBAH WARGA</button>
                        </div>
                        <div class="container-fluid table-responsive px-3 py-3">
                            <table class="table table-striped" style="width:100%">
                                <thead>
                                    <tr>
                                        <th class="text-center align-middle">NIK</th>
                                        <th class="text-center align-middle">NAMA</th>
                                        <th class="text-center align-middle">AKSI</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach(\App\Models\User::where('role', 'Warga')->get() as $data)                                    
                                        <tr>
                                            <td class="text-center align-middle">{{ $data->nik }}</td>
                                            <td class="text-center align-middle">{{ $data->nama }}</td>
                                            <td class="text-center align-middle">
                                                <div class="d-flex justify-content-center">
                                                    <form method="POST" action="{{ route('hapus_warga', $data->nik) }}" id="hapus-warga-{{ $data->nik }}">
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
                                                            text: "Apakah Anda yakin ingin menghapus warga {{$data->nama}}?",
                                                            showCancelButton: true,
                                                            confirmButtonText: "Ya, Lanjutkan",
                                                            cancelButtonText: "Tidak, Batalkan",
                                                        }).then(function (result) {
                                                            if (result.isConfirmed) {
                                                                $('#hapus-warga-{{ $data->nik }}').submit();
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
    <div class="modal fade" id="tambahwargabaru" tabindex="-1" aria-hidden="true" data-bs-backdrop="static" data-bs-keyboard="false">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Tambah Data Warga</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <form method="POST" action="{{ route('tambah_warga') }}"> 
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
@endsection

@section('script')
<script>
    $(document).ready(function() {
        var table = $('.table').DataTable({
            order: [[1, 'asc']],
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
</script>
@endsection