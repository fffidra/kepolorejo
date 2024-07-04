@extends('layout.app')

@section('title')
    Data Pengajuan Surat
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
                            <h5><b>SURAT KETERANGAN TIDAK MAMPU</b></h5>
                        </div>                   
                        <div class="container-fluid table-responsive px-3 py-3">
                            <p>
                                <b>Surat Keterangan Tidak Mampu (SKTM)</b> adalah dokumen resmi yang dikeluarkan oleh pemerintah desa atau kelurahan untuk memberikan keterangan bahwa seseorang atau keluarga tersebut tergolong kurang mampu secara ekonomi. SKTM ini biasanya digunakan untuk:
                                <br>
                                1. Mengajukan bantuan sosial atau subsidi dari pemerintah
                                <br>
                                2. Mendapatkan keringanan biaya pendidikan atau kesehatan
                                <br>
                                3. Keperluan administratif lain yang membutuhkan bukti kondisi ekonomi pemohon

                                <br><br>

                                <b>Berkas Persyaratan: </b>
                                <br>
                                - Surat Pengantar RT/RW
                                <br>
                                - Kartu Keluarga (KK)
                                <br>
                                - Kartu Tanda Penduduk (KTP)

                                <br><br><br>

                                <b>Note:</b>
                                <br>
                                <b>1) </b>Anda tidak dapat mengajukan jenis surat yang sama, jika status surat masih <b>Diproses</b> atau <b>Disetujui</b>
                                <br>
                                <b>2) </b>Anda harus mengajukan ulang surat yang <b>Ditolak</b>
                                <br>
                                <b>3) </b>Anda dapat mengunduh surat yang selesai diproses pada tombol <b>Unduh</b>, setelah status surat berubah menjadi <b>Selesai</b>
                            </p>
                        </div>
                    </div>
                </div>
            </div>
            @include('layout.footer')
        </div>
    </div>
@endsection

@section('script')
    <script>  
    </script>
@endsection