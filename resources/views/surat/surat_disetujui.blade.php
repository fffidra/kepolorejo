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
                                        <th class="col-md-2 text-center align-middle">NIK</th>                           
                                        <th class="col-md-2 text-center align-middle">Jenis Surat</th>                           
                                        <th class="col-md-2 text-center align-middle">Nama</th>                           
                                        <th class="col-md-2 text-center align-middle">Status</th>                           
                                        <th class="col-md-2 text-center align-middle">Aksi</th>                           
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach(\App\Models\Surat::where('status_surat', '=', 'Disetujui')->get() as $surat)
                                    <tr>
                                        <td class="text-center align-middle">{{ $surat->nik_warga }}</td>
                                        <td class="text-center align-middle">{{ $surat->jenis_surat }}</td>
                                        <td class="text-center align-middle">{{ $surat->nama_warga }}</td>
                                        <td class="text-center align-middle">{{ $surat->status_surat }}</td>
                                        <td class="text-center">
                                            <div class="d-flex justify-content-center">
                                                <a href="{{ route('unduh_surat', ['jenis_surat' => $surat->jenis_surat, 'id_surat' => $surat->id_surat]) }}" target="_blank" class="btn btn-info btn-sm" style="margin-right: 10px;">Unduh</a> 
                                                <form method="POST" action="{{ route('surat_selesai', $surat->id_surat) }}" id="selesai-surat-{{ $surat->id_surat  }}">
                                                    @csrf
                                                    @method('PUT')
                                                    <button type="button" id="btnSelesai-{{ $surat->id_surat  }}" class="btn btn-primary btn-sm">Selesai</button>
                                                </form>
                                            </div>
                                            <script>
                                                $('#btnSelesai-{{ $surat->id_surat  }}').click(function(event){
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
                                                            $('#selesai-surat-{{ $surat->id_surat  }}').submit();
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
@endsection

@section('script')
@endsection