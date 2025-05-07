<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sistem Kunjungan Santri</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        :root {
            /* Skema warna utama */
            --primary: #1F4690;
            /* Biru tua - warna utama */
            --secondary: #3A5BA0;
            /* Biru sedang - warna sekunder */
            --accent: #FFA41B;
            /* Oranye - warna aksen */
            --accent-hover: #FF8C00;
            /* Oranye tua - hover aksen */
            --light: #F0F5FF;
            /* Biru sangat terang - latar */
            --dark: #0F2557;
            /* Biru sangat tua - teks utama */
            --text-light: #6C7A94;
            /* Abu-abu kebiruan - teks sekunder */
            --white: #FFFFFF;
            /* Putih - untuk kontras */
            --success: #4CAF50;
            /* Hijau - untuk elemen sukses */
            --warning: #F9C74F;
            /* Kuning - untuk peringatan */
            --info: #4CC9F0;
            /* Biru muda - untuk informasi */
            --border-radius: 12px;
            /* Radius sudut */
            --shadow: 0 8px 25px rgba(31, 70, 144, 0.1);
            /* Bayangan */
        }

        body {
            font-family: 'Poppins', sans-serif;
            background-color: var(--light);
            color: var(--dark);
            position: relative;
            min-height: 100vh;
            line-height: 1.7;
        }

        .hero-section {
            background: linear-gradient(135deg, rgba(93, 151, 209, 0.95), rgba(13, 42, 109, 0.97)), url('{{ asset('images/landing.jpg') }}') center/cover no-repeat;
            height: 85vh;
            display: flex;
            align-items: center;
            color: white;
            position: relative;
            overflow: hidden;
        }

        .hero-pattern {
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background-image: url("data:image/svg+xml,%3Csvg width='60' height='60' viewBox='0 0 60 60' xmlns='http://www.w3.org/2000/svg'%3E%3Cg fill='none' fill-rule='evenodd'%3E%3Cg fill='%23ffffff' fill-opacity='0.05'%3E%3Cpath d='M36 34v-4h-2v4h-4v2h4v4h2v-4h4v-2h-4zm0-30V0h-2v4h-4v2h4v4h2V6h4V4h-4zM6 34v-4H4v4H0v2h4v4h2v-4h4v-2H6zM6 4V0H4v4H0v2h4v4h2V6h4V4H6z'/%3E%3C/g%3E%3C/g%3E%3C/svg%3E");
            opacity: 0.4;
        }

        .hero-waves {
            position: absolute;
            bottom: 0;
            left: 0;
            width: 100%;
            overflow: hidden;
            line-height: 0;
            z-index: 2;
        }

        .hero-waves svg {
            position: relative;
            display: block;
            width: calc(100% + 1.3px);
            height: 80px;
        }

        .navbar {
            background-color: var(--primary);
            box-shadow: 0 4px 20px rgba(15, 37, 87, 0.1);
            padding: 15px 0;
            transition: all 0.3s ease;
        }

        .navbar.scrolled {
            padding: 10px 0;
            background-color: rgba(31, 70, 144, 0.98);
            box-shadow: 0 5px 25px rgba(0, 0, 0, 0.15);
        }

        .navbar-brand {
            font-weight: 700;
            color: white !important;
            font-size: 1.5rem;
        }

        .navbar-brand i {
            color: var(--accent);
        }

        .nav-link {
            color: rgba(255, 255, 255, 0.9) !important;
            font-weight: 500;
            margin: 0 12px;
            padding: 8px 0;
            position: relative;
            transition: all 0.3s;
        }

        .nav-link::after {
            content: '';
            position: absolute;
            width: 0;
            height: 2px;
            background-color: var(--accent);
            bottom: 0;
            left: 0;
            transition: width 0.3s;
        }

        .nav-link:hover {
            color: white !important;
        }

        .nav-link:hover::after {
            width: 100%;
        }

        .btn {
            padding: 10px 24px;
            font-weight: 500;
            border-radius: 50px;
            transition: all 0.3s ease;
            box-shadow: 0 4px 15px rgba(0, 0, 0, 0.1);
        }

        .btn-primary {
            background-color: var(--primary);
            border-color: var(--primary);
        }

        .btn-primary:hover {
            background-color: var(--secondary);
            border-color: var(--secondary);
            transform: translateY(-3px);
            box-shadow: 0 8px 20px rgba(0, 0, 0, 0.15);
        }

        .btn-accent {
            background-color: var(--accent);
            border-color: var(--accent);
            color: white;
        }

        .btn-accent:hover {
            background-color: var(--accent-hover);
            border-color: var(--accent-hover);
            color: white;
            transform: translateY(-3px);
            box-shadow: 0 8px 20px rgba(0, 0, 0, 0.15);
        }

        .btn-outline-light {
            border-width: 2px;
        }

        .btn-outline-light:hover {
            transform: translateY(-3px);
            box-shadow: 0 8px 20px rgba(0, 0, 0, 0.15);
        }

        .btn-lg {
            padding: 12px 30px;
            font-size: 1.1rem;
        }

        .card {
            border: none;
            border-radius: var(--border-radius);
            box-shadow: var(--shadow);
            transition: transform 0.3s ease, box-shadow 0.3s ease;
            overflow: hidden;
        }

        .card:hover {
            transform: translateY(-8px);
            box-shadow: 0 15px 35px rgba(31, 70, 144, 0.15);
        }

        .card-icon {
            width: 85px;
            height: 85px;
            background-color: rgba(31, 70, 144, 0.1);
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            margin: 0 auto 25px;
            color: var(--primary);
            font-size: 32px;
            transition: all 0.3s ease;
        }

        .card:hover .card-icon {
            background-color: var(--primary);
            color: white;
            transform: scale(1.1);
        }

        .features-section {
            padding: 100px 0;
            background-color: white;
            position: relative;
        }

        .features-section::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background-image: url("data:image/svg+xml,%3Csvg width='60' height='60' viewBox='0 0 60 60' xmlns='http://www.w3.org/2000/svg'%3E%3Cg fill='none' fill-rule='evenodd'%3E%3Cg fill='%231F4690' fill-opacity='0.03'%3E%3Cpath d='M36 34v-4h-2v4h-4v2h4v4h2v-4h4v-2h-4zm0-30V0h-2v4h-4v2h4v4h2V6h4V4h-4zM6 34v-4H4v4H0v2h4v4h2v-4h4v-2H6zM6 4V0H4v4H0v2h4v4h2V6h4V4H6z'/%3E%3C/g%3E%3C/g%3E%3C/svg%3E");
        }

        .feature-card {
            padding: 40px 30px;
            text-align: center;
            height: 100%;
            background-color: white;
            position: relative;
            z-index: 2;
            border-bottom: 4px solid transparent;
            transition: all 0.3s ease;
        }

        .feature-card:hover {
            border-bottom: 4px solid var(--accent);
        }

        .feature-card h4 {
            margin: 20px 0;
            color: var(--dark);
            font-weight: 600;
            font-size: 1.4rem;
        }

        .feature-card p {
            color: var(--text-light);
            margin-bottom: 0;
        }

        .testimonial-section {
            background-color: rgba(31, 70, 144, 0.03);
            padding: 100px 0;
            position: relative;
        }

        .testimonial-card {
            padding: 40px 30px;
            margin: 20px 10px;
            text-align: center;
            position: relative;
        }

        .testimonial-card::before {
            content: '\f10d';
            font-family: "Font Awesome 5 Free";
            font-weight: 900;
            position: absolute;
            top: 20px;
            left: 20px;
            font-size: 24px;
            color: rgba(31, 70, 144, 0.1);
        }

        .testimonial-img {
            width: 90px;
            height: 90px;
            border-radius: 50%;
            margin: 0 auto 20px;
            object-fit: cover;
            border: 4px solid white;
            box-shadow: 0 5px 15px rgba(0, 0, 0, 0.1);
        }

        .stats-section {
            padding: 80px 0;
            background: linear-gradient(135deg, var(--primary), var(--dark));
            color: white;
            position: relative;
            overflow: hidden;
        }

        .stats-pattern {
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background-image: url("data:image/svg+xml,%3Csvg width='60' height='60' viewBox='0 0 60 60' xmlns='http://www.w3.org/2000/svg'%3E%3Cg fill='none' fill-rule='evenodd'%3E%3Cg fill='%23ffffff' fill-opacity='0.05'%3E%3Cpath d='M36 34v-4h-2v4h-4v2h4v4h2v-4h4v-2h-4zm0-30V0h-2v4h-4v2h4v4h2V6h4V4h-4zM6 34v-4H4v4H0v2h4v4h2v-4h4v-2H6zM6 4V0H4v4H0v2h4v4h2V6h4V4H6z'/%3E%3C/g%3E%3C/g%3E%3C/svg%3E");
            opacity: 0.4;
        }

        .stat-card {
            text-align: center;
            padding: 30px 20px;
            position: relative;
            z-index: 2;
        }

        .stat-number {
            font-size: 48px;
            font-weight: 700;
            color: var(--accent);
            margin-bottom: 10px;
            display: inline-block;
            position: relative;
        }

        .stat-number::after {
            content: '';
            position: absolute;
            bottom: -10px;
            left: 50%;
            transform: translateX(-50%);
            width: 40px;
            height: 3px;
            background-color: rgba(255, 255, 255, 0.2);
        }

        .stat-label {
            font-size: 20px;
            font-weight: 500;
            margin-top: 15px;
        }

        .gradient-heading {
            background: linear-gradient(45deg, var(--primary), var(--secondary));
            -webkit-background-clip: text;
            background-clip: text;
            color: transparent;
            font-weight: 700;
            position: relative;
            display: inline-block;
        }

        .gradient-heading::after {
            content: '';
            position: absolute;
            bottom: -10px;
            left: 50%;
            transform: translateX(-50%);
            width: 60px;
            height: 3px;
            background: linear-gradient(45deg, var(--primary), var(--accent));
        }

        .section-title {
            position: relative;
            margin-bottom: 50px;
        }

        .contact-section {
            padding: 100px 0;
            background-color: white;
            position: relative;
        }

        .contact-section::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background-image: url("data:image/svg+xml,%3Csvg width='60' height='60' viewBox='0 0 60 60' xmlns='http://www.w3.org/2000/svg'%3E%3Cg fill='none' fill-rule='evenodd'%3E%3Cg fill='%231F4690' fill-opacity='0.03'%3E%3Cpath d='M36 34v-4h-2v4h-4v2h4v4h2v-4h4v-2h-4zm0-30V0h-2v4h-4v2h4v4h2V6h4V4h-4zM6 34v-4H4v4H0v2h4v4h2v-4h4v-2H6zM6 4V0H4v4H0v2h4v4h2V6h4V4H6z'/%3E%3C/g%3E%3C/g%3E%3C/svg%3E");
        }

        .contact-card {
            height: 100%;
            padding: 30px;
            transition: all 0.3s ease;
            position: relative;
            z-index: 2;
        }

        .contact-icon {
            font-size: 28px;
            width: 70px;
            height: 70px;
            border-radius: 50%;
            background-color: rgba(31, 70, 144, 0.1);
            color: var(--primary);
            display: flex;
            align-items: center;
            justify-content: center;
            margin: 0 auto 20px;
            transition: all 0.3s ease;
        }

        .contact-card:hover .contact-icon {
            background-color: var(--primary);
            color: white;
            transform: scale(1.1);
        }

        .form-control {
            padding: 12px 15px;
            border-radius: 8px;
            border: 1px solid rgba(31, 70, 144, 0.1);
            transition: all 0.3s;
        }

        .form-control:focus {
            box-shadow: none;
            border-color: var(--primary);
        }

        footer {
            background-color: var(--dark);
            color: white;
            padding: 70px 0 20px;
            position: relative;
            overflow: hidden;
        }

        .footer-pattern {
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background-image: url("data:image/svg+xml,%3Csvg width='60' height='60' viewBox='0 0 60 60' xmlns='http://www.w3.org/2000/svg'%3E%3Cg fill='none' fill-rule='evenodd'%3E%3Cg fill='%23ffffff' fill-opacity='0.03'%3E%3Cpath d='M36 34v-4h-2v4h-4v2h4v4h2v-4h4v-2h-4zm0-30V0h-2v4h-4v2h4v4h2V6h4V4h-4zM6 34v-4H4v4H0v2h4v4h2v-4h4v-2H6zM6 4V0H4v4H0v2h4v4h2V6h4V4H6z'/%3E%3C/g%3E%3C/g%3E%3C/svg%3E");
        }

        .footer-links h5 {
            font-weight: 600;
            margin-bottom: 25px;
            color: white;
            position: relative;
            display: inline-block;
        }

        .footer-links h5::after {
            content: '';
            position: absolute;
            bottom: -10px;
            left: 0;
            width: 30px;
            height: 2px;
            background-color: var(--accent);
        }

        .footer-links ul {
            list-style: none;
            padding-left: 0;
        }

        .footer-links li {
            margin-bottom: 15px;
        }

        .footer-links a {
            color: rgba(255, 255, 255, 0.7);
            text-decoration: none;
            transition: all 0.3s;
            display: inline-block;
        }

        .footer-links a:hover {
            color: var(--accent);
            transform: translateX(5px);
        }

        .footer-links i {
            color: var(--accent);
            width: 20px;
        }

        .social-icons {
            display: flex;
            gap: 12px;
        }

        .social-icons a {
            width: 40px;
            height: 40px;
            border-radius: 50%;
            background-color: rgba(255, 255, 255, 0.1);
            display: inline-flex;
            align-items: center;
            justify-content: center;
            color: white;
            transition: all 0.3s;
        }

        .social-icons a:hover {
            background-color: var(--accent);
            transform: translateY(-5px);
        }

        /* Animasi */
        .fade-in {
            opacity: 0;
            transform: translateY(30px);
            transition: opacity 0.8s ease, transform 0.8s ease;
        }

        .fade-in.visible {
            opacity: 1;
            transform: translateY(0);
        }

        .slide-in-left {
            opacity: 0;
            transform: translateX(-50px);
            transition: opacity 0.8s ease, transform 0.8s ease;
        }

        .slide-in-left.visible {
            opacity: 1;
            transform: translateX(0);
        }

        .slide-in-right {
            opacity: 0;
            transform: translateX(50px);
            transition: opacity 0.8s ease, transform 0.8s ease;
        }

        .slide-in-right.visible {
            opacity: 1;
            transform: translateX(0);
        }

        /* Responsive */
        @media (max-width: 991px) {
            .hero-section {
                height: auto;
                padding: 100px 0;
            }

            .hero-img {
                margin-top: 50px;
            }
        }

        @media (max-width: 768px) {
            .hero-section {
                text-align: center;
                padding: 80px 0;
            }

            .hero-waves svg {
                height: 40px;
            }

            .navbar-collapse {
                background-color: var(--primary);
                padding: 20px;
                border-radius: 10px;
                margin-top: 15px;
                box-shadow: 0 5px 20px rgba(0, 0, 0, 0.1);
            }

            .navbar-nav {
                align-items: center;
            }

            .nav-link {
                margin: 5px 0;
                padding: 8px 15px;
                border-radius: 5px;
            }

            .nav-link:hover {
                background-color: rgba(255, 255, 255, 0.1);
            }
        }

        /* Floating WhatsApp button */
        .float-whatsapp {
            position: fixed;
            width: 60px;
            height: 60px;
            bottom: 40px;
            right: 40px;
            background-color: #25d366;
            color: #FFF;
            border-radius: 50px;
            text-align: center;
            font-size: 30px;
            box-shadow: 0 5px 15px rgba(0, 0, 0, 0.2);
            z-index: 100;
            display: flex;
            align-items: center;
            justify-content: center;
            text-decoration: none;
            transition: all 0.3s;
        }

        .float-whatsapp:hover {
            background-color: #20ba5a;
            color: #fff;
            transform: scale(1.1) translateY(-5px);
            box-shadow: 0 8px 25px rgba(0, 0, 0, 0.3);
        }

        .back-to-top {
            position: fixed;
            bottom: 110px;
            right: 40px;
            display: none;
            width: 50px;
            height: 50px;
            border-radius: 50%;
            background-color: var(--primary);
            color: white;
            align-items: center;
            justify-content: center;
            z-index: 99;
            box-shadow: 0 5px 15px rgba(0, 0, 0, 0.2);
            transition: all 0.3s ease;
        }

        .back-to-top:hover {
            background-color: var(--secondary);
            transform: translateY(-5px);
            box-shadow: 0 8px 25px rgba(0, 0, 0, 0.3);
        }
    </style>
</head>

<body>
    <!-- Navbar -->
    <nav class="navbar navbar-expand-lg navbar-dark fixed-top">
        <div class="container">
            <a class="navbar-brand" href="#">
                <i class="fas fa-mosque me-2"></i>
                Kunjungan Santri
            </a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav"
                aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav ms-auto">
                    <li class="nav-item">
                        <a class="nav-link active" href="#beranda">Beranda</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="#fitur">Fitur</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="#tentang">Tentang</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="#kontak">Kontak</a>
                    </li>
                </ul>
                <div class="ms-lg-3 mt-3 mt-lg-0 d-flex flex-wrap gap-2">
                    @auth
                        <a href="{{ route(auth()->user()->role . '.dashboard') }}" class="btn btn-light">
                            <i class="fas fa-tachometer-alt me-2"></i>Dashboard
                        </a>
                        <form action="{{ route('logout') }}" method="POST">
                            @csrf
                            <button type="submit" class="btn btn-accent">
                                <i class="fas fa-sign-out-alt me-2"></i>Logout
                            </button>
                        </form>
                    @else
                        <a href="{{ route('login') }}" class="btn btn-light">
                            <i class="fas fa-sign-in-alt me-2"></i>Masuk
                        </a>
                        @if (Route::has('register'))
                            <a href="{{ route('register') }}" class="btn btn-accent">
                                <i class="fas fa-user-plus me-2"></i>Daftar
                            </a>
                        @endif
                    @endauth
                </div>
            </div>
        </div>
    </nav>

    <!-- Hero Section -->
    <section class="hero-section" id="beranda">
        <div class="hero-pattern"></div>
        <div class="container position-relative" style="z-index: 2;">
            <div class="row align-items-center">
                <div class="col-lg-6 slide-in-left">
                    <h1 class="display-4 fw-bold mb-4">Platform Kunjungan Santri Digital Terpadu</h1>
                    <p class="lead mb-5">Manajemen kunjungan pesantren yang mudah, cepat, dan transparan untuk wali
                        santri dan pengelola pesantren dengan fitur lengkap.</p>
                    <div class="d-flex flex-wrap gap-3">
                        <a href="{{ route('login') }}" class="btn btn-accent btn-lg">
                            <i class="fas fa-rocket me-2"></i>Mulai Sekarang
                        </a>
                        <a href="#fitur" class="btn btn-outline-light btn-lg">
                            <i class="fas fa-info-circle me-2"></i>Pelajari Lebih Lanjut
                        </a>
                    </div>
                </div>
                <div class="col-lg-6 text-center slide-in-right hero-img">
                    <img src="{{ asset('images/logo.jpg') }}" alt="Ilustrasi Kunjungan Santri"
                        class="img-fluid rounded-circle" width="420"
                        style="border: 10px solid rgba(255, 255, 255, 0.1); box-shadow: 0 15px 35px rgba(0, 0, 0, 0.2);">
                </div>
            </div>
        </div>
        <div class="hero-waves">
            <svg data-name="Layer 1" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 1200 120"
                preserveAspectRatio="none">
                <path
                    d="M0,0V46.29c47.79,22.2,103.59,32.17,158,28,70.36-5.37,136.33-33.31,206.8-37.5C438.64,32.43,512.34,53.67,583,72.05c69.27,18,138.3,24.88,209.4,13.08,36.15-6,69.85-17.84,104.45-29.34C989.49,25,1113-14.29,1200,52.47V0Z"
                    opacity=".25" class="shape-fill" fill="#FFFFFF"></path>
                <path
                    d="M0,0V15.81C13,36.92,27.64,56.86,47.69,72.05,99.41,111.27,165,111,224.58,91.58c31.15-10.15,60.09-26.07,89.67-39.8,40.92-19,84.73-46,130.83-49.67,36.26-2.85,70.9,9.42,98.6,31.56,31.77,25.39,62.32,62,103.63,73,40.44,10.79,81.35-6.69,119.13-24.28s75.16-39,116.92-43.05c59.73-5.85,113.28,22.88,168.9,38.84,30.2,8.66,59,6.17,87.09-7.5,22.43-10.89,48-26.93,60.65-49.24V0Z"
                    opacity=".5" class="shape-fill" fill="#FFFFFF"></path>
                <path
                    d="M0,0V5.63C149.93,59,314.09,71.32,475.83,42.57c43-7.64,84.23-20.12,127.61-26.46,59-8.63,112.48,12.24,165.56,35.4C827.93,77.22,886,95.24,951.2,90c86.53-7,172.46-45.71,248.8-84.81V0Z"
                    class="shape-fill" fill="#FFFFFF"></path>
            </svg>
        </div>
    </section>

    <!-- Features Section -->
    <section class="features-section" id="fitur">
        <div class="container">
            <div class="text-center mb-5 fade-in section-title">
                <h2 class="gradient-heading mb-3">Fitur Utama</h2>
                <p class="lead text-muted">Kelola kunjungan santri dengan mudah dan efisien</p>
            </div>
            <div class="row g-4">
                <div class="col-md-4 fade-in" style="animation-delay: 0.1s;">
                    <div class="card feature-card">
                        <div class="card-icon">
                            <i class="fas fa-calendar-check"></i>
                        </div>
                        <h4>Jadwalkan Kunjungan</h4>
                        <p>Wali santri dapat menjadwalkan kunjungan secara online dengan mudah dan memilih waktu yang
                            tersedia.</p>
                    </div>
                </div>
                <div class="col-md-4 fade-in" style="animation-delay: 0.2s;">
                    <div class="card feature-card">
                        <div class="card-icon">
                            <i class="fas fa-qrcode"></i>
                        </div>
                        <h4>Verifikasi Digital</h4>
                        <p>Sistem verifikasi kunjungan dengan QR Code untuk memastikan keamanan dan kecepatan proses.
                        </p>
                    </div>
                </div>
                <div class="col-md-4 fade-in" style="animation-delay: 0.3s;">
                    <div class="card feature-card">
                        <div class="card-icon">
                            <i class="fas fa-chart-line"></i>
                        </div>
                        <h4>Laporan & Statistik</h4>
                        <p>Dapatkan laporan dan statistik kunjungan secara real-time untuk evaluasi dan pengambilan
                            keputusan.</p>
                    </div>
                </div>
                <div class="col-md-4 fade-in" style="animation-delay: 0.4s;">
                    <div class="card feature-card">
                        <div class="card-icon">
                            <i class="fas fa-bell"></i>
                        </div>
                        <h4>Notifikasi</h4>
                        <p>Dapatkan notifikasi otomatis untuk jadwal, perubahan, dan pengingat kunjungan yang akan
                            datang.</p>
                    </div>
                </div>
                <div class="col-md-4 fade-in" style="animation-delay: 0.5s;">
                    <div class="card feature-card">
                        <div class="card-icon">
                            <i class="fas fa-user-shield"></i>
                        </div>
                        <h4>Manajemen Wali Santri</h4>
                        <p>Kelola data wali santri dengan mudah untuk memastikan keamanan kunjungan dan verifikasi
                            identitas.</p>
                    </div>
                </div>
                <div class="col-md-4 fade-in" style="animation-delay: 0.6s;">
                    <div class="card feature-card">
                        <div class="card-icon">
                            <i class="fas fa-history"></i>
                        </div>
                        <h4>Riwayat Kunjungan</h4>
                        <p>Akses riwayat kunjungan untuk transparansi dan keperluan dokumentasi.</p>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Stats Section -->
    <section class="stats-section">
        <div class="stats-pattern"></div>
        <div class="container position-relative" style="z-index: 2;">
            <div class="row">
                <div class="col-md-3 col-6 fade-in">
                    <div class="stat-card">
                        <div class="stat-number" data-count="500">500+</div>
                        <div class="stat-label">Santri</div>
                    </div>
                </div>
                <div class="col-md-3 col-6 fade-in" style="animation-delay: 0.1s;">
                    <div class="stat-card">
                        <div class="stat-number" data-count="1200">1,200+</div>
                        <div class="stat-label">Wali Santri</div>
                    </div>
                </div>
                <div class="col-md-3 col-6 fade-in" style="animation-delay: 0.2s;">
                    <div class="stat-card">
                        <div class="stat-number" data-count="3000">3,000+</div>
                        <div class="stat-label">Kunjungan</div>
                    </div>
                </div>
                <div class="col-md-3 col-6 fade-in" style="animation-delay: 0.3s;">
                    <div class="stat-card">
                        <div class="stat-number" data-count="98">98%</div>
                        <div class="stat-label">Kepuasan</div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- About Section -->
    <section class="py-5 position-relative" id="tentang" style="padding: 100px 0; background-color: white;">
        <div class="container">
            <div class="row align-items-center">
                <div class="col-lg-6 slide-in-left">
                    <img src="{{ asset('images/logo.jpg') }}" alt="Tentang Kami"
                        class="img-fluid rounded-lg shadow-lg"
                        style="border: 10px solid white; box-shadow: 0 20px 40px rgba(31, 70, 144, 0.1);">
                </div>
                <div class="col-lg-6 slide-in-right" style="animation-delay: 0.2s;">
                    <h2 class="gradient-heading mb-4">Tentang Kami</h2>
                    <p class="lead mb-4">Sistem Kunjungan Santri adalah platform digital terintegrasi untuk mengelola
                        proses kunjungan di pesantren secara efisien.</p>
                    <div class="mb-4">
                        <div class="d-flex align-items-center mb-3">
                            <div class="icon-box me-3" style="color: var(--primary); font-size: 24px;">
                                <i class="fas fa-check-circle"></i>
                            </div>
                            <p class="mb-0">Pengalaman kunjungan yang lebih terstruktur dan sistematis</p>
                        </div>
                        <div class="d-flex align-items-center mb-3">
                            <div class="icon-box me-3" style="color: var(--primary); font-size: 24px;">
                                <i class="fas fa-check-circle"></i>
                            </div>
                            <p class="mb-0">Peningkatan keamanan dan kontrol akses pengunjung</p>
                        </div>
                        <div class="d-flex align-items-center">
                            <div class="icon-box me-3" style="color: var(--primary); font-size: 24px;">
                                <i class="fas fa-check-circle"></i>
                            </div>
                            <p class="mb-0">Laporan komprehensif untuk analisis dan pengambilan keputusan</p>
                        </div>
                    </div>
                    <div class="d-flex flex-wrap gap-3 mt-4">
                        <a href="#kontak" class="btn btn-primary">
                            <i class="fas fa-envelope me-2"></i>Hubungi Kami
                        </a>
                        <a href="#fitur" class="btn btn-outline-secondary">
                            <i class="fas fa-list-ul me-2"></i>Lihat Fitur
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Testimonial Section -->
    <section class="testimonial-section">
        <div class="container">
            <div class="text-center mb-5 fade-in section-title">
                <h2 class="gradient-heading mb-3">Testimoni</h2>
                <p class="lead text-muted">Apa kata pengguna tentang Aplikasi Kunjungan Santri</p>
            </div>
            <div class="row">
                <div class="col-md-4 fade-in" style="animation-delay: 0.1s;">
                    <div class="card testimonial-card">
                        <img src="{{ asset('images/bg2.png') }}" alt="Testimonial" class="testimonial-img">
                        <h5 class="mb-2 fw-bold">Ahmad Fauzi</h5>
                        <p class="text-primary mb-3 fw-medium">Wali Santri</p>
                        <p class="mb-4">"Sangat memudahkan kami para wali santri untuk mengatur jadwal kunjungan.
                            Antarmuka yang
                            intuitif dan proses yang sangat cepat!"</p>
                        <div class="text-warning">
                            <i class="fas fa-star"></i>
                            <i class="fas fa-star"></i>
                            <i class="fas fa-star"></i>
                            <i class="fas fa-star"></i>
                            <i class="fas fa-star"></i>
                        </div>
                    </div>
                </div>
                <div class="col-md-4 fade-in" style="animation-delay: 0.2s;">
                    <div class="card testimonial-card">
                        <img src="{{ asset('images/bg2.png') }}" alt="Testimonial" class="testimonial-img">
                        <h5 class="mb-2 fw-bold">Hj. Siti Aminah</h5>
                        <p class="text-primary mb-3 fw-medium">Pengelola Pesantren</p>
                        <p class="mb-4">"Aplikasi ini sangat membantu kami dalam mengelola kunjungan. Laporan yang
                            dihasilkan sangat
                            detail dan memudahkan kami dalam mengambil keputusan."</p>
                        <div class="text-warning">
                            <i class="fas fa-star"></i>
                            <i class="fas fa-star"></i>
                            <i class="fas fa-star"></i>
                            <i class="fas fa-star"></i>
                            <i class="fas fa-star-half-alt"></i>
                        </div>
                    </div>
                </div>
                <div class="col-md-4 fade-in" style="animation-delay: 0.3s;">
                    <div class="card testimonial-card">
                        <img src="{{ asset('images/bg2.png') }}" alt="Testimonial" class="testimonial-img">
                        <h5 class="mb-2 fw-bold">Fathurrahman</h5>
                        <p class="text-primary mb-3 fw-medium">Petugas Keamanan</p>
                        <p class="mb-4">"Verifikasi pengunjung menjadi lebih cepat dan akurat. Sistem ini sangat
                            membantu kami dalam
                            menjaga keamanan di pesantren."</p>
                        <div class="text-warning">
                            <i class="fas fa-star"></i>
                            <i class="fas fa-star"></i>
                            <i class="fas fa-star"></i>
                            <i class="fas fa-star"></i>
                            <i class="fas fa-star"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Contact Section -->
    <section class="contact-section" id="kontak">
        <div class="container">
            <div class="text-center mb-5 fade-in section-title">
                <h2 class="gradient-heading mb-3">Hubungi Kami</h2>
                <p class="lead text-muted">Punya pertanyaan? Jangan ragu untuk menghubungi kami</p>
            </div>
            <div class="row g-4">
                <div class="col-md-4 fade-in" style="animation-delay: 0.1s;">
                    <div class="card contact-card h-100">
                        <div class="card-body text-center">
                            <div class="contact-icon">
                                <i class="fas fa-map-marker-alt"></i>
                            </div>
                            <h5 class="my-3 fw-bold">Alamat</h5>
                            <p>Jl. Pesantren No. 123, Kota Bandung, Jawa Barat, Indonesia</p>
                        </div>
                    </div>
                </div>
                <div class="col-md-4 fade-in" style="animation-delay: 0.2s;">
                    <div class="card contact-card h-100">
                        <div class="card-body text-center">
                            <div class="contact-icon">
                                <i class="fas fa-phone-alt"></i>
                            </div>
                            <h5 class="my-3 fw-bold">Telepon</h5>
                            <p>+62 123 4567 890<br>+62 987 6543 210</p>
                        </div>
                    </div>
                </div>
                <div class="col-md-4 fade-in" style="animation-delay: 0.3s;">
                    <div class="card contact-card h-100">
                        <div class="card-body text-center">
                            <div class="contact-icon">
                                <i class="fas fa-envelope"></i>
                            </div>
                            <h5 class="my-3 fw-bold">Email</h5>
                            <p>info@kunjungansantri.com<br>admin@kunjungansantri.com</p>
                        </div>
                    </div>
                </div>
            </div>
            <div class="row mt-5">
                <div class="col-lg-6 fade-in" style="animation-delay: 0.4s;">
                    <div class="card">
                        <div class="card-body p-4">
                            <h5 class="card-title mb-4 fw-bold">Kirim Pesan</h5>
                            <form>
                                <div class="mb-3">
                                    <label for="name" class="form-label">Nama Lengkap</label>
                                    <input type="text" class="form-control" id="name"
                                        placeholder="Masukkan nama lengkap">
                                </div>
                                <div class="mb-3">
                                    <label for="email" class="form-label">Email</label>
                                    <input type="email" class="form-control" id="email"
                                        placeholder="Masukkan email">
                                </div>
                                <div class="mb-3">
                                    <label for="subject" class="form-label">Subjek</label>
                                    <input type="text" class="form-control" id="subject"
                                        placeholder="Masukkan subjek">
                                </div>
                                <div class="mb-3">
                                    <label for="message" class="form-label">Pesan</label>
                                    <textarea class="form-control" id="message" rows="5" placeholder="Tuliskan pesan Anda"></textarea>
                                </div>
                                <button type="submit" class="btn btn-primary btn-lg w-100">
                                    <i class="fas fa-paper-plane me-2"></i>Kirim Pesan
                                </button>
                            </form>
                        </div>
                    </div>
                </div>
                <div class="col-lg-6 fade-in" style="animation-delay: 0.5s;">
                    <div class="card h-100">
                        <div class="card-body p-4">
                            <h5 class="card-title mb-4 fw-bold">Lokasi Kami</h5>
                            <div class="ratio ratio-16x9 rounded overflow-hidden shadow-sm">
                                <iframe
                                    src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3960.5983145543083!2d107.60866797461184!3d-6.938926994203137!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x2e68e8afd627a8a3%3A0x40b731905268c0bd!2sBandung%2C%20Kota%20Bandung%2C%20Jawa%20Barat!5e0!3m2!1sid!2sid!4v1683890700206!5m2!1sid!2sid"
                                    width="600" height="450" style="border:0;" allowfullscreen=""
                                    loading="lazy" referrerpolicy="no-referrer-when-downgrade"></iframe>
                            </div>
                            <div class="mt-4">
                                <h6 class="fw-bold mb-3">Jam Operasional</h6>
                                <div class="d-flex justify-content-between mb-2">
                                    <span>Senin - Jumat</span>
                                    <span class="fw-medium">08:00 - 16:00</span>
                                </div>
                                <div class="d-flex justify-content-between mb-2">
                                    <span>Sabtu</span>
                                    <span class="fw-medium">09:00 - 14:00</span>
                                </div>
                                <div class="d-flex justify-content-between">
                                    <span>Minggu</span>
                                    <span class="fw-medium">Tutup</span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Footer -->
    <footer>
        <div class="footer-pattern"></div>
        <div class="container position-relative" style="z-index: 2;">
            <div class="row g-4">
                <div class="col-lg-4">
                    <h3 class="mb-4"><i class="fas fa-mosque me-2" style="color: var(--accent);"></i> Kunjungan
                        Santri</h3>
                    <p>Sistem manajemen kunjungan santri digital yang dirancang untuk memudahkan proses kunjungan wali
                        santri ke pesantren.</p>
                    <div class="social-icons mt-4">
                        <a href="#"><i class="fab fa-facebook-f"></i></a>
                        <a href="#"><i class="fab fa-twitter"></i></a>
                        <a href="#"><i class="fab fa-instagram"></i></a>
                        <a href="#"><i class="fab fa-youtube"></i></a>
                        <a href="#"><i class="fab fa-linkedin-in"></i></a>
                    </div>
                </div>
                <div class="col-lg-2 col-md-4 footer-links">
                    <h5>Tautan</h5>
                    <ul>
                        <li><a href="#beranda"><i class="fas fa-chevron-right me-1"></i> Beranda</a></li>
                        <li><a href="#fitur"><i class="fas fa-chevron-right me-1"></i> Fitur</a></li>
                        <li><a href="#tentang"><i class="fas fa-chevron-right me-1"></i> Tentang</a></li>
                        <li><a href="#kontak"><i class="fas fa-chevron-right me-1"></i> Kontak</a></li>
                    </ul>
                </div>
                <div class="col-lg-2 col-md-4 footer-links">
                    <h5>Layanan</h5>
                    <ul>
                        <li><a href="#"><i class="fas fa-chevron-right me-1"></i> Registrasi Wali</a></li>
                        <li><a href="#"><i class="fas fa-chevron-right me-1"></i> Jadwal Kunjungan</a></li>
                        <li><a href="#"><i class="fas fa-chevron-right me-1"></i> Panduan Penggunaan</a></li>
                        <li><a href="#"><i class="fas fa-chevron-right me-1"></i> FAQ</a></li>
                    </ul>
                </div>
                <div class="col-lg-4 col-md-4 footer-links">
                    <h5>Informasi Kontak</h5>
                    <ul>
                        <li><i class="fas fa-map-marker-alt me-2"></i> Jl. Pesantren No. 123, Bandung</li>
                        <li><i class="fas fa-phone-alt me-2"></i> +62 123 4567 890</li>
                        <li><i class="fas fa-envelope me-2"></i> info@kunjungansantri.com</li>
                        <li><i class="fas fa-clock me-2"></i> Senin - Jumat: 08:00 - 16:00</li>
                    </ul>
                </div>
            </div>
            <hr class="mt-4 mb-4" style="border-color: rgba(255, 255, 255, 0.1);">
            <div class="row">
                <div class="col-md-6">
                    <p class="mb-md-0">&copy; {{ date('Y') }} Sistem Kunjungan Santri. All Rights Reserved.</p>
                </div>
                <div class="col-md-6 text-md-end">
                    <a href="#" class="text-white me-3">Kebijakan Privasi</a>
                    <a href="#" class="text-white me-3">Syarat & Ketentuan</a>
                    <a href="#" class="text-white">Bantuan</a>
                </div>
            </div>
        </div>
    </footer>

    <!-- Floating WhatsApp Button -->
    <a href="https://wa.me/6212345678901" class="float-whatsapp" target="_blank">
        <i class="fab fa-whatsapp"></i>
    </a>

    <!-- Back to Top Button -->
    <a href="#beranda" class="back-to-top">
        <i class="fas fa-arrow-up"></i>
    </a>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        // Aktivasi scroll navbar
        document.addEventListener('DOMContentLoaded', function() {
            const navbar = document.querySelector('.navbar');

            window.addEventListener('scroll', function() {
                if (window.scrollY > 50) {
                    navbar.classList.add('scrolled');
                } else {
                    navbar.classList.remove('scrolled');
                }
            });

            // Animasi fade-in dan slide
            const animatedElements = document.querySelectorAll('.fade-in, .slide-in-left, .slide-in-right');

            function checkAnimation() {
                animatedElements.forEach(element => {
                    const elementTop = element.getBoundingClientRect().top;
                    const elementVisible = 150;

                    if (elementTop < window.innerHeight - elementVisible) {
                        element.classList.add('visible');
                    }
                });
            }

            // Initial check
            checkAnimation();

            // Check on scroll
            window.addEventListener('scroll', checkAnimation);

            // Back to top button
            const backToTopButton = document.querySelector('.back-to-top');

            window.addEventListener('scroll', function() {
                if (window.scrollY > 300) {
                    backToTopButton.style.display = 'flex';
                } else {
                    backToTopButton.style.display = 'none';
                }
            });

            // Smooth scroll for links
            document.querySelectorAll('a[href^="#"]').forEach(anchor => {
                anchor.addEventListener('click', function(e) {
                    e.preventDefault();

                    const target = document.querySelector(this.getAttribute('href'));
                    if (target) {
                        window.scrollTo({
                            top: target.offsetTop - 80,
                            behavior: 'smooth'
                        });
                    }
                });
            });

            // Count animation for stats
            const statNumbers = document.querySelectorAll('.stat-number');

            function animateValue(element, start, end, duration) {
                let startTimestamp = null;
                const step = (timestamp) => {
                    if (!startTimestamp) startTimestamp = timestamp;
                    const progress = Math.min((timestamp - startTimestamp) / duration, 1);
                    const value = Math.floor(progress * (end - start) + start);
                    element.textContent = value + (element.dataset.count > 100 ? '+' : '%');
                    if (progress < 1) {
                        window.requestAnimationFrame(step);
                    }
                };
                window.requestAnimationFrame(step);
            }

            // Intersection Observer for stat counters
            const statObserver = new IntersectionObserver((entries) => {
                entries.forEach((entry) => {
                    if (entry.isIntersecting) {
                        const element = entry.target;
                        const end = parseInt(element.dataset.count);
                        animateValue(element, 0, end, 2000);
                        statObserver.unobserve(element);
                    }
                });
            }, {
                threshold: 0.5
            });

            statNumbers.forEach(stat => {
                statObserver.observe(stat);
            });
        });
    </script>
</body>

</html>
