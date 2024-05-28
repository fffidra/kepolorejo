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
                            <h5>DATA SURAT KETERANGAN BELUM MENIKAH</h5>
                        </div>
                        <div class="container-fluid table-responsive px-3 py-3">
                            <table class="table table-striped" id="tabelSPT" style="width:100%">
                                <thead>
                                    <tr>
                                        <th class="col-md-1 text-center align-middle">TANGGAL PENGAJUAN</th>                           
                                        <th class="col-md-2 text-center align-middle">JENIS SURAT</th>                           
                                        <th class="col-md-2 text-center align-middle">NIK</th>                           
                                        <th class="col-md-2 text-center align-middle">NAMA</th>                           
                                        <th class="col-md-1 text-center align-middle">STATUS</th>                           
                                        <th class="col-md-2 text-center align-middle">AKSI</th>                           
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach(\App\Models\SKBelumMenikah::where('status_surat', 'Selesai')->get() as $skbm)
                                        <tr>      
                                            <td class="text-center align-middle">{{ $skbm->tanggal }}</td>
                                            <td class="text-center align-middle">{{ $skbm->jenis_surat }}</td>
                                            <td class="text-center align-middle">{{ $skbm->nik }}</td>
                                            <td class="text-center align-middle">{{ $skbm->nama }}</td>
                                            <td class="text-center align-middle">{{ $skbm->status_surat }}</td>
                                            <td class="text-center">
                                                <div class="d-flex justify-content-center">
                                                    <button type="button" data-bs-toggle="modal" data-bs-target="#detailSKBM" data-bs-id="{{ $skbm->id_sk_belum_menikah }}" class="btn btn-primary btn-sm me-1">Detail</button>
                                                </div>
                                                <script>
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
    {{-- DETAIL SKBM --}}
    <div class="modal fade" id="detailSKBM" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">DETAIL SURAT KETERANGAN BELUM MENIKAH</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <input type="hidden" name="id_sk_belum_menikah" id="id_sk_belum_menikah" required>
                    <div class="row mb-1">
                        <label class="col-md-2 col-form-label">Jenis Surat</label>
                        <div class="col-md-9 d-flex align-items-center">
                            <span>:&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<label class="form-label" id="detail_jenis_surat_2"></label></span>
                        </div>
                    </div>
                    <div class="row mb-1">
                        <label class="col-md-2 col-form-label">Nama</label>
                        <div class="col-md-9 d-flex align-items-center">
                            <span>:&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<label class="form-label" id="detail_nama_2"></label></span>
                        </div>
                    </div>
                    <div class="row mb-1">
                        <label class="col-md-2 col-form-label">NIK</label>
                        <div class="col-md-9 d-flex align-items-center">
                            <span>:&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<label class="form-label" id="detail_nik_2"></label></span>
                        </div>
                    </div>
                    <div class="row mb-1">
                        <label class="col-md-2 col-form-label">Tempat, Tanggal Lahir</label>
                        <div class="col-md-9 d-flex align-items-center">
                            <span>:&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<label class="form-label" id="detail_ttl_2"></label></span>
                        </div>
                    </div>
                    <div class="row mb-1">
                        <label class="col-md-2 col-form-label">Status Nikah</label>
                        <div class="col-md-9 d-flex align-items-center">
                            <span>:&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<label class="form-label" id="detail_status_nikah_2"></label></span>
                        </div>
                    </div>
                    <div class="row mb-1">
                        <label class="col-md-2 col-form-label">Agama</label>
                        <div class="col-md-9 d-flex align-items-center">
                            <span>:&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<label class="form-label" id="detail_agama_2"></label></span>
                        </div>
                    </div>
                    <div class="row mb-1">
                        <label class="col-md-2 col-form-label">Pekerjaan</label>
                        <div class="col-md-9 d-flex align-items-center">
                            <span>:&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<label class="form-label" id="detail_pekerjaan_2"></label></span>
                        </div>
                    </div>
                    <div class="row mb-1">
                        <label class="col-md-2 col-form-label">Alamat</label>
                        <div class="col-md-9 d-flex align-items-center">
                            <span>:&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<label class="form-label" id="detail_alamat_2"></label></span>
                        </div>
                    </div>
                    <div class="row mb-1">
                        <label class="col-md-2 col-form-label">Keperluan</label>
                        <div class="col-md-9 d-flex align-items-center">
                            <span>:&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<label class="form-label" id="detail_keperluan_2"></label></span>
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

        // DETAIL SKBM
        $('#detailSKBM').on('show.bs.modal', function (event) {
            var button = $(event.relatedTarget);
            $.ajax({
                url: '{{ route("get_data_skbm") }}',
                type: 'POST',
                data: {
                    id: button.data('bs-id'),
                    _token: '{{ csrf_token() }}',
                },
                dataType: 'JSON',
                success: function(response) {
                    if (response.status == 'success') {
                        var surat = response.surat;
                        $("#detail_jenis_surat_2").html(surat.jenis_surat);
                        $("#detail_nama_2").html(surat.nama);
                        $("#detail_nik_2").html(surat.nik);
                        $("#detail_ttl_2").html(surat.ttl);
                        $("#detail_status_nikah_2").html(surat.status_nikah);
                        $("#detail_agama_2").html(surat.agama);
                        $("#detail_alamat_2").html(surat.alamat);
                        $("#detail_keperluan_2").html(surat.keperluan);

                        if (surat.pekerjaan === 'Lainnya') {
                            $("#detail_pekerjaan_2").html(surat.pekerjaan_lainnya);
                            $("#pekerjaan_lainnya_2_row").show();
                        } else {
                            $("#detail_pekerjaan_2").html(surat.pekerjaan);
                            $("#pekerjaan_lainnya_2_row").hide();
                        }
                    }
                },
            });
        });
    </script>
@endsection