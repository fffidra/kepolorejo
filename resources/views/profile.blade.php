@extends('layout.app')

@section('title')
    Profile 
@endsection

@section('content')
    <div id="layout-wrapper">
        <div id="layout-wrapper">
            @include('layout.header')
            @include('layout.sidebar')
            <div class="main-content">
                <div class="page-content">
                    <div class="container-fluid">
                        <div class="row mx-2">
                            <div class="col-12">
                                <div class="page-title-box align-items-center justify-content-between">
                                    <h5 class="mb-2">UBAH PROFILE</h5>
                                    <h4 class="fs-base lh-base fw-medium text-muted mb-0">Silahkan ubah profile Anda jika terdapat kesalahan penulisan</h4>
                                </div>
                            </div>
                        </div>
                        <div>
                            <form method="POST" action="{{ route('ubah_profile', Auth::user()->nik) }}" autocomplete="off">
                                @csrf
                                @method('PUT')
                                <div class="row bg-white rounded-3 pb-3 mb-3 mx-2">
                                    <div class="page-title-box bg-light-subtle rounded-3 d-flex align-items-center justify-content-between px-3 py-2">
                                        <h5>Form Ubah Profile</h5>
                                    </div>
                                    <div class="block-content">
                                        <div class="row">
                                            <div class="col-md-6 mb-3">
                                                <label for="ubah_nik" class="form-label"><strong>NIK</strong></label>
                                                <input type="text" class="form-control" id="ubah_nik" name="ubah_nik" value="{{ auth()->user()->nik }}">
                                            </div>
                                            <div class="col-md-6 mb-3">
                                                <label for="password_old" class="form-label"><strong>Kata Sandi Lama</strong></label>
                                                <div class="input-group">
                                                    <input id="password_old" class="form-control form-control-alt" type="password" name="password_old" placeholder="Masukkan kata sandi lama" autocomplete="new-password">
                                                    <span class="input-group-text toggle-password" onclick="togglePassword('password_old')">
                                                        <i class="fa fa-eye-slash"></i>
                                                    </span>
                                                </div>
                                            </div>
                                            <div class="col-md-6 mb-3">
                                                <label for="nama" class="form-label"><strong>Nama Lengkap</strong></label>
                                                <input type="text" class="form-control" id="ubah_nama" name="ubah_nama" value="{{ auth()->user()->nama }}">
                                            </div>
                                            <div class="col-md-6 mb-3">
                                                <label for="password_new" class="form-label"><strong>Kata Sandi Baru (Minimal 4 karakter, maksimal 12 karakter)</label>
                                                <div class="input-group">
                                                    <input id="password_new" class="form-control form-control-alt" type="password" name="password_new" placeholder="Masukkan kata sandi baru">
                                                    <span class="input-group-text toggle-password" onclick="togglePassword('password_new')">
                                                        <i class="fa fa-eye-slash"></i>
                                                    </span>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="row justify-content pb-2 mb-2 mx-0">
                                    <div class="col-md-6">
                                        <div class="mb-3 mt-3">
                                            <button id="btn-simpan" class="btn btn-primary" type="submit">
                                                Simpan
                                            </button>
                                            @if(Auth::user()->role == 'Warga')                                            
                                                <a class="btn btn-secondary" href="{{ route("req_surat") }}">
                                                    Kembali
                                                </a>
                                            @endif
                                            @if(Auth::user()->role == 'Pegawai')
                                                <a class="btn btn-secondary" href="{{ url()->previous() }}">
                                                    Kembali
                                                </a>
                                            @endif
                                        </div>
                                    </div>
                                </div>
                            </form>                        
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('script')
    <script>
        function togglePassword(inputId) {
            var passwordInput = document.getElementById(inputId);
            var toggleIcon = passwordInput.nextElementSibling.querySelector('.toggle-password i');
            
            if (passwordInput.type === "password") {
                passwordInput.type = "text";
                toggleIcon.classList.remove('fa-eye-slash');
                toggleIcon.classList.add('fa-eye');
            } else {
                passwordInput.type = "password";
                toggleIcon.classList.remove('fa-eye');
                toggleIcon.classList.add('fa-eye-slash');
            }
        }
    </script>
@endsection