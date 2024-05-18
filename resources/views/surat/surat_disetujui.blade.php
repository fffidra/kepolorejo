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
                            <h5>Data Surat Disetujui</h5>
                        </div>
                        <div class="container-fluid table-responsive px-3 py-3">
                            <table class="table table-striped" id="tabelSPT" style="width:100%">
                                <thead>
                                    <tr>
                                        <th class="col-md-1 text-center align-middle">Tanggal Pengajuan</th>                           
                                        <th class="col-md-2 text-center align-middle">Jenis Surat</th>                           
                                        <th class="col-md-2 text-center align-middle">NIK</th>                           
                                        <th class="col-md-2 text-center align-middle">Nama</th>                           
                                        <th class="col-md-1 text-center align-middle">Status</th>                           
                                        <th class="col-md-1 text-center align-middle">Verifikator</th>                           
                                        <th class="col-md-2 text-center align-middle">Aksi</th>                           
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach(\App\Models\SKUsaha::where('status_surat', '=', 'Disetujui')->get() as $sk_usaha)
                                        <tr>
                                            <td class="text-center align-middle">{{ $sk_usaha->tanggal }}</td>
                                            <td class="text-center align-middle">{{ $sk_usaha->jenis_surat }}</td>
                                            <td class="text-center align-middle">{{ $sk_usaha->nik }}</td>
                                            <td class="text-center align-middle">{{ $sk_usaha->nama }}</td>
                                            <td class="text-center align-middle">{{ $sk_usaha->status_surat }}</td>
                                            <td class="text-center align-middle">{{ $sk_usaha->verifikator }}</td>
                                            <td class="text-center">
                                                <div class="d-flex justify-content-center">
                                                    <button type="button" data-bs-toggle="modal" data-bs-target="#detailSKU" data-bs-id="{{ $sk_usaha->id_sk_usaha }}" class="btn btn-info btn-sm">Detail</button>

                                                    <a href="{{ route('unduh_sk_usaha', ['id_sk_usaha' => $sk_usaha->id_sk_usaha]) }}" target="_blank" class="btn btn-info btn-sm" style="margin-right: 10px;">Unduh</a> 

                                                    {{-- <button type="button" data-bs-toggle="modal" data-bs-target="#modalDokumen" data-bs-id="{{ $surat->id_surat }}" class="btn btn-info btn-sm">Ubah</button> --}}

                                                    <form method="POST" action="{{ route('sku_selesai', $sk_usaha->id_sk_usaha) }}" id="selesai-surat-{{ $sk_usaha->id_sk_usaha  }}">
                                                        @csrf
                                                        @method('PUT')
                                                        <button type="button" id="btnSelesai-{{ $sk_usaha->id_sk_usaha  }}" class="btn btn-primary btn-sm">Selesai</button>
                                                    </form>
                                                </div>
                                                <script>
                                                    $('#btnSelesai-{{ $sk_usaha->id_sk_usaha  }}').click(function(event){
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
                                                                $('#selesai-surat-{{ $sk_usaha->id_sk_usaha  }}').submit();
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

                                    @foreach(\App\Models\SKBelumMenikah::where('status_surat', '=', 'Disetujui')->get() as $sk_bm)
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

                                                    {{-- <button type="button" data-bs-toggle="modal" data-bs-target="#modalDokumen" data-bs-id="{{ $surat->id_surat }}" class="btn btn-info btn-sm">Ubah</button> --}}

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

                                                    {{-- <button type="button" data-bs-toggle="modal" data-bs-target="#modalDokumen" data-bs-id="{{ $surat->id_surat }}" class="btn btn-info btn-sm">Ubah</button> --}}

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

                                                    {{-- <button type="button" data-bs-toggle="modal" data-bs-target="#modalDokumen" data-bs-id="{{ $surat->id_surat }}" class="btn btn-info btn-sm">Ubah</button> --}}

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
    {{-- <div class="modal fade" id="modalDokumen" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Input Surat</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form id="uploadForm" method="POST" action="{{ route('dokumen_surat') }}" enctype="multipart/form-data">
                        @csrf
                        <div class="form-group row">
                            <label for="dokumen_surat" class="col-md-4 col-form-label text-md-right">Dokumen Surat</label>
                            <div class="col-md-8">
                                <input type="file" class="form-control" name="dokumen_surat" id="dokumen_surat" value="{{ old('dokumen_surat') }}">
                            </div>
                        </div>
                        <div class="form-group row">
                            <div class="col-md-8 offset-md-4">
                                <button type="submit" class="btn btn-primary">Simpan</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div> --}}

    {{-- DETAIL SKU --}}
    <div class="modal fade" id="detailSKU" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">DETAIL SURAT KETERANGAN USAHA</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <input type="hidden" name="id_sk_usaha" id="id_sk_usaha" required>
                    <div class="row mb-1">
                        <label class="col-md-2 col-form-label">Jenis Surat</label>
                        <div class="col-md-9 d-flex align-items-center">
                            <span>:&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<label class="form-label" id="detail_jenis_surat"></label></span>
                        </div>
                    </div>
                    <div class="row mb-1">
                        <label class="col-md-2 col-form-label">Nama</label>
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
                        <label class="col-md-2 col-form-label">Tempat, Tanggal Lahir</label>
                        <div class="col-md-9 d-flex align-items-center">
                            <span>:&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<label class="form-label" id="detail_ttl"></label></span>
                        </div>
                    </div>
                    <div class="row mb-1">
                        <label class="col-md-2 col-form-label">Status Nikah</label>
                        <div class="col-md-9 d-flex align-items-center">
                            <span>:&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<label class="form-label" id="detail_status_nikah"></label></span>
                        </div>
                    </div>
                    <div class="row mb-1">
                        <label class="col-md-2 col-form-label">Agama</label>
                        <div class="col-md-9 d-flex align-items-center">
                            <span>:&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<label class="form-label" id="detail_agama"></label></span>
                        </div>
                    </div>
                    <div class="row mb-1">
                        <label class="col-md-2 col-form-label">Pekerjaan</label>
                        <div class="col-md-9 d-flex align-items-center">
                            <span>:&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<label class="form-label" id="detail_pekerjaan"></label></span>
                        </div>
                    </div>
                    <div class="row mb-1">
                        <label class="col-md-2 col-form-label">Alamat</label>
                        <div class="col-md-9 d-flex align-items-center">
                            <span>:&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<label class="form-label" id="detail_alamat"></label></span>
                        </div>
                    </div>
                    <div class="row mb-1">
                        <label class="col-md-2 col-form-label">Usaha</label>
                        <div class="col-md-9 d-flex align-items-center">
                            <span>:&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<label class="form-label" id="detail_usaha"></label></span>
                        </div>
                    </div>
                    <div class="row mb-1">
                        <label class="col-md-2 col-form-label">Keperluan</label>
                        <div class="col-md-9 d-flex align-items-center">
                            <span>:&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<label class="form-label" id="detail_keperluan"></label></span>
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
                        $("#detail_jenis_surat").html(surat.jenis_surat);
                        $("#detail_nama").html(surat.nama);
                        $("#detail_nik").html(surat.nik);
                        $("#detail_ttl").html(surat.ttl);
                        $("#detail_status_nikah").html(surat.status_nikah);
                        $("#detail_agama").html(surat.agama);
                        $("#detail_alamat").html(surat.alamat);
                        $("#detail_usaha").html(surat.usaha);
                        $("#detail_keperluan").html(surat.keperluan);

                        if (surat.pekerjaan === 'Lainnya') {
                            $("#detail_pekerjaan").html(surat.pekerjaan_lainnya);
                            $("#pekerjaan_lainnya_row").show();
                        } else {
                            $("#detail_pekerjaan").html(surat.pekerjaan);
                            $("#pekerjaan_lainnya_row").hide();
                        }
                    }
                },
            });
        });
    </script>
@endsection