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
                                        <th class="col-md-2 text-center align-middle">Tanggal Pengajuan</th>                           
                                        <th class="col-md-2 text-center align-middle">Jenis Surat</th>                           
                                        <th class="col-md-2 text-center align-middle">NIK</th>                           
                                        <th class="col-md-2 text-center align-middle">Nama</th>                           
                                        <th class="col-md-2 text-center align-middle">Status</th>                           
                                        <th class="col-md-2 text-center align-middle">Verifikator</th>                           
                                        <th class="col-md-2 text-center align-middle">Aksi</th>                           
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
                                                    <button type="button" data-bs-toggle="modal" data-bs-target="#pesan_ditolak" data-bs-id="{{ $sk_usaha->id_sk_usaha }}" data-bs-pesan="{{ $sk_usaha->pesan }}" class="btn btn-info btn-sm">Pesan Ditolak</button>

                                                    <form method="POST" action="{{ route('hapus_sk_usaha', $sk_usaha->id_sk_usaha) }}" id="hapus-surat-{{ $sk_usaha->id_sk_usaha }}" class="d-inline">
                                                        @csrf
                                                        @method('DELETE')
                                                        <button type="button" id="btnHapus-{{ $sk_usaha->id_sk_usaha }}" class="btn btn-danger btn-sm mx-1"><i class="bx bx-trash-alt"></i></button>
                                                    </form>

                                                    {{-- <a href="{{ route('unduh_sk_usaha', ['id_sk_usaha' => $sk_usaha->id_sk_usaha]) }}" target="_blank" class="btn btn-info btn-sm" style="margin-right: 10px;">Unduh</a>  --}}

                                                    {{-- <button type="button" data-bs-toggle="modal" data-bs-target="#modalDokumen" data-bs-id="{{ $surat->id_surat }}" class="btn btn-info btn-sm">Ubah</button> --}}

                                                    {{-- <form method="POST" action="{{ route('sku_selesai', $sk_usaha->id_sk_usaha) }}" id="selesai-surat-{{ $sk_usaha->id_sk_usaha  }}">
                                                        @csrf
                                                        @method('PUT')
                                                        <button type="button" id="btnSelesai-{{ $sk_usaha->id_sk_usaha  }}" class="btn btn-primary btn-sm">Selesai</button>
                                                    </form> --}}
                                                </div>
                                                <script>
                                                    // $('#btnSelesai-{{ $sk_usaha->id_sk_usaha  }}').click(function(event){
                                                    //     event.preventDefault();
                                                    //     Swal.fire({
                                                    //         icon: "info",
                                                    //         title: "Konfirmasi",
                                                    //         text: "Apakah Anda yakin ingin mengirim data ini?",
                                                    //         showCancelButton: true,
                                                    //         confirmButtonText: "Ya, Lanjutkan",
                                                    //         cancelButtonText: "Tidak, Batalkan",
                                                    //     }).then(function (result) {
                                                    //         if (result.isConfirmed) {
                                                    //             $('#selesai-surat-{{ $sk_usaha->id_sk_usaha  }}').submit();
                                                    //         }
                                                    //     });
                                                    // });

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


                                                    // Menambahkan event listener ke tombol 'Unduh'
                                                    // $('#unduhButton').click(function() {
                                                    //     // Mendapatkan jenis surat dan id surat dari baris tabel terpilih
                                                    //     var jenisSurat = $('.selected-row').attr('data-jenis-surat');
                                                    //     var idSurat = $('.selected-row').attr('data-id-surat');

                                                    //     // Membuat URL unduhan berdasarkan jenis surat dan id surat
                                                    //     var url = "{{ route('unduh_surat', ['jenis_surat' => ':jenis_surat', 'id_surat' => ':id_surat']) }}";
                                                    //     url = url.replace(':jenis_surat', jenisSurat).replace(':id_surat', idSurat);

                                                    //     // Mengarahkan jendela baru untuk mengunduh surat
                                                    //     window.open(url, '_blank');
                                                    // });
                                                </script>
                                            </td>
                                        </tr>
                                    @endforeach

                                    {{-- @foreach(\App\Models\SKBelumMenikah::where('status_surat', '=', 'Disetujui')->get() as $sk_bm)
                                        <tr>
                                            <td class="text-center align-middle">{{ $sk_bm->tanggal }}</td>
                                            <td class="text-center align-middle">{{ $sk_bm->jenis_surat }}</td>
                                            <td class="text-center align-middle">{{ $sk_bm->nik }}</td>
                                            <td class="text-center align-middle">{{ $sk_bm->nama }}</td>
                                            <td class="text-center align-middle">{{ $sk_bm->status_surat }}</td>
                                            <td class="text-center align-middle">{{ $sk_bm->verifikator }}</td>
                                            <td class="text-center">
                                                <div class="d-flex justify-content-center">
                                                    <a href="{{ route('unduh_sk_belum_menikah', ['id_sk_belum_menikah' => $sk_bm->id_sk_belum_menikah]) }}" target="_blank" class="btn btn-info btn-sm" style="margin-right: 10px;">Unduh</a> 

                                                    <form method="POST" action="{{ route('skbm_selesai', $sk_bm->id_sk_belum_menikah) }}" id="selesai-surat-{{ $sk_bm->id_sk_belum_menikah  }}">
                                                        @csrf
                                                        @method('PUT')
                                                        <button type="button" id="btnSelesai-{{ $sk_bm->id_sk_belum_menikah  }}" class="btn btn-primary btn-sm">Selesai</button>
                                                    </form>
                                                </div>
                                                <script>
                                                    $('#btnSelesai-{{ $sk_bm->id_sk_belum_menikah  }}').click(function(event){
                                                        event.preventDefault();
                                                        Swal.fire({
                                                            icon: "info",
                                                            title: "Konfirmasi",
                                                            text: "Apakah Anda yakin ingin mengirim data ini?",
                                                            showCancelButton: true,
                                                            confirmButtonText: "Ya, Lanjutkan",
                                                            cancelButtonText: "Tidak, Batalkan",
                                                        }).then(function (result) {
                                                            if (result.isConfirmed) {
                                                                $('#selesai-surat-{{ $sk_bm->id_sk_belum_menikah  }}').submit();
                                                            }
                                                        });
                                                    });

                                                    // Menambahkan event listener ke tombol 'Unduh'
                                                    $('#unduhButton').click(function() {
                                                        // Mendapatkan jenis surat dan id surat dari baris tabel terpilih
                                                        var jenisSurat = $('.selected-row').attr('data-jenis-surat');
                                                        var idSurat = $('.selected-row').attr('data-id-surat');

                                                        // Membuat URL unduhan berdasarkan jenis surat dan id surat
                                                        var url = "{{ route('unduh_surat', ['jenis_surat' => ':jenis_surat', 'id_surat' => ':id_surat']) }}";
                                                        url = url.replace(':jenis_surat', jenisSurat).replace(':id_surat', idSurat);

                                                        // Mengarahkan jendela baru untuk mengunduh surat
                                                        window.open(url, '_blank');
                                                    });
                                                </script>
                                            </td>
                                        </tr>
                                    @endforeach

                                    @foreach(\App\Models\SKDomisili::where('status_surat', '=', 'Disetujui')->get() as $skd)
                                        <tr>
                                            <td class="text-center align-middle">{{ $skd->tanggal }}</td>
                                            <td class="text-center align-middle">{{ $skd->jenis_surat }}</td>
                                            <td class="text-center align-middle">{{ $skd->nik }}</td>
                                            <td class="text-center align-middle">{{ $skd->nama }}</td>
                                            <td class="text-center align-middle">{{ $skd->status_surat }}</td>
                                            <td class="text-center align-middle">{{ $skd->verifikator }}</td>
                                            <td class="text-center">
                                                <div class="d-flex justify-content-center">
                                                    <a href="{{ route('unduh_sk_domisili', ['id_sk_domisili' => $skd->id_sk_domisili]) }}" target="_blank" class="btn btn-info btn-sm" style="margin-right: 10px;">Unduh</a> 

                                                    <form method="POST" action="{{ route('skd_selesai', $skd->id_sk_domisili) }}" id="selesai-surat-{{ $skd->id_sk_domisili  }}">
                                                        @csrf
                                                        @method('PUT')
                                                        <button type="button" id="btnSelesai-{{ $skd->id_sk_domisili  }}" class="btn btn-primary btn-sm">Selesai</button>
                                                    </form>
                                                </div>
                                                <script>
                                                    $('#btnSelesai-{{ $skd->id_sk_domisili  }}').click(function(event){
                                                        event.preventDefault();
                                                        Swal.fire({
                                                            icon: "info",
                                                            title: "Konfirmasi",
                                                            text: "Apakah Anda yakin ingin mengirim data ini?",
                                                            showCancelButton: true,
                                                            confirmButtonText: "Ya, Lanjutkan",
                                                            cancelButtonText: "Tidak, Batalkan",
                                                        }).then(function (result) {
                                                            if (result.isConfirmed) {
                                                                $('#selesai-surat-{{ $skd->id_sk_domisili  }}').submit();
                                                            }
                                                        });
                                                    });

                                                    // Menambahkan event listener ke tombol 'Unduh'
                                                    $('#unduhButton').click(function() {
                                                        // Mendapatkan jenis surat dan id surat dari baris tabel terpilih
                                                        var jenisSurat = $('.selected-row').attr('data-jenis-surat');
                                                        var idSurat = $('.selected-row').attr('data-id-surat');

                                                        // Membuat URL unduhan berdasarkan jenis surat dan id surat
                                                        var url = "{{ route('unduh_surat', ['jenis_surat' => ':jenis_surat', 'id_surat' => ':id_surat']) }}";
                                                        url = url.replace(':jenis_surat', jenisSurat).replace(':id_surat', idSurat);

                                                        // Mengarahkan jendela baru untuk mengunduh surat
                                                        window.open(url, '_blank');
                                                    });
                                                </script>
                                            </td>
                                        </tr>
                                    @endforeach

                                    @foreach(\App\Models\SKTidakMampu::where('status_surat', '=', 'Disetujui')->get() as $sktm)
                                        <tr>
                                            <td class="text-center align-middle">{{ $sktm->tanggal }}</td>
                                            <td class="text-center align-middle">{{ $sktm->jenis_surat }}</td>
                                            <td class="text-center align-middle">{{ $sktm->nik }}</td>
                                            <td class="text-center align-middle">{{ $sktm->nama }}</td>
                                            <td class="text-center align-middle">{{ $sktm->status_surat }}</td>
                                            <td class="text-center align-middle">{{ $sktm->verifikator }}</td>
                                            <td class="text-center">
                                                <div class="d-flex justify-content-center">
                                                    <a href="{{ route('unduh_sk_tidak_mampu', ['id_sk_tidak_mampu' => $sktm->id_sk_tidak_mampu]) }}" target="_blank" class="btn btn-info btn-sm" style="margin-right: 10px;">Unduh</a> 

                                                    <form method="POST" action="{{ route('sktm_selesai', $sktm->id_sk_tidak_mampu) }}" id="selesai-surat-{{ $sktm->id_sk_tidak_mampu  }}">
                                                        @csrf
                                                        @method('PUT')
                                                        <button type="button" id="btnSelesai-{{ $sktm->id_sk_tidak_mampu  }}" class="btn btn-primary btn-sm">Selesai</button>
                                                    </form>
                                                </div>
                                                <script>
                                                    $('#btnSelesai-{{ $sktm->id_sk_tidak_mampu  }}').click(function(event){
                                                        event.preventDefault();
                                                        Swal.fire({
                                                            icon: "info",
                                                            title: "Konfirmasi",
                                                            text: "Apakah Anda yakin ingin mengirim data ini?",
                                                            showCancelButton: true,
                                                            confirmButtonText: "Ya, Lanjutkan",
                                                            cancelButtonText: "Tidak, Batalkan",
                                                        }).then(function (result) {
                                                            if (result.isConfirmed) {
                                                                $('#selesai-surat-{{ $sktm->id_sk_tidak_mampu  }}').submit();
                                                            }
                                                        });
                                                    });

                                                    // Menambahkan event listener ke tombol 'Unduh'
                                                    $('#unduhButton').click(function() {
                                                        // Mendapatkan jenis surat dan id surat dari baris tabel terpilih
                                                        var jenisSurat = $('.selected-row').attr('data-jenis-surat');
                                                        var idSurat = $('.selected-row').attr('data-id-surat');

                                                        // Membuat URL unduhan berdasarkan jenis surat dan id surat
                                                        var url = "{{ route('unduh_surat', ['jenis_surat' => ':jenis_surat', 'id_surat' => ':id_surat']) }}";
                                                        url = url.replace(':jenis_surat', jenisSurat).replace(':id_surat', idSurat);

                                                        // Mengarahkan jendela baru untuk mengunduh surat
                                                        window.open(url, '_blank');
                                                    });
                                                </script>
                                            </td>
                                        </tr>
                                    @endforeach --}}
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
            $('.table').DataTable({
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