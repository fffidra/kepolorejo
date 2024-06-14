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
                                            <td class="text-center align-middle">{{ $skbm->sk_belum_menikah_ibfk_4->nama_jenis_surat }}</td>
                                            <td class="text-center align-middle">{{ $skbm->nik }}</td>
                                            <td class="text-center align-middle">{{ $skbm->nama }}</td>
                                            <td class="text-center align-middle">{{ $skbm->status_surat }}</td>
                                            <td class="text-center align-middle">
                                                <div class="d-flex justify-content-center">
                                                    <button type="button" data-bs-toggle="modal" data-bs-target="#detailSKBM" data-bs-id="{{ $skbm->id_sk_belum_menikah }}" class="btn btn-primary btn-sm me-1">Detail</button>
                                                    <form method="POST" action="{{ route('hapus_skbm', $skbm->id_sk_belum_menikah) }}" id="hapus-surat-{{ $skbm->id_sk_belum_menikah }}" class="d-inline">
                                                        @csrf
                                                        @method('DELETE')
                                                        <button type="button" id="btnHapus-{{ $skbm->id_sk_belum_menikah }}" class="btn btn-danger btn-sm mx-1"><i class="bx bx-trash-alt"></i></button>
                                                    </form>
                                                </div>
                                                <script>
                                                    $('#btnHapus-{{ $skbm->id_sk_belum_menikah }}').click(function(event){
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
                                                                $('#hapus-surat-{{ $skbm->id_sk_belum_menikah }}').submit();
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
    {{-- DETAIL SKBM --}}
    <div class="modal fade" id="detailSKBM" tabindex="-1" aria-hidden="true" data-bs-backdrop="static">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title"><strong>DETAIL SURAT KETERANGAN BELUM MENIKAH</strong></h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <input type="hidden" name="id_sk_belum_menikah" id="id_sk_belum_menikah" required>
                    <div class="row mb-1">
                        <label class="col-md-2 col-form-label">JENIS SURAT</label>
                        <div class="col-md-9 d-flex align-items-center">
                            <span>:&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<label class="form-label" id="detail_jenis_surat_3"></label></span>
                        </div>
                    </div>
                    <div class="row mb-1">
                        <label class="col-md-2 col-form-label">NAMA</label>
                        <div class="col-md-9 d-flex align-items-center">
                            <span>:&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<label class="form-label" id="detail_nama_3"></label></span>
                        </div>
                    </div>
                    <div class="row mb-1">
                        <label class="col-md-2 col-form-label">NIK</label>
                        <div class="col-md-9 d-flex align-items-center">
                            <span>:&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<label class="form-label" id="detail_nik_3"></label></span>
                        </div>
                    </div>
                    <div class="row mb-1">
                        <label class="col-md-2 col-form-label">TEMPAT, TANGGAL LAHIR</label>
                        <div class="col-md-9 d-flex align-items-center">
                            <span>:&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<label class="form-label" id="detail_ttl_3"></label></span>
                        </div>
                    </div>
                    <div class="row mb-1">
                        <label class="col-md-2 col-form-label">STATUS NIKAH</label>
                        <div class="col-md-9 d-flex align-items-center">
                            <span>:&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<label class="form-label" id="detail_status_nikah_3"></label></span>
                        </div>
                    </div>
                    <div class="row mb-1">
                        <label class="col-md-2 col-form-label">AGAMA</label>
                        <div class="col-md-9 d-flex align-items-center">
                            <span>:&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<label class="form-label" id="detail_agama_3"></label></span>
                        </div>
                    </div>
                    <div class="row mb-1">
                        <label class="col-md-2 col-form-label">PEKERJAAN</label>
                        <div class="col-md-9 d-flex align-items-center">
                            <span>:&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<label class="form-label" id="detail_pekerjaan_3"></label></span>
                        </div>
                    </div>
                    <div class="row mb-1">
                        <label class="col-md-2 col-form-label">ALAMAT</label>
                        <div class="col-md-9 d-flex align-items-center">
                            <span>:&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<label class="form-label" id="detail_alamat_3"></label></span>
                        </div>
                    </div>
                    <div class="row mb-1">
                        <label class="col-md-2 col-form-label">KEPERLUAN</label>
                        <div class="col-md-9 d-flex align-items-center">
                            <span>:&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<label class="form-label" id="detail_keperluan_3"></label></span>
                        </div>
                    </div>
                    <div class="row mb-1">
                        <label class="col-md-2 col-form-label">BERKAS PERSYARATAN</label>
                        <div class="col-md-9">
                            <div class="d-flex">
                                <span>:&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</span>
                                <ul class="list-unstyled mb-0 w-100">
                                    <li id="suket" class="row align-items-center mb-2">
                                        <div class="col-md-6">
                                            <label class="form-label mb-0">Surat Pengantar RT/RW</label>
                                        </div>
                                        <div class="col-md-6">
                                            <a id="detail_bukti_suket_3" class="btn btn-primary btn-sm w-100" href="#" target="_blank">Unduh</a>
                                        </div>
                                    </li>
                                    <li id="kk" class="row align-items-center mb-2">
                                        <div class="col-md-6">
                                            <label class="form-label mb-0">Kartu Keluarga (KK)</label>
                                        </div>
                                        <div class="col-md-6">
                                            <a id="detail_bukti_kk_3" class="btn btn-primary btn-sm w-100" href="#" target="_blank">Unduh</a>
                                        </div>
                                    </li>
                                    <li id="ktp" class="row align-items-center mb-2">
                                        <div class="col-md-6">
                                            <label class="form-label mb-0">Kartu Tanda Penduduk (KTP)</label>
                                        </div>
                                        <div class="col-md-6">
                                            <a id="detail_bukti_ktp_3" class="btn btn-primary btn-sm w-100" href="#" target="_blank">Unduh</a>
                                        </div>
                                    </li>
                                    <li id="akta_cerai" class="row align-items-center mb-2">
                                        <div class="col-md-6">
                                            <label class="form-label mb-0">Akta Cerai</label>
                                        </div>
                                        <div class="col-md-6">
                                            <a id="detail_bukti_cerai_3" class="btn btn-primary btn-sm w-100" href="#" target="_blank">Unduh</a>
                                        </div>
                                    </li>
                                    <li id="akta_kematian" class="row align-items-center mb-2">
                                        <div class="col-md-6">
                                            <label class="form-label mb-0">Akta Kematian</label>
                                        </div>
                                        <div class="col-md-6">
                                            <a id="detail_bukti_kematian_3" class="btn btn-primary btn-sm w-100" href="#" target="_blank">Unduh</a>
                                        </div>
                                    </li>
                                </ul>
                            </div>
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

        // DETAIL SKTM
        $('#detailSKTM').on('show.bs.modal', function (event) {
            var button = $(event.relatedTarget);
            $.ajax({
                url: '{{ route("get_data_sktm") }}',
                type: 'POST',
                data: {
                    id: button.data('bs-id'),
                    _token: '{{ csrf_token() }}',
                },
                dataType: 'JSON',
                success: function(response) {
                    if (response.status == 'success') {
                        var surat = response.surat;
                        $("#detail_jenis_surat_4").html(response.jenis_surat);
                        $("#detail_nama_4").html(surat.nama);
                        $("#detail_nik_4").html(surat.nik);
                        $("#detail_ttl_4").html(surat.ttl);
                        $("#detail_agama_4").html(response.agama);
                        $("#detail_pekerjaan_4").html(response.pekerjaan);
                        $("#detail_alamat_4").html(surat.alamat);
                        $("#detail_keperluan_4").html(surat.keperluan);
                        $("#detail_bukti_suket_4").attr("href", '/bukti_dokumen/SKTM/' + surat.bukti_suket);
                        $("#detail_bukti_kk_4").attr("href", '/bukti_dokumen/SKTM/' + surat.bukti_kk);
                        $("#detail_bukti_ktp_4").attr("href", '/bukti_dokumen/SKTM/' + surat.bukti_ktp);

                        if (response.pekerjaan === 'Lainnya') {
                            $("#detail_pekerjaan_4").html(response.pekerjaan_lainnya);
                            $("#pekerjaan_lainnya_4_row").show();
                        } else {
                            $("#detail_pekerjaan_4").html(response.pekerjaan);
                            $("#pekerjaan_lainnya_4_row").hide();
                        }
                    }
                },
            });
        });
    </script>
@endsection