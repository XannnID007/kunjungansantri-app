<aside id="layout-menu" class="layout-menu menu-vertical menu bg-menu-theme">
    <div class="app-brand demo">
        <a href="{{ route('home') }}" class="app-brand-link">
            <span class="app-brand-logo demo">
                <img src="{{ asset('images/logo.jpg') }}" alt="Logo Pesantren" height="40">
            </span>
            <span class="app-brand-text demo menu-text fw-bolder ms-2">Al-Jawahir</span>
        </a>

        <a href="javascript:void(0);" class="layout-menu-toggle menu-link text-large ms-auto d-block d-xl-none">
            <i class="bx bx-chevron-left bx-sm align-middle"></i>
        </a>
    </div>

    <div class="menu-inner-shadow"></div>

    <ul class="menu-inner py-1">
        @auth
            @if (auth()->user()->isAdmin())
                <!-- Admin Menu -->
                <li class="menu-item {{ request()->routeIs('admin.dashboard') ? 'active' : '' }}">
                    <a href="{{ route('admin.dashboard') }}" class="menu-link">
                        <i class="menu-icon tf-icons bx bx-home-circle"></i>
                        <div data-i18n="Analytics">Dashboard</div>
                    </a>
                </li>

                <li class="menu-header small text-uppercase">
                    <span class="menu-header-text">Master Data</span>
                </li>

                <li class="menu-item {{ request()->routeIs('admin.santri.*') ? 'active' : '' }}">
                    <a href="{{ route('admin.santri.index') }}" class="menu-link">
                        <i class="menu-icon tf-icons bx bx-user"></i>
                        <div data-i18n="Basic">Data Santri</div>
                    </a>
                </li>

                <li class="menu-item {{ request()->routeIs('admin.wali-santri.*') ? 'active' : '' }}">
                    <a href="{{ route('admin.wali-santri.index') }}" class="menu-link">
                        <i class="menu-icon tf-icons bx bx-group"></i>
                        <div data-i18n="Basic">Data Wali Santri</div>
                    </a>
                </li>

                <li class="menu-item {{ request()->routeIs('admin.jadwal.*') ? 'active' : '' }}">
                    <a href="{{ route('admin.jadwal.index') }}" class="menu-link">
                        <i class="menu-icon tf-icons bx bx-calendar"></i>
                        <div data-i18n="Basic">Jadwal Operasional</div>
                    </a>
                </li>

                <li class="menu-header small text-uppercase">
                    <span class="menu-header-text">Kunjungan</span>
                </li>

                <li class="menu-item {{ request()->routeIs('admin.kunjungan.*') ? 'active' : '' }}">
                    <a href="{{ route('admin.kunjungan.index') }}" class="menu-link">
                        <i class="menu-icon tf-icons bx bx-clipboard"></i>
                        <div data-i18n="Basic">Data Kunjungan</div>
                    </a>
                </li>

                <li class="menu-header small text-uppercase">
                    <span class="menu-header-text">Laporan</span>
                </li>

                <li class="menu-item {{ request()->routeIs('admin.laporan.*') ? 'active' : '' }}">
                    <a href="{{ route('admin.laporan.index') }}" class="menu-link">
                        <i class="menu-icon tf-icons bx bx-chart"></i>
                        <div data-i18n="Basic">Laporan</div>
                    </a>
                </li>

                <li class="menu-header small text-uppercase">
                    <span class="menu-header-text">Pengaturan</span>
                </li>

                <li class="menu-item {{ request()->routeIs('admin.users.*') ? 'active' : '' }}">
                    <a href="{{ route('admin.users.index') }}" class="menu-link">
                        <i class="menu-icon tf-icons bx bx-lock-open-alt"></i>
                        <div data-i18n="Basic">Manajemen Pengguna</div>
                    </a>
                </li>
            @elseif(auth()->user()->isPetugas())
                <!-- Petugas Menu -->
                <li class="menu-item {{ request()->routeIs('petugas.dashboard') ? 'active' : '' }}">
                    <a href="{{ route('petugas.dashboard') }}" class="menu-link">
                        <i class="menu-icon tf-icons bx bx-home-circle"></i>
                        <div data-i18n="Analytics">Dashboard</div>
                    </a>
                </li>

                <li class="menu-header small text-uppercase">
                    <span class="menu-header-text">Kunjungan</span>
                </li>

                <li class="menu-item {{ request()->routeIs('petugas.antrian.*') ? 'active' : '' }}">
                    <a href="{{ route('petugas.antrian.index') }}" class="menu-link">
                        <i class="menu-icon tf-icons bx bx-list-ol"></i>
                        <div data-i18n="Basic">Antrian Kunjungan</div>
                    </a>
                </li>

                <li class="menu-item {{ request()->routeIs('petugas.kunjungan.*') ? 'active' : '' }}">
                    <a href="{{ route('petugas.kunjungan.index') }}" class="menu-link">
                        <i class="menu-icon tf-icons bx bx-clipboard"></i>
                        <div data-i18n="Basic">Data Kunjungan</div>
                    </a>
                </li>

                <li class="menu-item {{ request()->routeIs('petugas.barang.*') ? 'active' : '' }}">
                    <a href="{{ route('petugas.barang.index') }}" class="menu-link">
                        <i class="menu-icon tf-icons bx bx-package"></i>
                        <div data-i18n="Basic">Pengaturan Barang</div>
                    </a>
                </li>
            @else
                <!-- Wali Santri Menu -->
                <li class="menu-item {{ request()->routeIs('wali.dashboard') ? 'active' : '' }}">
                    <a href="{{ route('wali.dashboard') }}" class="menu-link">
                        <i class="menu-icon tf-icons bx bx-home-circle"></i>
                        <div data-i18n="Analytics">Dashboard</div>
                    </a>
                </li>

                <li class="menu-header small text-uppercase">
                    <span class="menu-header-text">Kunjungan</span>
                </li>

                <li class="menu-item {{ request()->routeIs('wali.kunjungan.create') ? 'active' : '' }}">
                    <a href="{{ route('wali.kunjungan.create') }}" class="menu-link">
                        <i class="menu-icon tf-icons bx bx-calendar-plus"></i>
                        <div data-i18n="Basic">Buat Kunjungan</div>
                    </a>
                </li>

                <li class="menu-item {{ request()->routeIs('wali.kunjungan.index') ? 'active' : '' }}">
                    <a href="{{ route('wali.kunjungan.index') }}" class="menu-link">
                        <i class="menu-icon tf-icons bx bx-history"></i>
                        <div data-i18n="Basic">Riwayat Kunjungan</div>
                    </a>
                </li>

                <li class="menu-item {{ request()->routeIs('wali.jadwal-tersedia') ? 'active' : '' }}">
                    <a href="{{ route('wali.jadwal-tersedia') }}" class="menu-link">
                        <i class="menu-icon tf-icons bx bx-calendar-check"></i>
                        <div data-i18n="Basic">Jadwal Tersedia</div>
                    </a>
                </li>
            @endif
        @endauth
    </ul>
</aside>
