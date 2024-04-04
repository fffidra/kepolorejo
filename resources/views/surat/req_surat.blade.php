@extends('layout.app')

@section('title')
    Permohonan Surat
@endsection

@section('head')
    <link rel="stylesheet" href="{{ asset('assets/css/dataTables.bootstrap5.min.css') }}">
    <script src="{{ asset('assets/js/jquery.dataTables.min.js') }}"></script>
    <script src="{{ asset('assets/js/dataTables.bootstrap5.min.js') }}"></script>
    <script src="{{ asset('ckeditor/ckeditor.js') }}"></script>
    <script src="{{ asset('assets/libs/moment/min/moment.min.js') }}"></script>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    

    {{-- <link rel="stylesheet" href="{{ asset('assets/css/dataTables.bootstrap5.min.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/libs/daterangepicker/daterangepicker.css') }}">
    <script type="text/javascript" src="{{ asset('assets/libs/daterangepicker/daterangepicker.min.js') }}"></script>
    <script src="{{ asset('ckeditor/ckeditor.js') }}"></script>
    <script src="{{ asset('assets/libs/moment/min/moment.min.js') }}"></script>
    <script src="{{ asset('assets/js/jquery.dataTables.min.js') }}"></script>
    <script src="{{ asset('assets/js/dataTables.bootstrap5.min.js') }}"></script> --}}
@endsection

@section('content')
    <div id="layout-wrapper">
        @include('layout.header')
        @include('layout.sidebar')
        <div class="main-content">
            <div class="page-content">
                <div class="container-fluid">

                    <!-- start page title -->
                    <div class="row mx-2">
                        <div class="col-12">
                            <div class="page-title-box d-flex align-items-center justify-content-between">
                                <ol class="breadcrumb m-0">
                                    {{-- <li class="breadcrumb-item"><a href="{{ route('spt_pka.spt') }}">SPT</a></li> --}}
                                    <li class="breadcrumb-item active">REQ SURAT</li>
                                </ol>
                            </div>
                        </div>
                    </div><!-- end page title -->

                    <div class="row bg-white rounded-3 pb-3 mb-3 mx-2">
                        <div class="page-title-box bg-light-subtle rounded-3 d-flex align-items-center justify-content-between px-3 py-2">
                            <h5>REQ SURAT</h5>
                            {{-- <div class="mb-2 row">
                                    <button data-bs-toggle="modal" data-bs-target="#tambahitem" class="btn btn-primary">Tambah Item</button>
                            </div>  --}}
                        </div>
                        {{-- <p>Silakan pilih surat yang akan diajukan.</p> --}}
                        <div class="container-fluid px-3 py-3">
                            <div class="row">
                                <div class="col-md-4 mb-2">
                                    <button data-bs-toggle="modal" data-bs-target="#" class="btn btn-primary">CEK SURAT</button>
                                    <button data-bs-toggle="modal" data-bs-target="#tambahsuratbaru" class="btn btn-primary">TAMBAH SURAT</button>
                                    
                                    <button data-bs-toggle="modal" data-bs-target="#tambahsuratcoba" class="btn btn-primary">tambah surat coba</button>
                                    {{-- <button data-bs-toggle="modal" data-bs-target="#tambahitem" class="btn btn-primary btn-block">SURAT KETERANGAN USAHA</button> --}}
                                    {{-- <a href="{{ url('/usaha') }}" class="btn btn-primary w-sm waves-effect waves-light">SURAT KETERANGAN USAHA</a> --}}
                                </div>
                                <form action="{{ route('check_database') }}" method="POST">
                                    @csrf
                                    <button type="submit">Check Database</button>
                                </form>
                                
                                {{-- <div class="col-md-4 mb-2">
                                    <a href="{{ url('/nikah') }}" class="btn btn-primary w-sm waves-effect waves-light">SURAT KETERANGAN NIKAH</a>
                                </div>
                                <div class="col-md-4 mb-2">
                                    <a href="{{ url('/waris') }}" class="btn btn-primary w-sm waves-effect waves-light">SURAT AHLI WARIS</a>
                                </div> --}}
                            </div>

                        
                            <br><br><br>

                            {{-- <button>SURAT A</button>
                            <button>SURAT B</button>
                            <button>SURAT C</button> --}}
                            {{-- <table class="table table-bordered border-black" style="width:100%">
                                <thead>
                                    <tr>
                                        <th class="text-center align-middle" style="width: 20px;">Tujuan/Sasaran</th>  
                                        <th class="text-center align-middle" style="width: 20px;">Langkah-langkah kerja</th>
                                        <th class="text-center align-middle" style="width: 10px;">Dilaksanakan oleh</th>
                                        <th class="text-center align-middle" style="width: 5px;">Waktu yang diperlukan</th> 
                                        <th class="text-center align-middle" style="width: 5px;">Nomor KKA</th> 
                                        <th class="text-center align-middle" style="width: 20px;">Catatan</th>  
                                        <th class="text-center align-middle" style="width: 20px;">Aksi</th>                          
                                    </tr>
                                </thead>
                                <tbody>   
                        
                                </tbody>
                            </table> --}}
                        </div>
                    </div>
                </div> <!-- container-fluid -->
            </div>
            @include('layout.footer')
        </div>
    </div>
@endsection

@section('modal')
<div class="modal fade" id="tambahsuratbaru" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Pengajuan Surat Baru</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form method="POST" action="{{ route('buat_surat') }}"> 
                @csrf
                <div class="modal-body">
                    <div class="mb-3">
                        <label for="jenis_surat" class="form-label">Jenis Surat</label>
                        <select class="form-select" id="jenis_surat" name="jenis_surat" required onchange="showForm()">
                            <option value="" selected hidden>-- Pilih Jenis Surat --</option>
                            @foreach(\App\Models\JenisSurat::all() as $jenis_surats)
                                <option value="{{ $jenis_surats->nama_jenis_surat }}">{{ $jenis_surats->nama_jenis_surat }}</option>
                            @endforeach
                        </select>
                    </div>

                    {{-- USAHA --}}
                    <div id="form_surat_SURAT KETERANGAN USAHA" class="form_surat" style="display: none;">
                        <div class="mb-3">
                            <label for="nama_warga" class="form-label">Nama</label>
                            <input type="text" class="form-control" id="nama_warga" name="nama_warga">
                        </div>
                        <div class="mb-3">
                            <label for="nik" class="form-label">NIK</label>
                            <input type="text" class="form-control" id="nik_warga" name="nik_warga">
                        </div>
                        <div class="mb-3">
                            <label for="ttl" class="form-label">Tempat, Tanggal Lahir</label>
                            <input type="text" class="form-control" id="ttl" name="ttl">
                        </div>
                        <div class="mb-3">
                            <label for="status_nikah" class="form-label">Status</label>
                            <select class="form-select" id="status_nikah" name="status_nikah" required>
                                <option value="" selected hidden>-- Pilih Status --</option>
                                @foreach(\App\Models\Status::all() as $status_nikahs)
                                    <option value="{{ $status_nikahs->nama_status_nikah }}">{{ $status_nikahs->nama_status_nikah }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="mb-3">
                            <label for="agama" class="form-label">Agama</label>
                            <select class="form-select" id="agama" name="agama" required>
                                <option value="" selected hidden>-- Pilih Agama --</option>
                                @foreach(\App\Models\Agama::all() as $agamas)
                                    <option value="{{ $agamas->nama_agama }}">{{ $agamas->nama_agama }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="mb-3">
                            <label for="pekerjaan" class="form-label">Pekerjaan</label>
                            <select class="form-select" id="pekerjaan" name="pekerjaan" required>
                                <option value="" selected hidden>-- Pilih Pekerjaan --</option>
                                @foreach(\App\Models\Pekerjaan::all() as $pekerjaans)
                                    <option value="{{ $pekerjaans->nama_pekerjaan }}">{{ $pekerjaans->nama_pekerjaan }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="mb-3">
                            <label for="alamat" class="form-label">Alamat</label>
                            <input type="text" class="form-control" id="alamat" name="alamat">
                        </div>
                        <div class="mb-3">
                            <label for="usaha" class="form-label">Jenis Usaha</label>
                            <input type="text" class="form-control" id="usaha" name="usaha">
                        </div>
                        <div class="mb-3">
                            <label for="keperluan" class="form-label">Keperluan</label>
                            <input type="text" class="form-control" id="keperluan" name="keperluan">
                        </div>
                    </div>

                    {{-- DOMISILI --}}
                    {{-- <div id="form_surat_SURAT KETERANGAN DOMISILI" class="form_surat" style="display: none;">
                        <div class="mb-3">
                            <label for="nama_warga" class="form-label">Nama</label>
                            <input type="text" class="form-control" id="nama_warga_2" name="nama_warga">
                        </div>
                        <div class="mb-3">
                            <label for="nik" class="form-label">NIK</label>
                            <input type="text" class="form-control" id="nik_warga_2" name="nik_warga">
                        </div>
                        <div class="mb-3">
                            <label for="jenis_kelamin" class="form-label">Jenis Kelamin</label>
                            <select class="form-select" id="jenis_kelamin_2" name="jenis_kelamin" required>
                                <option value="" selected hidden>-- Pilih Jenis Kelamin --</option>
                                @foreach(\App\Models\JenisKelamin::all() as $jenis_kelamin)
                                    <option value="{{ $jenis_kelamin->nama_jenis_kelamin }}">{{ $jenis_kelamin->nama_jenis_kelamin }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="mb-3">
                            <label for="ttl" class="form-label">Tempat, Tanggal Lahir</label>
                            <input type="text" class="form-control" id="ttl_2" name="ttl">
                        </div>
                        <div class="mb-3">
                            <label for="agama" class="form-label">Agama</label>
                            <select class="form-select" id="agama_2" name="agama" required>
                                <option value="" selected hidden>-- Pilih Agama --</option>
                                @foreach(\App\Models\Agama::all() as $agamas)
                                    <option value="{{ $agamas->nama_agama }}">{{ $agamas->nama_agama }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="mb-3">
                            <label for="status_nikah" class="form-label">Status</label>
                            <select class="form-select" id="status_nikah_2" name="status_nikah" required>
                                <option value="" selected hidden>-- Pilih Status --</option>
                                @foreach(\App\Models\Status::all() as $status_nikahs)
                                    <option value="{{ $status_nikahs->nama_status_nikah }}">{{ $status_nikahs->nama_status_nikah }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="mb-3">
                            <label for="pekerjaan" class="form-label">Pekerjaan</label>
                            <select class="form-select" id="pekerjaan_2" name="pekerjaan" required>
                                <option value="" selected hidden>-- Pilih Pekerjaan --</option>
                                @foreach(\App\Models\Pekerjaan::all() as $pekerjaans)
                                    <option value="{{ $pekerjaans->nama_pekerjaan }}">{{ $pekerjaans->nama_pekerjaan }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="mb-3">
                            <label for="alamat" class="form-label">Alamat</label>
                            <input type="text" class="form-control" id="alamat_2" name="alamat">
                        </div>
                        <div class="mb-3">
                            <label for="alamat_dom" class="form-label">Alamat Domisili</label>
                            <input type="text" class="form-control" id="alamat_dom_2" name="alamat_dom">
                        </div>
                        <div class="mb-3">
                            <label for="keperluan" class="form-label">Keperluan</label>
                            <input type="text" class="form-control" id="keperluan_2" name="keperluan">
                        </div>
                    </div> --}}

                    {{-- BELUM MENIKAH --}}
                    {{-- <div id="form_surat_3" class="form_surat" style="display: none;">
                        <div class="mb-3">
                            <label for="nama" class="form-label">Nama</label>
                            <input type="text" class="form-control" id="nama">
                        </div>
                        <div class="mb-3">
                            <label for="nik" class="form-label">NIK</label>
                            <input type="text" class="form-control" id="nik">
                        </div>
                        <div class="mb-3">
                            <label for="ttl" class="form-label">Tempat, Tanggal Lahir</label>
                            <input type="text" class="form-control" id="ttl">
                        </div>
                        <div class="mb-3">
                            <label for="status_nikah" class="form-label">Status</label>
                            <select class="form-select" id="status_nikah" name="status_nikah" required>
                                <option value="" selected hidden>-- Pilih Status --</option>
                                @foreach(\App\Models\Status::all() as $status_nikah)
                                    <option value="{{ $status_nikah->id_status_nikah }}">{{ $status_nikah->nama_status_nikah }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="mb-3">
                            <label for="agama" class="form-label">Agama</label>
                            <select class="form-select" id="agama" name="agama" required>
                                <option value="" selected hidden>-- Pilih Agama --</option>
                                @foreach(\App\Models\Agama::all() as $agama)
                                    <option value="{{ $agama->id_agama }}">{{ $agama->nama_agama }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="mb-3">
                            <label for="pekerjaan" class="form-label">Pekerjaan</label>
                            <select class="form-select" id="pekerjaan" name="pekerjaan" required>
                                <option value="" selected hidden>-- Pilih Pekerjaan --</option>
                                @foreach(\App\Models\Pekerjaan::all() as $pekerjaan)
                                    <option value="{{ $pekerjaan->id_pekerjaan }}">{{ $pekerjaan->nama_pekerjaan }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="mb-3">
                            <label for="alamat" class="form-label">Alamat</label>
                            <input type="text" class="form-control" id="alamat">
                        </div>
                        <div class="mb-3">
                            <label for="keperluan" class="form-label">Keperluan</label>
                            <input type="text" class="form-control" id="keperluan">
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Tutup</button>
                            <button type="submit" class="btn btn-primary">Simpan</button>
                        </div>
                    </div> --}}

                    {{-- TIDAK MAMPU --}}
                    {{-- <div id="form_surat_5" class="form_surat" style="display: none;">
                        <div class="mb-3">
                            <label for="nama" class="form-label">Nama</label>
                            <input type="text" class="form-control" id="nama">
                        </div>
                        <div class="mb-3">
                            <label for="nik" class="form-label">NIK</label>
                            <input type="text" class="form-control" id="nik">
                        </div>
                        <div class="mb-3">
                            <label for="ttl" class="form-label">Tempat, Tanggal Lahir</label>
                            <input type="text" class="form-control" id="ttl">
                        </div>
                        <div class="mb-3">
                            <label for="agama" class="form-label">Agama</label>
                            <select class="form-select" id="agama" name="agama" required>
                                <option value="" selected hidden>-- Pilih Agama --</option>
                                @foreach(\App\Models\Agama::all() as $agama)
                                    <option value="{{ $agama->id_agama }}">{{ $agama->nama_agama }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="mb-3">
                            <label for="pekerjaan" class="form-label">Pekerjaan</label>
                            <select class="form-select" id="pekerjaan" name="pekerjaan" required>
                                <option value="" selected hidden>-- Pilih Pekerjaan --</option>
                                @foreach(\App\Models\Pekerjaan::all() as $pekerjaan)
                                    <option value="{{ $pekerjaan->id_pekerjaan }}">{{ $pekerjaan->nama_pekerjaan }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="mb-3">
                            <label for="alamat" class="form-label">Alamat</label>
                            <input type="text" class="form-control" id="alamat">
                        </div>
                        <div class="mb-3">
                            <label for="keperluan" class="form-label">Keperluan</label>
                            <input type="text" class="form-control" id="keperluan">
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Tutup</button>
                            <button type="submit" class="btn btn-primary">Simpan</button>
                        </div>
                    </div> --}}
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Tutup</button>
                    <button type="submit" class="btn btn-primary">Simpan</button>                
                </div>
            </form>
        </div>
    </div>
</div>

<div class="modal fade" id="tambahsuratcoba" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Pengajuan Surat Baru</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
                <div class="modal-body">
                    <form method="POST" action="{{ route('buat_surat') }}"> 
                        @csrf
                
                        <div class="mb-3">
                            <label for="nama" class="form-label">Nama</label>
                            <input type="text" class="form-control" id="nama_warga" name="nama_warga">
                        </div>
                        <div class="mb-3">
                            <label for="nik" class="form-label">NIK</label>
                            <input type="text" class="form-control" id="nik_warga" name="nik_warga">
                        </div>
                        <div class="mb-3">
                            <label for="ttl" class="form-label">Tempat, Tanggal Lahir</label>
                            <input type="text" class="form-control" id="ttl" name="ttl">
                        </div>
                        <div class="mb-3">
                            <label for="status_nikah" class="form-label">Status Nikah</label>
                            <select class="form-select" id="status_nikah" name="status_nikah" required>
                                <option value="" selected hidden>-- Pilih Status Nikah --</option>
                                @foreach(\App\Models\Status::all() as $status_nikah)
                                    <option value="{{ $status_nikah->nama_status_nikah }}">{{ $status_nikah->nama_status_nikah }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="mb-3">
                            <label for="agama" class="form-label">Agama</label>
                            <select class="form-select" id="agama" name="agama" required>
                                <option value="" selected hidden>-- Pilih Agama --</option>
                                @foreach(\App\Models\Agama::all() as $agama)
                                    <option value="{{ $agama->nama_agama }}">{{ $agama->nama_agama }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="mb-3">
                            <label for="pekerjaan" class="form-label">Pekerjaan</label>
                            <select class="form-select" id="pekerjaan" name="pekerjaan" required>
                                <option value="" selected hidden>-- Pilih Pekerjaan --</option>
                                @foreach(\App\Models\Pekerjaan::all() as $pekerjaan)
                                    <option value="{{ $pekerjaan->nama_pekerjaan }}">{{ $pekerjaan->nama_pekerjaan }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="mb-3">
                            <label for="jenis_surat" class="form-label">Pekerjaan</label>
                            <select class="form-select" id="jenis_surat" name="jenis_surat" required>
                                <option value="" selected hidden>-- Pilih Pekerjaan --</option>
                                @foreach(\App\Models\JenisSurat::all() as $jenis_surat)
                                    <option value="{{ $jenis_surat->nama_jenis_surat }}">{{ $jenis_surat->nama_jenis_surat }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="mb-3">
                            <label for="alamat" class="form-label">Alamat</label>
                            <input type="text" class="form-control" id="alamat" name="alamat">
                        </div>
                        <div class="mb-3">
                            <label for="usaha" class="form-label">Jenis Usaha</label>
                            <input type="text" class="form-control" id="usaha" name="usaha">
                        </div>
                        <div class="mb-3">
                            <label for="keperluan" class="form-label">Keperluan</label>
                            <input type="text" class="form-control" id="keperluan" name="keperluan">
                        </div>
                
                        <!-- Sisipkan tombol Tutup dan Simpan di sini -->
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Tutup</button>
                            <button type="submit" class="btn btn-primary">Simpan</button>
                        </div>
                    </form>
                </div>
                
        </div>
    </div>
</div>
@endsection

@section('script')
    <script>
    //     function showForm() {
    //     var selectedOption = document.getElementById("jenis_surat").value;
    //     var forms = document.querySelectorAll('.form_surat');

    //     forms.forEach(function(form) {
    //         if (form.id === "form_surat_" + selectedOption) {
    //             form.style.display = "block";
    //         } else {
    //             form.style.display = "none";
    //         }
    //     });
    // }

    function showForm() {
        var selectedOption = document.getElementById("jenis_surat").value;
        var forms = document.querySelectorAll('.form_surat');

        forms.forEach(function(form) {
            var formId = form.id.split("_").pop(); 
            if (formId === selectedOption) {
                form.style.display = "block";
            } else {
                form.style.display = "none";
            }
        });
    }

    // $(document).ready(function() {
    //     function validateInputs() {
    //         var isValid = true; 
    //         return isValid;
    //     }

    //     $('input, select').change(function() {
    //         if (validateInputs()) {
    //             $('#btn-submit').prop('disabled', false); 
    //         } else {
    //             $('#btn-submit').prop('disabled', true);
    //         }
    //     });
    // });

        // var editor = CKEDITOR.replace('langkah');

        // $(document).ready(function() {
        //     $('.table').DataTable({
        //         columnDefs: [
        //             { orderable: false, targets: [2] }
        //         ],
        //         language: {
        //             lengthMenu: "Tampilkan _MENU_ data per halaman",
        //             zeroRecords: "Data tidak ditemukan.",
        //             info: "Menampilkan _START_ - _END_ dari _TOTAL_ data",
        //             infoEmpty: "Menampilkan 0 - 0 dari 0 data",
        //             infoFiltered: "(difilter dari _MAX_ total data)",
        //             search: "Cari",
        //             decimal: ",",
        //             thousands: ".",
        //             paginate: {
        //                 previous: "Sebelumnya",
        //                 next: "Selanjutnya"
        //             }
        //         }
        //     });
        // });

    </script>
@endsection