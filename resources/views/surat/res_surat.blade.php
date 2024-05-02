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
                        {{-- <div class="page-title-box bg-light-subtle rounded-3 d-flex align-items-center justify-content-between px-3 py-2">
                            <h5>List Data SPT</h5>
                            @if(Auth::user()->nama_jabatan == 'Inspektur Pembantu')
                                <button data-bs-toggle="modal" data-bs-target="#tambahsptbaru" class="btn btn-primary">Tambah SPT</button>
                            @endif
                        </div> --}}
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
                                    @foreach(\App\Models\Surat::where('status_surat', '=', 'Diproses')->orWhere('status_surat','=', 'Ditolak')->get() as $surat)
                                    <tr>
                                        <td class="text-center align-middle">{{ $surat->nik_warga }}</td>
                                        <td class="text-center align-middle">{{ $surat->jenis_surat }}</td>
                                        <td class="text-center align-middle">{{ $surat->nama_warga }}</td>
                                        <td class="text-center align-middle">{{ $surat->status_surat }}</td>
                                        <td class="text-center">
                                            <div class="d-flex justify-content-center">
                                                <a role="button" class="btn btn-warning me-2" title="Ubah Data" style="padding: 0.25rem 0.5rem; font-size: 18px;" data-bs-toggle="modal" data-bs-target="#modalUbah" data-bs-id="{{ $surat->id_surat }}"><i class="bx bx-pencil"></i></a>

                                                <button type="button" data-bs-toggle="modal" data-bs-target="#modalDetail" data-bs-id="{{ $surat->id_surat }}" class="btn btn-info btn-sm">Detail</button>

                                                {{-- <button type="button" data-bs-toggle="modal" data-bs-target="#modalDetail" data-bs-id="{{ $surat->id_surat }}" data-bs-jenis-surat="{{ $surat->jenis_surat }}" class="btn btn-info btn-sm">Detail</button> --}}

                                                @if($surat->status_surat === 'Diproses')
                                                    <form method="POST" action="{{ route('verifikasi_surat', $surat->id_surat) }}" id="verifikasi-surat-{{ $surat->id_surat }}">
                                                        @csrf
                                                        @method('PUT')
                                                        <button type="button" id="btnVerifikasi-{{ $surat->id_surat }}" class="btn btn-primary btn-sm">Verifikasi</button>
                                                    </form>
                                                @endif
                                                @if($surat->status_surat === 'Ditolak')
                                                    <form method="POST" action="{{ route('hapus_surat', $surat->id_surat) }}" id="hapus-surat-{{ $surat->id_surat }}">
                                                        @csrf
                                                        @method('DELETE')
                                                        <a role="button" id="btnHapus-{{ $surat->id_surat }}" class="btn btn-danger" title="Hapus Data"style="padding: 0.25rem 0.5rem; font-size: 18px;"><i class="bx bx-trash-alt"></i></a>
                                                    </form>
                                                @endif
                                            </div>
                                            <script>
                                                $('#btnVerifikasi-{{ $surat->id_surat }}').click(function(event){
                                                    event.preventDefault();
                                                    Swal.fire({
                                                        icon: "info",
                                                        title: "Konfirmasi",
                                                        text: "Apakah Anda yakin ingin mengirim data ini?",
                                                        showDenyButton: true,
                                                        showCancelButton: true,
                                                        confirmButtonText: "Setuju",
                                                        denyButtonText: "Tolak",
                                                        cancelButtonText: "Batal",
                                                    }).then((result) => {
                                                        /* Read more about isConfirmed, isDenied below */
                                                        if (result.isConfirmed) {
                                                            $('#verifikasi-surat-{{ $surat->id_surat }}')
                                                                .append('<input type="hidden" name="aksi" value="setuju" required>')
                                                                .submit();
                                                        } else if (result.isDenied) {
                                                            $('#verifikasi-surat-{{ $surat->id_surat }}')
                                                                .append('<input type="hidden" name="aksi" value="tolak" required>')
                                                                .submit();
                                                        }
                                                    });
                                                });

                                                $('#btnHapus-{{ $surat->id_surat }}').click(function(event){
                                                        event.preventDefault();
                                                        Swal.fire({
                                                            icon: "info",
                                                            title: "Konfirmasi",
                                                            text: "Apakah Anda yakin ingin menghapus data ini?",
                                                            showCancelButton: true,
                                                            confirmButtonText: "Ya, Lanjutkan",
                                                            cancelButtonText: "Tidak, Batalkan",
                                                        }).then(function (result) {
                                                            if (result.isConfirmed) {
                                                                $('#hapus-surat-{{ $surat->id_surat }}').submit();
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
    {{-- MODAL UBAH --}}
    <div class="modal fade" id="modalUbah" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="modalUbahLabel">Ubah Data surat</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <!-- Form untuk mengubah data -->
                <form method="POST" action="{{ route('edit_surat') }}" id="formUbah">
                    @csrf
                    @method('PUT')
                    <input type="hidden" name="id_surat" id="id_surat" required>
                    <div class="modal-body">
                        <div class="mb-3 row">
                            <label for="jenis_surat" class="col-md-2 col-form-label">Jenis Surat</label>
                            <div class="col-md-9">
                                <input type="text" class="form-control" id="jenis_surat" name="jenis_surat" readonly>
                            </div>
                        </div>
                        <div class="mb-3 row">
                            <label for="ubah_nama_warga" class="col-md-2 col-form-label">Nama</label>
                            <div class="col-md-9">
                                <textarea class="form-control" id="ubah_nama_warga" name="ubah_nama_warga" rows="1"></textarea>
                            </div>
                        </div>
                        <div class="mb-3 row">
                            <label for="ubah_nik_warga" class="col-md-2 col-form-label">NIK</label>
                            <div class="col-md-9">
                                <textarea class="form-control" id="ubah_nik_warga" name="ubah_nik_warga" rows="1"></textarea>
                            </div>
                        </div>
                        <div class="mb-3 row">
                            <label for="ubah_agama" class="col-md-2 col-form-label">agama</label>
                            <div class="col-md-9">
                                <select class="form-select" id="ubah_agama" name="ubah_agama">
                                    @foreach(\App\Models\Agama::all() as $agamas)
                                        <option value="{{ $agamas->nama_agama }}">{{ $agamas->nama_agama }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>                  
                        <div class="mb-3 row">
                            <label for="ubah_pekerjaan" class="col-md-2 col-form-label">work</label>
                            <div class="col-md-9">
                                <select class="form-select" id="ubah_pekerjaan" name="ubah_pekerjaan">
                                    @foreach(\App\Models\Pekerjaan::all() as $pekerjaans)
                                        <option value="{{ $pekerjaans->nama_pekerjaan }}">{{ $pekerjaans->nama_pekerjaan }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        {{-- <div class="mb-3 row">
                            <label for="ubah_status_nikah" class="col-md-2 col-form-label">Status Nikah</label>
                            <div class="col-md-9">
                                <select class="form-select" id="ubah_status_nikah" name="ubah_status_nikah">
                                    @foreach(\App\Models\Status::all() as $status_nikahs)
                                        <option value="{{ $status_nikahs->nama_status_nikah }}">{{ $status_nikahs->nama_status_nikah }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div> --}}
                        {{-- <div class="mb-3 row">
                            <label for="ubah_jenis_kelamin" class="col-md-2 col-form-label">Jenis Kelamin</label>
                            <div class="col-md-9">
                                <select class="form-select" id="ubah_jenis_kelamin" name="ubah_jenis_kelamin">
                                    @foreach(\App\Models\JenisKelamin::all() as $jenis_kelamins)
                                        <option value="{{ $jenis_kelamins->nama_jenis_kelamin }}">{{ $jenis_kelamins->nama_jenis_kelamin }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div> --}}
                        <div class="mb-3 row">
                            <label for="ubah_usaha" class="col-md-2 col-form-label">Usaha</label>
                            <div class="col-md-9">
                                <textarea class="form-control" id="ubah_usaha" name="ubah_usaha" rows="1"></textarea>
                            </div>
                        </div>
                        <div class="mb-3 row">
                            <label for="ubah_ttl" class="col-md-2 col-form-label">Tempat, Tanggal Lahir</label>
                            <div class="col-md-9">
                                <textarea class="form-control" id="ubah_ttl" name="ubah_ttl" rows="1"></textarea>
                            </div>
                        </div>
                        <div class="mb-3 row">
                            <label for="ubah_alamat" class="col-md-2 col-form-label">Alamat</label>
                            <div class="col-md-9">
                                <textarea class="form-control" id="ubah_alamat" name="ubah_alamat" rows="1"></textarea>
                            </div>
                        </div>
                        <div class="mb-3 row">
                            <label for="ubah_alamat_dom" class="col-md-2 col-form-label">Alamat Domisili</label>
                            <div class="col-md-9">
                                <textarea class="form-control" id="ubah_alamat_dom" name="ubah_alamat_dom" rows="1"></textarea>
                            </div>
                        </div>
                        <div class="mb-3 row">
                            <label for="ubah_alamat_dom" class="col-md-2 col-form-label">Keperluan</label>
                            <div class="col-md-9">
                                <textarea class="form-control" id="ubah_keperluan" name="ubah_keperluan" rows="1"></textarea>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Tutup</button>
                        <button type="submit" class="btn btn-warning" id="simpanPerubahan">Simpan Perubahan</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    {{-- MODAL DETAIL --}}
    <div class="modal fade" id="modalDetail" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Detail surat</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="mb-3 row">
                        <label class="col-md-2 col-form-label">jenis surat</label>
                        <span class="col-md-9 col-form-label" style="padding-top: 0;display: flex;padding-top: calc(.47rem + var(--bs-border-width));">:&nbsp;
                            <label class="col-form-label" id="detail_jenis_surat" style="padding-top: 0;"></label>
                        </span>
                    </div>
                    <div class="mb-3 row">
                        <label class="col-md-2 col-form-label">Nama</label>
                        <span class="col-md-9 col-form-label" style="padding-top: 0;display: flex;padding-top: calc(.47rem + var(--bs-border-width));">:&nbsp;
                            <label class="col-form-label" id="detail_nama" style="padding-top: 0;"></label>
                        </span>
                    </div>
                    <div class="mb-3 row">
                        <label class="col-md-2 col-form-label">nik</label>
                        <span class="col-md-9 col-form-label" style="padding-top: 0;display: flex;padding-top: calc(.47rem + var(--bs-border-width));">:&nbsp;
                            <label class="col-form-label" id="detail_nik" style="padding-top: 0;"></label>
                        </span>
                    </div>
                    <div class="mb-3 row">
                        <label class="col-md-2 col-form-label">agama</label>
                        <span class="col-md-9 col-form-label" style="padding-top: 0;display: flex;padding-top: calc(.47rem + var(--bs-border-width));">:&nbsp;
                            <label class="col-form-label" id="detail_agama" style="padding-top: 0;"></label>
                        </span>
                    </div>
                    <div class="mb-3 row">
                        <label class="col-md-2 col-form-label">pekerjaan</label>
                        <span class="col-md-9 col-form-label" style="padding-top: 0;display: flex;padding-top: calc(.47rem + var(--bs-border-width));">:&nbsp;
                            <label class="col-form-label" id="detail_pekerjaan" style="padding-top: 0;"></label>
                        </span>
                    </div>
                    <div class="mb-3 row">
                        <label class="col-md-2 col-form-label">status nikah</label>
                        <span class="col-md-9 col-form-label" style="padding-top: 0;display: flex;padding-top: calc(.47rem + var(--bs-border-width));">:&nbsp;
                            <label class="col-form-label" id="detail_status_nikah" style="padding-top: 0;"></label>
                        </span>
                    </div>
                    <div class="mb-3 row">
                        <label class="col-md-2 col-form-label">jenis kelamin</label>
                        <span class="col-md-9 col-form-label" style="padding-top: 0;display: flex;padding-top: calc(.47rem + var(--bs-border-width));">:&nbsp;
                            <label class="col-form-label" id="detail_jenis_kelamin" style="padding-top: 0;"></label>
                        </span>
                    </div>
                    <div class="mb-3 row">
                        <label class="col-md-2 col-form-label">usaha</label>
                        <span class="col-md-9 col-form-label" style="padding-top: 0;display: flex;padding-top: calc(.47rem + var(--bs-border-width));">:&nbsp;
                            <label class="col-form-label" id="detail_usaha" style="padding-top: 0;"></label>
                        </span>
                    </div>
                    <div class="mb-3 row">
                        <label class="col-md-2 col-form-label">ttl</label>
                        <span class="col-md-9 col-form-label" style="padding-top: 0;display: flex;padding-top: calc(.47rem + var(--bs-border-width));">:&nbsp;
                            <label class="col-form-label" id="detail_ttl" style="padding-top: 0;"></label>
                        </span>
                    </div>
                    <div class="mb-3 row">
                        <label class="col-md-2 col-form-label">alamat</label>
                        <span class="col-md-9 col-form-label" style="padding-top: 0;display: flex;padding-top: calc(.47rem + var(--bs-border-width));">:&nbsp;
                            <label class="col-form-label" id="detail_alamat" style="padding-top: 0;"></label>
                        </span>
                    </div>
                    <div class="mb-3 row">
                        <label class="col-md-2 col-form-label">alamat dom</label>
                        <span class="col-md-9 col-form-label" style="padding-top: 0;display: flex;padding-top: calc(.47rem + var(--bs-border-width));">:&nbsp;
                            <label class="col-form-label" id="detail_alamat_dom" style="padding-top: 0;"></label>
                        </span>
                    </div>
                    <div class="mb-3 row">
                        <label class="col-md-2 col-form-label">keperluan</label>
                        <span class="col-md-9 col-form-label" style="padding-top: 0;display: flex;padding-top: calc(.47rem + var(--bs-border-width));">:&nbsp;
                            <label class="col-form-label" id="detail_keperluan" style="padding-top: 0;"></label>
                        </span>
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
    function showForm(jenisSurat) {
        var forms = document.querySelectorAll('.form_surat');
        
        forms.forEach(function(form) {
            var formId = form.id.split("_").pop(); 
            if (formId === jenisSurat) {
                form.style.display = "block";
            } else {
                form.style.display = "none";
            }
        });
    }

    // MODAL EDIT DATA SUCCEED
    $('#modalUbah').on('show.bs.modal', function (event) {
        var button = $(event.relatedTarget);
        var id_surat = button.data('id_surat');

        $("#id_surat").val(id_surat);

        $.ajax({
            url: '{{ route("get_data_surat") }}',
            type: 'POST',
            data: {
                id: button.data('bs-id'),
                _token: '{{ csrf_token() }}',
            },
            dataType: 'JSON',
            success: function(response) {
                if (response.status == 'success') {
                    var surats = response.surats; 

                    $("#id_surat").val(surats.id_surat);
                    $("#jenis_surat").val(surats.jenis_surat);
                    $("#ubah_nama_warga").val(surats.nama_warga);
                    $("#ubah_nik_warga").val(surats.nik_warga);
                    $("#ubah_agama").val(surats.agama);
                    $("#ubah_pekerjaan").val(surats.pekerjaan);
                    $("#ubah_usaha").val(surats.usaha);
                    $("#ubah_ttl").val(surats.ttl);
                    $("#ubah_alamat").val(surats.alamat);
                    $("#ubah_alamat_dom").val(surats.alamat_dom);
                    $("#ubah_status_surat").val(surats.status_surat);
                    $("#ubah_keperluan").val(surats.keperluan);
                } 
            }, 
        }); 

        $(document).ready(function() {
            $('#simpanPerubahan').click(function(event){
                event.preventDefault(); // Mencegah pengiriman formulir secara default
                // var jenissurat = document.getElementById("jenis_surat");
                var namawarga = document.getElementById("ubah_nama_warga");
                var nikwarga = document.getElementById("ubah_nama_warga");
                var agamawarga = document.getElementById("ubah_agama");
                var pekerjaanwarga = document.getElementById("ubah_pekerjaan");
                var usahawarga = document.getElementById("ubah_usaha");
                var ttlwarga = document.getElementById("ubah_ttl");
                var alamatwarga = document.getElementById("ubah_alamat");
                var alamatdomwarga = document.getElementById("ubah_alamat_dom");
                var statussurat = document.getElementById("ubah_status_surat");
                var keperluanwarga = document.getElementById("ubah_keperluan");

                if (!namawarga.value) {
                    // Tampilkan pesan kesalahan jika ada input yang kosong
                    Swal.fire({
                        icon: "error",
                        title: "Oops...",
                        text: "Semua inputan wajib diisi!",
                    });
                } else {
                    // Tampilkan pesan konfirmasi jika semua input telah diisi
                    Swal.fire({
                        icon: "info",
                        title: "Konfirmasi",
                        text: "Apakah Anda yakin data sudah benar?",
                        showCancelButton: true,
                        confirmButtonText: "Ya, Lanjutkan",
                        cancelButtonText: "Tidak, Batalkan",
                    }).then(function (result) {
                        if (result.isConfirmed) {
                            // Jika pengguna mengonfirmasi, lanjutkan dengan pengiriman formulir
                            $('#formUbah').submit();
                        }
                    });
                }
            });
        });
    });


    $(document).ready(function () {
        $('.open-ubah-modal').click(function () {
            var surat_id = $(this).data('id');
            $('#id_surat').val(surat_id);
            $('#modalUbah').modal('show');
        });
    });

    $(document).on('click', '.btn-edit', function(e){
        e.preventDefault();
        var surat_id = $(this).val();

        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });

        $.ajax({
            type: "GET",
            url: "/ubah_isi_surat/"+surat_id,
            success: function (response) {
            console.log(response);
                $('#jenis_surat').val(response.surats.jenis_surat);
                $('#ubah_nama_warga').val(response.surats.nama_warga);
                $('#ubah_nik_warga').val(response.surats.nik_warga);
                $('#ubah_agama').val(response.surats.agama);
                $('#ubah_pekerjaan').val(response.surats.pekerjaan);
                $('#ubah_usaha').val(response.surats.usaha);
                $('#ubah_ttl').val(response.surats.ttl);
                $('#ubah_alamat').val(response.surats.alamat);
                $('#ubah_alamat_dom').val(response.surats.alamat_dom);
                $('#ubah_status_surat').val(response.surats.status_surat);
                $('#ubah_keperluan').val(response.surats.keperluan);
                $('#modalUbah').modal('show');                
            }
        });        
    });

    // MODAL DETAIL DATA NOT SUCCEED YET
    $('#modalDetail').on('show.bs.modal', function (event) {
        var button = $(event.relatedTarget)
        $.ajax({
            url: '{{ route("get_data_surat") }}',
            type: 'POST',
            data: {
                id: button.data('bs-id'),
                _token: '{{ csrf_token() }}',
            },
            dataType: 'JSON',
            success: function(response) {
                if (response.status == 'success') {
                    var surats = response.surats;
                    $("#detail_jenis_surat").html(surats.jenis_surat);
                    $("#detail_nama").html(surats.nama_warga);
                    $("#detail_nik").html(surats.nik_warga);
                    $("#detail_agama").html(surats.agama);
                    $("#detail_pekerjaan").html(surats.pekerjaan);
                    $("#detail_status_nikah").html(surats.status_nikah);
                    $("#detail_usaha").html(surats.usaha);
                    $("#detail_ttl").html(surats.ttl);
                    $("#detail_alamat").html(surats.alamat);
                    $("#detail_alamat_dom").html(surats.alamat_dom);
                    $("#detail_keperluan").html(surats.keperluan);
                    $("#detail_jenis_kelamin").html(surats.jenis_kelamin);
                }
            }, 
        });
    });

    $('#modalDetail').on('show.bs.modal', function (event) {
    var button = $(event.relatedTarget);
    $.ajax({
        url: '{{ route("get_data_surat") }}',
        type: 'POST',
        data: {
            id: button.data('bs-id'),
            _token: '{{ csrf_token() }}',
        },
        dataType: 'JSON',
        success: function(response) {
            if (response.status == 'success') {
                var surats = response.surats;
                // Hide all detail elements initially
                $(".modal-body .row").hide();
                // Show specific detail elements based on the type of surat
                switch(surats.jenis_surat) {
                    case "SURAT KETERANGAN DOMISILI":
                        $("#detail_jenis_surat").closest('.row').show();
                        $("#detail_nama").closest('.row').show();
                        $("#detail_nik").closest('.row').show();
                        $("#detail_jenis_kelamin").closest('.row').show();
                        $("#detail_ttl").closest('.row').show();
                        $("#detail_agama").closest('.row').show();
                        $("#detail_status_nikah").closest('.row').show();
                        $("#detail_pekerjaan").closest('.row').show();
                        $("#detail_alamat").closest('.row').show();
                        $("#detail_alamat_dom").closest('.row').show();
                        $("#detail_keperluan").closest('.row').show();
                        break;
                    case "SURAT KETERANGAN BELUM MENIKAH":
                        $("#detail_jenis_surat").closest('.row').show();
                        $("#detail_nama").closest('.row').show();
                        $("#detail_nik").closest('.row').show();
                        $("#detail_ttl").closest('.row').show();
                        $("#detail_status_nikah").closest('.row').show();
                        $("#detail_agama").closest('.row').show();
                        $("#detail_pekerjaan").closest('.row').show();
                        $("#detail_alamat").closest('.row').show();
                        $("#detail_keperluan").closest('.row').show();
                        break;
                    case "SURAT KETERANGAN USAHA":
                        $("#detail_jenis_surat").closest('.row').show();
                        $("#detail_nama").closest('.row').show();
                        $("#detail_nik").closest('.row').show();
                        $("#detail_ttl").closest('.row').show();
                        $("#detail_status_nikah").closest('.row').show();
                        $("#detail_agama").closest('.row').show();
                        $("#detail_pekerjaan").closest('.row').show();
                        $("#detail_alamat").closest('.row').show();
                        $("#detail_usaha").closest('.row').show();
                        $("#detail_keperluan").closest('.row').show();
                        break;
                    case "SURAT KETERANGAN TIDAK MAMPU":
                        $("#detail_jenis_surat").closest('.row').show();
                        $("#detail_nama").closest('.row').show();
                        $("#detail_nik").closest('.row').show();
                        $("#detail_ttl").closest('.row').show();
                        $("#detail_agama").closest('.row').show();
                        $("#detail_pekerjaan").closest('.row').show();
                        $("#detail_alamat").closest('.row').show();
                        $("#detail_keperluan").closest('.row').show();
                        break;
                    default:
                        break;
                }
                // // Populate other details based on surat type
                // $("#detail_nama").html(surats.nama_warga);
                // $("#detail_nik").html(surats.nik_warga);
                // $("#detail_agama").html(surats.agama);
                // $("#detail_pekerjaan").html(surats.pekerjaan);
                // $("#detail_ttl").html(surats.ttl);
                // $("#detail_alamat").html(surats.alamat);
                // $("#detail_keperluan").html(surats.keperluan);
            }
        }, 
    });
});



    // $('#modalDetail').on('show.bs.modal', function (event) {
    //     var button = $(event.relatedTarget); // Tombol yang memicu modal
    //     var jenisSurat = button.data('bs-jenis-surat'); // Ambil nilai jenis surat dari tombol

    //     // Memperbarui judul modal sesuai dengan jenis surat
    //     var modal = $(this);
    //     modal.find('.modal-title').text('Detail ' + jenisSurat);

    //     // Menyembunyikan semua elemen detail
    //     modal.find('.detail-item').hide();

    //     // Menampilkan elemen detail sesuai dengan jenis surat
    //     modal.find("#detail_jenis_surat").html(jenisSurat);

    //     if (jenisSurat === 'SURAT KETERANGAN DOMISILI') {
    //     // Menampilkan elemen detail untuk Surat Keterangan Domisili
    //     modal.find("#detail_nama").html(button.data('nama-warga'));
    //     modal.find("#detail_nik").html(button.data('nik-warga'));
    //     modal.find("#detail_agama").html(button.data('agama'));
    //     modal.find("#detail_pekerjaan").html(button.data('pekerjaan'));
    //     modal.find("#detail_status_nikah").html(button.data('status-nikah'));
    //     } else if (jenisSurat === 'SURAT KETERANGAN USAHA') {
    //     // Menampilkan elemen detail untuk Surat Keterangan Usaha
    //     modal.find("#detail_nama").html(button.data('nama-warga'));
    //     modal.find("#detail_nik").html(button.data('nik-warga'));
    //     modal.find("#detail_agama").html(button.data('agama'));
    //     modal.find("#detail_pekerjaan").html(button.data('pekerjaan'));
    //     modal.find("#detail_status_nikah").html(button.data('status-nikah'));
    //     }
    //     // Tambahkan kondisi dan menampilkan elemen detail untuk jenis surat lainnya jika diperlukan
    // });

    
</script>
@endsection