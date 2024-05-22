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
                                        <th class="text-center align-middle">Jabatan</th>
                                        <th class="text-center align-middle">Posisi</th>
                                        <th class="text-center align-middle">Peran</th>
                                        <th class="text-center align-middle">Aksi</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach(\App\Models\Jabatan::all() as $data)
                                        <tr>
                                            <td>{{ $data->nip }}</td>
                                            <td>{{ $data->nama }}</td>
                                            <td class="text-center align-middle"> {{ $data->nama_jabatan }}</td>
                                            <td class="text-center align-middle">{{ $data->posisi }}</td>
                                            <td class="text-center align-middle">
                                                <select class="form-select" name="peran" onchange="update_peran('{{ $data->nip }}', this.value)">
                                                    <option value="Penanda Tangan" {{ $data->peran == 'Penanda Tangan' ? 'selected' : '' }}>Penanda Tangan</option>
                                                    <option value="Non Penanda Tangan" {{ $data->peran == 'Non Penanda Tangan' ? 'selected' : '' }}>Non Penanda Tangan</option>
                                                </select>
                                            </td>                                        
                                            <td class="text-center align-middle">
                                                <div class="d-flex justify-content-center">
                                                    <a role="button" class="btn btn-warning me-2" title="Ubah Data" style="padding: 0.25rem 0.5rem; font-size: 18px;" data-bs-toggle="modal" data-bs-target="#ubahjabatan" data-bs-id="{{ $data->nip }}"><i class="bx bx-pencil"></i></a>
                                                    <form method="POST" action="{{ route('hapus_jabatan', $data->nip) }}" id="hapus-jabatan-{{ $data->nip }}">
                                                        @csrf
                                                        @method('DELETE')
                                                        <button type="submit" role="button" id="btnHps-{{ $data->nip }}" class="btn btn-danger" title="Hapus Data" style="padding: 0.25rem 0.5rem; font-size: 18px;"><i class="bx bx-trash-alt"></i></button>
                                                    </form>
                                                </div>
                                                <script>
                                                    $('#btnHps-{{ $data->nip }}').click(function(event){
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
                                                                $('#hapus-jabatan-{{ $data->nip }}').submit();
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
                            <label for="nip" class="col-form-label" name="nik"><strong>NIP</strong> (Format: 19XX0309 20X100 X 2XX)</label>
                            <input type="text" class="form-control" id="nip" name="nip" required placeholder="Nomor Induk Pegawai">
                        </div> 
                        <div class="mb-3">
                            <label for="nama" class="col-form-label" name="nama"><strong>NAMA</strong> (Tambahkan Gelar Lengkap)</label>
                            <input type="text" class="form-control" id="nama" name="nama" placeholder="Isikan nama lengkap" required>
                        </div>
                        <div class="mb-3">
                            <label for="nama_jabatan" class="col-form-label" name="jabatan"><strong>JABATAN</strong></label>
                            <input type="text" class="form-control" id="nama_jabatan" name="nama_jabatan" placeholder="Isikan jabatan lengkap" required>
                        </div>
                        <div class="mb-3">
                            <label for="posisi" class="col-form-label" name="posisi"><strong>POSISI</strong></label>
                            <input type="text" class="form-control" id="posisi" name="posisi" placeholder="Isikan posisi lengkap" required>
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
                    <input type="hidden" name="nip" id="nip2" required>
                    <div class="modal-body">
                        <div class="mb-3 row">
                            <label for="ubah_nip" class="col-md-2 col-form-label">NIP (Nomor Induk Pegawai)</label>
                            <div class="col-md-9">
                                <input type="text" class="form-control" id="ubah_nip" name="ubah_nip" required>
                            </div>
                        </div>
                        <div class="mb-3 row">
                            <label for="ubah_nama" class="col-md-2 col-form-label">Nama (Tambahkan Gelar)</label>
                            <div class="col-md-9">
                                <input type="text" class="form-control" id="ubah_nama" name="ubah_nama" required>
                            </div>
                        </div>
                        <div class="mb-3 row">
                            <label for="ubah_nama_jabatan" class="col-md-2 col-form-label">Jabatan</label>
                            <div class="col-md-9">
                                <input type="text" class="form-control" id="ubah_nama_jabatan" name="ubah_nama_jabatan" required>
                            </div>
                        </div>
                        <div class="mb-3 row">
                            <label for="ubah_posisi" class="col-md-2 col-form-label">Posisi</label>
                            <div class="col-md-9">
                                <input type="text" class="form-control" id="ubah_posisi" name="ubah_posisi" required>
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

        $('#ubahjabatan').on('show.bs.modal', function (event) {
            var button = $(event.relatedTarget);
            var nip = button.data('nip');
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
                        $("#nip2").val(jabatan.nip);
                        $("#ubah_nip").val(jabatan.nip);
                        $("#ubah_nama").val(jabatan.nama);
                        $("#ubah_nama_jabatan").val(jabatan.nama_jabatan);
                        $("#ubah_posisi").val(jabatan.posisi);
                    }
                }, 
            });
        });

        $(document).on('click', '.btn-edit', function(e){
            e.preventDefault();
            var nip = $(this).val();
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });
            $.ajax({
                type: "GET",
                url: "/ubah_isi_jabatan/"+nip,
                data: { nip: nip },
                success: function (response) {
                console.log(response);
                    $('#ubah_nip').val(response.jabatan.nip);
                    $('#ubah_nama').val(response.jabatan.nama);
                    $('#ubah_nama_jabatan').val(response.jabatan.nama_jabatan);
                    $('#ubah_posisi').val(response.jabatan.posisi);
                    $('#ubahjabatan').modal('show');                
                }
            });        
        });

        $(document).ready(function() {
            $('#simpanjabatan').click(function(event){
                event.preventDefault();
                var nip = document.getElementById("ubah_nip");
                var nama = document.getElementById("ubah_nama");
                var nama_jabatan = document.getElementById("ubah_nama_jabatan");
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

        function update_peran(nip, peran) {
            $.ajax({
                url: '{{ route("update_peran") }}',
                type: 'POST',
                data: {
                    nip: nip,
                    peran: peran,
                    _token: '{{ csrf_token() }}'
                },
                success: function(response) {
                    if (response.status === 'success') {
                        Swal.fire({
                            icon: "success",
                            title: "Berhasil",
                            text: "Peran berhasil diperbarui",
                        }).then(() => {
                            location.reload();
                        });
                    } else {
                        Swal.fire({
                            icon: "error",
                            title: "Gagal",
                            text: "Peran gagal diperbarui",
                        });
                    }
                }
            });
        }
    </script>
@endsection