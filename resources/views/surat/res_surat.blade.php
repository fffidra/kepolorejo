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
                                        <th class="col-md-2 text-center align-middle">Nama Lengkap</th>                           
                                        <th class="col-md-2 text-center align-middle">Jenis Keperluan</th>                           
                                        <th class="col-md-2 text-center align-middle">Status</th>                           
                                        <th class="col-md-2 text-center align-middle">Aksi</th>                           
                                    </tr>
                                </thead>
                                <tbody>

                                </tbody>
                            </table>
                        </div>
                    </div>
                </div> <!-- container-fluid -->
            </div>
            @include('layout.footer')
        </div>
    </div>
@endsection

@section('modal')
    {{-- <div class="modal fade" id="tambahsptbaru" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-xl">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Formulir Tambah Surat Perintah Tugas</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <form method="POST" action="{{ route('buat_spt') }}"> 
                    @csrf
                    <div class="modal-body">
                        <div class="row">
                            <div class="col-md mb-3">
                                <label class="col-form-label">Jenis SPT</label>
                                <div class="form-check">
                                    <input class="form-check-input" type="radio" name="jenis_spt" id="regulerRadio" value="reguler" required>
                                    <label class="form-check-label" for="regulerRadio">REGULER</label>
                                </div>
                                <div class="form-check">
                                    <input class="form-check-input" type="radio" name="jenis_spt" id="khususRadio" value="khusus" required>
                                    <label class="form-check-label" for="khususRadio">KHUSUS</label>
                                </div>
                            </div>
                            <div class="col-md mb-3">
                                <label class="col-form-label">Pilih Ketua</label>
                                <div class="input-group">
                                    <select class="form-select" name="nama" required>
                                        <option value="" selected hidden>-- Pilih Pegawai --</option>
                                        @foreach ($pegawais->unique('nama_bidang')->sortBy('nama_bidang') as $bidang)
                                            @if ($bidang->nama_bidang != 'Inspektorat' && $bidang->nama_bidang != 'Sekretariat')
                                                <optgroup label="{{ $bidang->nama_bidang }}&nbsp;">
                                                    @foreach ($pegawais->where('nama_bidang', $bidang->nama_bidang) as $pegawai)
                                                    @if ($pegawai->nama_jabatan != 'Inspektur Pembantu')
                                                        <option value="{{ $pegawai->nip }}">{{ $pegawai->nama_pegawai }}</option>
                                                    @endif
                                                    @endforeach
                                                </optgroup>
                                            @endif
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                        </div>
                        <div class="mb-3 row">
                            <label for="dasar_spt" class="col-md-2 col-form-label">Dasar</label>
                            <div class="col-md-9">
                                <textarea class="form-control" id="dasar_spt" name="dasar_spt" required></textarea>
                            </div>
                        </div>
                        <div class="mb-3 row">
                            <label for="untuk_spt" class="col-md-2 col-form-label">Untuk</label>
                            <div class="col-md-9">
                                <textarea class="form-control" id="untuk_spt" name="untuk_spt" required></textarea>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                        <button type="submit" class="btn btn-primary">Tambah</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- modal ubah spt  -->
    <div class="modal fade" id="modalUbah" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-xl">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="modalUbahLabel">Ubah Data SPT</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <!-- Form untuk mengubah data -->
                <form method="POST" action="{{ route('ubah_spt_irban') }}" id="formUbah">
                    @csrf
                    @method('PUT')
                    <input type="hidden" name="id_spt" id="id_spt" required>
                    <input type="hidden" name="ketua_sebelumnya" id="ketua_sebelumnya" required>
                    <div class="modal-body">
                        <!-- Masukkan bidang-bidang yang ingin Anda ubah di sini -->
                        <div class="mb-3 row">
                            <label class="col-md-2 col-form-label">Jenis SPT</label>
                            <div class="col-md-3">
                                <div class="form-check">
                                    <input class="form-check-input" type="radio" name="ubah_jenis_spt" id="ubah_regulerRadio" value="reguler" required>
                                    <label class="form-check-label" for="ubah_regulerRadio">REGULER</label>
                                </div>
                                <div class="form-check">
                                    <input class="form-check-input" type="radio" name="ubah_jenis_spt" id="ubah_khususRadio" value="khusus" required>
                                    <label class="form-check-label" for="ubah_khususRadio">KHUSUS</label>
                                </div>
                            </div>
                        </div>
                        <div class="mb-3 row">
                            <label for="dasar_spt" class="col-md-2 col-form-label">Dasar</label>
                            <div class="col-md-9">
                                <textarea class="form-control" id="ubah_dasar_spt" name="ubah_dasar_spt" required></textarea>
                            </div>
                        </div>
                        <div class="mb-3 row">
                            <label for="ubah_untuk_spt" class="col-md-2 col-form-label">Untuk</label>
                            <div class="col-md-9">
                                <textarea class="form-control" id="ubah_untuk_spt" name="ubah_untuk_spt" required></textarea>
                            </div>
                        </div>
                        @if(Auth::user()->nama_jabatan != 'Inspektur Pembantu' && Auth::user()->nama_jabatan != 'Sekretaris Dinas')
                        <div class="mb-3 row">
                            <label for="ubah_obyek" class="col-md-2 col-form-label">Obyek Audit</label>
                            <div class="col-md-9">
                                <input type="text" class="form-control" id="ubah_obyek" name="ubah_obyek" required></inclass=>
                            </div>
                        </div>
                        <div class="mb-3 row">
                            <label for="tanggalInterval" class="col-md-2 col-form-label">Tanggal Interval</label>
                            <div class="col-md-5">
                                <div class="input-group">
                                    <input type="text" class="form-control" id="kurun_waktu_awal" name="kurun_waktu_awal" required readonly>
                                    <div class="input-group-text">s/d</div>
                                    <input type="text" class="form-control" id="kurun_waktu_akhir" name="kurun_waktu_akhir" required readonly>
                                </div>
                            </div>
                            <div class="col-md-2">
                                <a role="button" class="btn btn-outline-info" id="tanggalInterval">Pilih</a>
                            </div>
                        </div>
                        @endif
                        <div class="mb-3 row">
                            <label for="ubah_penanggungjawab" class="col-md-2 col-form-label">Penanggungjawab</label>
                            <div class="col-md-9">
                                <input type="text" class="form-control" id="ubah_penanggungjawab" readonly>
                            </div>
                        </div>
                        <div class="mb-3 row">
                            <label for="ubah_pengawas" class="col-md-2 col-form-label">Pengawas</label>
                            <div class="col-md-9">
                                <input type="text" class="form-control" id="ubah_pengawas" readonly>
                            </div>
                        </div>
                        @if(Auth::user()->nama_jabatan == 'Inspektur Pembantu')
                        <div class="mb-3 row">
                            <label for="ubah_ketua" class="col-md-2 col-form-label">Ketua</label>
                            <div class="col-md-9">
                                <div class="input-group">
                                    <select class="form-select" name="ubah_ketua" required>
                                        <option id="ubah_nama_ketua" selected hidden></option>
                                        @foreach ($pegawais->unique('nama_bidang')->sortBy('nama_bidang') as $bidang)
                                            @if ($bidang->nama_bidang != 'Inspektorat' && $bidang->nama_bidang != 'Sekretariat')
                                                <optgroup label="{{ $bidang->nama_bidang }}&nbsp;">
                                                    @foreach ($pegawais->where('nama_bidang', $bidang->nama_bidang) as $pegawai)
                                                    @if ($pegawai->nama_jabatan != 'Inspektur Pembantu')
                                                        <option value="{{ $pegawai->nip }}">{{ $pegawai->nama_pegawai }}</option>
                                                    @endif
                                                    @endforeach
                                                </optgroup>
                                            @endif
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                        </div>
                        @elseif(Auth::user()->nama_jabatan != 'Inspektur Pembantu' && Auth::user()->nama_jabatan != 'Sekretaris Dinas')
                        <div class="mb-3 row">
                            <label for="ubah_ketuafix" class="col-md-2 col-form-label">Ketua</label>
                            <div class="col-md-9">
                                <input type="text" class="form-control" id="ubah_ketuafix" readonly>
                            </div>
                        </div>
                        <div class="mb-3 row">
                            <label class="col-md-2 col-form-label">Anggota</label>
                            <div class="col-md-9">
                                <select class="select form-select" name="ubah_anggota[]" id="ubah_anggota" multiple multiselect-search="true" multiselect-select-all="true" multiselect-max-items="false" onchange="console.log(this.selectedOptions)" required>
                                    @foreach ($pegawais->unique('nama_bidang')->sortBy('nama_bidang') as $bidang)
                                        @if ($bidang->nama_bidang != 'Inspektorat' && $bidang->nama_bidang != 'Sekretariat')
                                            <optgroup label="{{ $bidang->nama_bidang }}">
                                                @foreach ($pegawais->where('nama_bidang', $bidang->nama_bidang) as $pegawai)
                                                @if ($pegawai->nama_jabatan != 'Inspektur Pembantu' && $pegawai->nama_pegawai != Auth::user()->nama_pegawai)
                                                    <option value="{{ $pegawai->nip }}">{{ $pegawai->nama_pegawai }}</option>
                                                @endif
                                                @endforeach
                                            </optgroup>
                                        @endif
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        @endif
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Tutup</button>
                        <button type="submit" class="btn btn-warning" id="simpanPerubahan">Simpan Perubahan</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <div class="modal fade" id="modalDetail" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-xl">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Detail SPT</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="mb-3 row">
                        <label class="col-md-2 col-form-label">Jenis SPT</label>
                        <span class="col-md-9">:&nbsp;
                            <label class="col-form-label" id="detail_jenis_spt"></label>
                        </span>
                    </div>
                    <div class="mb-3 row">
                        <label class="col-md-2 col-form-label">Dasar</label>
                        <span class="col-md-9 col-form-label" style="padding-top: 0;display: flex;padding-top: calc(.47rem + var(--bs-border-width));">:&nbsp;
                            <label class="col-form-label" id="detail_dasar_spt" style="padding-top: 0;"></label>
                        </span>
                    </div>
                    <div class="mb-3 row">
                        <label class="col-md-2 col-form-label">Kurun Waktu</label>
                        <span class="col-md-9">:&nbsp;
                            <label class="col-form-label" id="detail_tanggal"></label>
                        </span>
                    </div>
                    <div class="mb-3 row">
                        <label class="col-md-2 col-form-label">Untuk</label>
                        <span class="col-md-9">:&nbsp;
                            <label class="col-form-label" id="detail_untuk_spt"></label>
                        </span>
                    </div>
                    <div class="mb-3 row">
                        <label class="col-md-2 col-form-label">Obyek Audit</label>
                        <span class="col-md-9">:&nbsp;
                            <label class="col-form-label" id="detail_obyek_audit"></label>
                        </span>
                    </div>
                    <div class="mb-3 row">
                        <label class="col-md-2 col-form-label">Penanggungjawab</label>
                        <span class="col-md-9">:&nbsp;
                            <label class="col-form-label" id="detail_penanggungjawab"></label>
                        </span>
                    </div>
                    <div class="mb-3 row">
                        <label class="col-md-2 col-form-label">Pengawas</label>
                        <span class="col-md-9">:&nbsp;
                            <label class="col-form-label" id="detail_pengawas"></label>
                        </span>
                    </div>
                    <div class="mb-3 row">
                        <label class="col-md-2 col-form-label">Ketua</label>
                        <span class="col-md-9">:&nbsp;
                            <label class="col-form-label" id="detail_ketua"></label>
                        </span>
                    </div>
                    <div class="mb-3 row">
                        <label class="col-md-2 col-form-label">Anggota</label>
                        <span class="col-md-9">:&nbsp;
                            <label class="col-form-label" id="detail_anggota"></label>
                        </span>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Tutup</button>
                </div>
            </div>
        </div>
    </div> --}}
@endsection

@section('script')

@endsection