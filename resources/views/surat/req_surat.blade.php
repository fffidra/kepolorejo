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
                                    <button data-bs-toggle="modal" data-bs-target="#tambahsptbaru" class="btn btn-primary">TAMBAH SURAT</button>
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
<div class="modal fade" id="tambahsptbaru" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Pengajuan Surat Baru</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form method="POST" action="{{ route('buat_surat_usaha') }}"> 
                @csrf
                <div class="modal-body">
                    <div class="mb-3">
                        <label for="jenis_surat" class="form-label">Jenis Surat</label>
                        <select class="form-select" id="jenis_surat" name="jenis_surat" required onchange="showForm()">
                            <option value="" selected hidden>-- Pilih Jenis Surat --</option>
                            @foreach(\App\Models\JenisSurat::all() as $jenis_surat)
                                <option value="{{ $jenis_surat->id_jenis_surat }}">{{ $jenis_surat->nama_jenis_surat }}</option>
                            @endforeach
                        </select>
                    </div>

                    {{-- USAHA --}}
                    <div id="form_surat_1" class="form_surat" style="display: none;">
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
                            <button type="button" class="btn btn-primary">Simpan</button>
                        </div>
                    </div>

                    {{-- DOMISILI --}}
                    <div id="form_surat_2" class="form_surat" style="display: none;">
                        <div class="mb-3">
                            <label for="nama" class="form-label">Nama</label>
                            <input type="text" class="form-control" id="nama">
                        </div>
                        <div class="mb-3">
                            <label for="nik" class="form-label">NIK</label>
                            <input type="text" class="form-control" id="nik">
                        </div>
                        <div class="mb-3">
                            <label for="jenis_kelamin" class="form-label">Jenis Kelamin</label>
                            <select class="form-select" id="jenis_kelamin" name="jenis_kelamin" required>
                                <option value="" selected hidden>-- Pilih Jenis Kelamin --</option>
                                @foreach(\App\Models\JenisKelamin::all() as $jenis_kelamin)
                                    <option value="{{ $jenis_kelamin->id_jenis_kelamin }}">{{ $jenis_kelamin->nama_jenis_kelamin }}</option>
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
                            <label for="agama" class="form-label">Agama</label>
                            <select class="form-select" id="agama" name="agama" required>
                                <option value="" selected hidden>-- Pilih Agama --</option>
                                @foreach(\App\Models\Agama::all() as $agama)
                                    <option value="{{ $agama->id_agama }}">{{ $agama->nama_agama }}</option>
                                @endforeach
                            </select>
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
                            <button type="button" class="btn btn-primary">Simpan</button>
                        </div>
                    </div>

                    {{-- BELUM MENIKAH --}}
                    <div id="form_surat_3" class="form_surat" style="display: none;">
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
                            <button type="button" class="btn btn-primary">Simpan</button>
                        </div>
                    </div>

                    {{-- PENGHASILAN ORANG TUA --}}
                    <div id="form_surat_4" class="form_surat" style="display: none;">
                        <div class="mb-3">
                            <label for="nama_anak" class="form-label">Nama Anak</label>
                            <input type="text" class="form-control" id="nama_anak">
                        </div>
                        <div class="mb-3">
                            <label for="nik_anak" class="form-label">NIK Anak</label>
                            <input type="text" class="form-control" id="nik_anak">
                        </div>
                        <div class="mb-3">
                            <label for="ttl_anak" class="form-label">Tempat, Tanggal Lahir Anak</label>
                            <input type="text" class="form-control" id="ttl_anak">
                        </div>
                        <div class="mb-3">
                            <label for="agama_anak" class="form-label">Agama Anak</label>
                            <select class="form-select" id="agama_anak" name="agama_anak" required>
                                <option value="" selected hidden>-- Pilih Agama --</option>
                                @foreach(\App\Models\Agama::all() as $agama)
                                    <option value="{{ $agama->id_agama }}">{{ $agama->nama_agama }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="mb-3">
                            <label for="pekerjaan_anak" class="form-label">Pekerjaan Anak</label>
                            <select class="form-select" id="pekerjaan_anak" name="pekerjaan_anak" required>
                                <option value="" selected hidden>-- Pilih Pekerjaan --</option>
                                @foreach(\App\Models\Pekerjaan::all() as $pekerjaan)
                                    <option value="{{ $pekerjaan->id_pekerjaan }}">{{ $pekerjaan->nama_pekerjaan }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="mb-3">
                            <label for="alamat_anak" class="form-label">Alamat Anak</label>
                            <input type="text" class="form-control" id="alamat_anak">
                        </div>
                        <div class="mb-3">
                            <label for="nama" class="form-label">Nama Orang Tua</label>
                            <input type="text" class="form-control" id="nama">
                        </div>
                        <div class="mb-3">
                            <label for="nik" class="form-label">NIK Orang Tua</label>
                            <input type="text" class="form-control" id="nik">
                        </div>
                        <div class="mb-3">
                            <label for="ttl" class="form-label">Tempat, Tanggal Lahir Orang Tua</label>
                            <input type="text" class="form-control" id="ttl">
                        </div>
                        <div class="mb-3">
                            <label for="agama" class="form-label">Agama Orang Tua</label>
                            <select class="form-select" id="agama" name="agama" required>
                                <option value="" selected hidden>-- Pilih Agama --</option>
                                @foreach(\App\Models\Agama::all() as $agama)
                                    <option value="{{ $agama->id_agama }}">{{ $agama->nama_agama }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="mb-3">
                            <label for="pekerjaan" class="form-label">Pekerjaan Orang Tua</label>
                            <select class="form-select" id="pekerjaan" name="pekerjaan" required>
                                <option value="" selected hidden>-- Pilih Pekerjaan --</option>
                                @foreach(\App\Models\Pekerjaan::all() as $pekerjaan)
                                    <option value="{{ $pekerjaan->id_pekerjaan }}">{{ $pekerjaan->nama_pekerjaan }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="mb-3">
                            <label for="alamat" class="form-label">Alamat Orang Tua</label>
                            <input type="text" class="form-control" id="alamat">
                        </div>
                        <div class="mb-3">
                            <label for="penghasilan" class="form-label">Penghasilan Orang Tua</label>
                            <input type="text" class="form-control" id="penghasilan">
                        </div>
                        <div class="mb-3">
                            <label for="keperluan" class="form-label">Keperluan</label>
                            <input type="text" class="form-control" id="keperluan">
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Tutup</button>
                            <button type="button" class="btn btn-primary">Simpan</button>
                        </div>
                    </div>

                    {{-- TIDAK MAMPU --}}
                    <div id="form_surat_5" class="form_surat" style="display: none;">
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
                            <button type="button" class="btn btn-primary">Simpan</button>
                        </div>
                    </div>
                </div>
            </form>
            {{-- <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Tutup</button>
            </div> --}}
        </div>
    </div>
</div>
@endsection

@section('script')
    <script>
        function showForm() {
        var selectedOption = document.getElementById("jenis_surat").value;
        var forms = document.querySelectorAll('.form_surat');

        forms.forEach(function(form) {
            if (form.id === "form_surat_" + selectedOption) {
                form.style.display = "block";
            } else {
                form.style.display = "none";
            }
        });
    }
    
    //     function showFields() {
    //     var jenisSurat = document.getElementById("jenis_surat").value;
    //     hideAllFields();

    //     // Kemudian tampilkan fields yang sesuai dengan jenis surat yang dipilih
    //     if (jenisSurat === "0") {
    //         document.getElementById("fields_surat_belum_menikah").style.display = "block";
    //     } else if (jenisSurat === "1") {
    //         document.getElementById("fields_surat_domisili").style.display = "block";
    //     }
    //     // Lakukan hal yang sama untuk setiap jenis surat yang lain
    // }

    // function hideAllFields() {
    //     document.getElementById("fields_surat_belum_menikah").style.display = "none";
    //     document.getElementById("fields_surat_domisili").style.display = "none";
    //     // Dan seterusnya untuk setiap jenis surat yang lain
    // }








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