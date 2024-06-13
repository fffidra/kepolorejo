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
                            <h5>SURAT KETERANGAN DOMISILI</h5>
                        </div>                   
                        <div class="container-fluid table-responsive px-3 py-3">
                            <p>
                                <b>Surat Keterangan Domisili (SKD)</b> adalah dokumen resmi yang dikeluarkan oleh pemerintah desa atau kelurahan untuk memberikan keterangan bahwa seseorang bertempat tinggal di wilayah tersebut. SKD ini sering digunakan untuk:
                                <br>
                                1. Melengkapi persyaratan administrasi, seperti pendaftaran sekolah atau pendaftaran kerja
                                <br>
                                2. Keperluan pengurusan izin tinggal atau perpindahan domisili
                                <br>
                                3. Keperluan administratif lain yang memerlukan bukti tempat tinggal
                                <br><br><br>

                                <b>Note: </b>
                                <br>
                                - Anda tidak dapat mengajukan jenis surat yang sama, jika status surat masih <b>'Diproses'</b> atau <b>'Disetujui'</b>
                                <br>
                                - Surat dapat diambil di Kantor Kelurahan Kepolorejo, setelah status surat berubah menjadi <b>'Selesai'</b>
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