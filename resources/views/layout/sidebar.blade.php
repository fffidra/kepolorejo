<div class="vertical-menu">
    <!-- LOGO -->
    <div class="navbar-brand-box">
        <a href="index.html" class="logo">
            <span class="logo-lg">
                <img src="{{ asset('assets/images/logo-kab-magetan.png') }}" alt="" height="22"> <span class="logo-txt">E-Surat</span>
            </span>
            <span class="logo-sm">
                <img src="{{ asset('assets/images/logo-kab-magetan.png') }}" alt="" height="22">
            </span>
        </a>
    </div>
    <button type="button" class="btn btn-sm px-3 font-size-16 header-item vertical-menu-btn">
        <i class="fa fa-fw fa-bars"></i>
    </button>
    <div data-simplebar class="sidebar-menu-scroll">
        <div id="sidebar-menu">
            <ul class="metismenu list-unstyled" id="side-menu">
                <li class="menu-title" data-key="t-applications">MENU SURAT</li>
                @if(Auth::user()->role == 'Pegawai' || Auth::user()->role == 'SuperAdmin')
                <li>                    
                    <li>
                        <a href="{{ route('surat.surat_masuk') }}">
                            <i class="bx bx-envelope icon nav-icon"></i>
                            <span class="menu-item" data-key="t-calendar">Surat Masuk</span>
                        </a>
                    </li>
                    <li>
                        <a href="{{ route('surat.surat_disetujui') }}">
                            <i class="bx bx-envelope icon nav-icon"></i>
                            <span class="menu-item" data-key="t-email">Surat Disetujui</span>
                        </a>
                    </li>
                    <li>
                        <a href="{{ route('surat.surat_ditolak') }}">
                            <i class="bx bx-envelope icon nav-icon"></i>
                            <span class="menu-item" data-key="t-email">Surat Ditolak</span>
                        </a>
                    </li>
                @endif

                @if(Auth::user()->role == 'Warga')
                    <li>
                        <a href="{{ route('req_surat') }}">
                            <i class="bx bx-envelope icon nav-icon"></i>
                            <span class="menu-item" data-key="t-calendar">Pengajuan Surat</span>
                        </a>
                    </li>
                    <li class="menu-title" data-key="t-applications">DESKRIPSI SURAT</li>
                    <li>
                        <a href="{{ route('des_skbm') }}">
                            <i class="bx bx-envelope icon nav-icon"></i>
                            <span class="menu-item" data-key="t-calendar">SK Belum Menikah</span>
                        </a>
                    </li>
                    <li>
                        <a href="{{ route('des_skd') }}">
                            <i class="bx bx-envelope icon nav-icon"></i>
                            <span class="menu-item" data-key="t-calendar">SK Domisili</span>
                        </a>
                    </li>
                    <li>
                        <a href="{{ route('des_sktm') }}">
                            <i class="bx bx-envelope icon nav-icon"></i>
                            <span class="menu-item" data-key="t-calendar">SK Tidak Mampu</span>
                        </a>
                    </li>
                    <li>
                        <a href="{{ route('des_sku') }}">
                            <i class="bx bx-envelope icon nav-icon"></i>
                            <span class="menu-item" data-key="t-calendar">SK Usaha</span>
                        </a>
                    </li>
                @endif

                @if(Auth::user()->role == 'Pegawai' || Auth::user()->role == 'SuperAdmin')
                <li>                    
                    <li class="menu-title" data-key="t-applications">DATA MASTER</li>
                    <li>
                        <a href="{{ route('jabatan') }}">
                            <i class=" mdi mdi-checkbox-blank-circle-outline"></i>
                            <span class="menu-item" data-key="t-calendar">Data Jabatan</span>
                        </a>
                    </li>
                @endif
                @if(Auth::user()->role == 'SuperAdmin')
                    <li>
                        <a href="{{ route('pegawai') }}">
                            <i class=" mdi mdi-checkbox-blank-circle-outline"></i>
                            <span class="menu-item" data-key="t-calendar">Data Pegawai</span>
                        </a>
                    </li>
                    <li>
                        <a href="{{ route('warga') }}">
                            <i class=" mdi mdi-checkbox-blank-circle-outline"></i>
                            <span class="menu-item" data-key="t-calendar">Data Warga</span>
                        </a>
                    </li>
                @endif
                @if(Auth::user()->role == 'Pegawai' || Auth::user()->role == 'SuperAdmin')
                    <li class="menu-title" data-key="t-applications">RIWAYAT SURAT</li>
                    <li>
                        <a href="{{ route('surat.skbm') }}">
                            <i class="bx bx-envelope icon nav-icon"></i>
                            <span class="menu-item" data-key="t-calendar">SK Belum Menikah</span>
                        </a>
                    </li>
                    <li>
                        <a href="{{ route('surat.skd') }}">
                            <i class="bx bx-envelope icon nav-icon"></i>
                            <span class="menu-item" data-key="t-calendar">SK Domisili</span>
                        </a>
                    </li>
                    <li>
                        <a href="{{ route('surat.sktm') }}">
                            <i class="bx bx-envelope icon nav-icon"></i>
                            <span class="menu-item" data-key="t-calendar">SK Tidak Mampu</span>
                        </a>
                    </li>
                    <li>
                        <a href="{{ route('surat.sku') }}">
                            <i class="bx bx-envelope icon nav-icon"></i>
                            <span class="menu-item" data-key="t-calendar">SK Usaha</span>
                        </a>
                    </li>
                </li>
                @endif
            </ul>
        </div>
    </div>
</div>