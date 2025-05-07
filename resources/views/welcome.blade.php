<!DOCTYPE html>
<html lang="en" class="light-style customizer-hide" dir="ltr" data-theme="theme-default"
    data-assets-path="{{ asset('template/assets/') }}" data-template="vertical-menu-template-free">

<head>
    <meta charset="utf-8" />
    <meta name="viewport"
        content="width=device-width, initial-scale=1.0, user-scalable=no, minimum-scale=1.0, maximum-scale=1.0" />

    <title>Sistem Pengelolaan Jadwal Kunjungan Santri</title>

    <meta name="description" content="" />

    <!-- Favicon -->
    <link rel="icon" type="image/x-icon" href="{{ asset('template/assets/img/favicon/favicon.ico') }}" />

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com" />
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin />
    <link
        href="https://fonts.googleapis.com/css2?family=Public+Sans:ital,wght@0,300;0,400;0,500;0,600;0,700;1,300;1,400;1,500;1,600;1,700&display=swap"
        rel="stylesheet" />

    <!-- Icons. Uncomment required icon fonts -->
    <link rel="stylesheet" href="{{ asset('template/assets/vendor/fonts/boxicons.css') }}" />

    <!-- Core CSS -->
    <link rel="stylesheet" href="{{ asset('template/assets/vendor/css/core.css') }}"
        class="template-customizer-core-css" />
    <link rel="stylesheet" href="{{ asset('template/assets/vendor/css/theme-default.css') }}"
        class="template-customizer-theme-css" />
    <link rel="stylesheet" href="{{ asset('template/assets/css/demo.css') }}" />

    <!-- Vendors CSS -->
    <link rel="stylesheet" href="{{ asset('template/assets/vendor/libs/perfect-scrollbar/perfect-scrollbar.css') }}" />

    <!-- Page CSS -->
    <link rel="stylesheet" href="{{ asset('template/assets/vendor/css/pages/page-auth.css') }}" />

    <!-- Helpers -->
    <script src="{{ asset('template/assets/vendor/js/helpers.js') }}"></script>
    <script src="{{ asset('template/assets/js/config.js') }}"></script>
</head>

<body>
    <!-- Content -->
    <div class="container-xxl">
        <div class="landing-hero-section py-5">
            <div class="container py-5">
                <div class="row align-items-center gy-5">
                    <div class="col-lg-6 text-center text-lg-start">
                        <h1 class="text-primary display-6 fw-bold mb-4">Sistem Pengelolaan Jadwal Kunjungan Santri</h1>
                        <h3 class="mb-3">Pondok Pesantren Salafiyah Al-Jawahir</h3>
                        <p class="mb-4">
                            Selamat datang di Sistem Pengelolaan Jadwal Kunjungan Santri.
                            Sistem ini membantu pengelolaan antrian kunjungan santri dengan lebih efisien menggunakan
                            algoritma FIFO.
                        </p>
                        <div
                            class="d-flex flex-column flex-sm-row gap-3 justify-content-center justify-content-lg-start">
                            <a href="{{ route('login') }}" class="btn btn-primary">Login</a>
                            @if (Route::has('register'))
                                <a href="{{ route('register') }}" class="btn btn-outline-primary">Register</a>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="container py-5">
            <div class="text-center mb-5">
                <h2 class="fw-bold">Fitur Utama</h2>
                <p>Sistem ini dilengkapi dengan berbagai fitur untuk memudahkan pengelolaan kunjungan santri</p>
            </div>

            <div class="row g-4">
                <div class="col-lg-4 col-md-6">
                    <div class="card h-100">
                        <div class="card-body text-center p-4">
                            <div class="avatar avatar-md mx-auto mb-3">
                                <span class="avatar-initial rounded-circle bg-label-primary">
                                    <i class="bx bx-calendar fs-3"></i>
                                </span>
                            </div>
                            <h5 class="mb-2">Jadwal Kunjungan</h5>
                            <p>Daftar dan kelola jadwal kunjungan dengan mudah. Tersedia baik online maupun offline.</p>
                        </div>
                    </div>
                </div>

                <div class="col-lg-4 col-md-6">
                    <div class="card h-100">
                        <div class="card-body text-center p-4">
                            <div class="avatar avatar-md mx-auto mb-3">
                                <span class="avatar-initial rounded-circle bg-label-success">
                                    <i class="bx bx-line-chart fs-3"></i>
                                </span>
                            </div>
                            <h5 class="mb-2">Antrian FIFO</h5>
                            <p>Algoritma First In First Out (FIFO) untuk pengelolaan antrian yang adil dan efisien.</p>
                        </div>
                    </div>
                </div>

                <div class="col-lg-4 col-md-6">
                    <div class="card h-100">
                        <div class="card-body text-center p-4">
                            <div class="avatar avatar-md mx-auto mb-3">
                                <span class="avatar-initial rounded-circle bg-label-info">
                                    <i class="bx bx-package fs-3"></i>
                                </span>
                            </div>
                            <h5 class="mb-2">Pengaturan Barang</h5>
                            <p>Pelabelan dan pelacakan barang untuk mencegah barang tertukar saat kunjungan.</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- / Content -->

    <!-- Core JS -->
    <script src="{{ asset('template/assets/vendor/libs/jquery/jquery.js') }}"></script>
    <script src="{{ asset('template/assets/vendor/libs/popper/popper.js') }}"></script>
    <script src="{{ asset('template/assets/vendor/js/bootstrap.js') }}"></script>
    <script src="{{ asset('template/assets/vendor/libs/perfect-scrollbar/perfect-scrollbar.js') }}"></script>
    <script src="{{ asset('template/assets/vendor/js/menu.js') }}"></script>
    <script src="{{ asset('template/assets/js/main.js') }}"></script>
</body>

</html>
