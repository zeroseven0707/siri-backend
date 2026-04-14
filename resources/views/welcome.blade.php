<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="SIRI - Aplikasi Food Delivery & Services Terpercaya. Pesan makanan favorit dan layanan jasa dengan mudah dan cepat.">
    <title>SIRI - Food Delivery & Services App</title>
    <link rel="stylesheet" href="{{ asset('css/style.css') }}">
</head>
<body>
    <!-- Navigation -->
    <nav class="navbar">
        <div class="container">
            <div class="nav-wrapper">
                <div class="logo">
                    <svg width="40" height="40" viewBox="0 0 40 40" fill="none" xmlns="http://www.w3.org/2000/svg">
                        <circle cx="20" cy="20" r="20" fill="url(#gradient)"/>
                        <path d="M20 10L25 15L20 20L15 15L20 10Z" fill="white"/>
                        <path d="M20 20L25 25L20 30L15 25L20 20Z" fill="white" opacity="0.8"/>
                        <defs>
                            <linearGradient id="gradient" x1="0" y1="0" x2="40" y2="40">
                                <stop offset="0%" stop-color="#EC4899"/>
                                <stop offset="50%" stop-color="#F472B6"/>
                                <stop offset="100%" stop-color="#A855F7"/>
                            </linearGradient>
                        </defs>
                    </svg>
                    <span class="logo-text">SIRI</span>
                </div>
                <ul class="nav-menu">
                    <li><a href="#features">Fitur</a></li>
                    <li><a href="#how-it-works">Cara Kerja</a></li>
                    <li><a href="#download">Download</a></li>
                </ul>
            </div>
        </div>
    </nav>

    <!-- Hero Section -->
    <section class="hero">
        <div class="container">
            <div class="hero-content">
                <div class="hero-text">
                    <h1 class="hero-title">
                        Pesan Makanan & Layanan
                        <span class="gradient-text">Dalam Genggaman</span>
                    </h1>
                    <p class="hero-description">
                        SIRI hadir untuk memudahkan hidup Anda. Pesan makanan favorit dari restoran terbaik
                        dan akses berbagai layanan jasa dengan cepat, aman, dan terpercaya.
                    </p>
                    <div class="hero-buttons">
                        <a href="#download" class="btn btn-primary">
                            <svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                <path d="M21 15v4a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2v-4"></path>
                                <polyline points="7 10 12 15 17 10"></polyline>
                                <line x1="12" y1="15" x2="12" y2="3"></line>
                            </svg>
                            Download APK
                        </a>
                        <a href="#features" class="btn btn-secondary">
                            Pelajari Lebih Lanjut
                        </a>
                    </div>
                    <div class="hero-stats">
                        <div class="stat-item">
                            <div class="stat-number">10K+</div>
                            <div class="stat-label">Pengguna Aktif</div>
                        </div>
                        <div class="stat-item">
                            <div class="stat-number">500+</div>
                            <div class="stat-label">Mitra Restoran</div>
                        </div>
                        <div class="stat-item">
                            <div class="stat-number">50K+</div>
                            <div class="stat-label">Pesanan Selesai</div>
                        </div>
                    </div>
                </div>
                <div class="hero-image">
                    <div class="phone-mockup">
                        <div class="phone-frame">
                            <div class="phone-screen">
                                <div class="app-preview">
                                    <div class="preview-header">
                                        <div class="preview-time">12:30</div>
                                        <div class="preview-icons">
                                            <span>📶</span>
                                            <span>🔋</span>
                                        </div>
                                    </div>
                                    <div class="preview-content">
                                        <h3>Mau pesan apa hari ini?</h3>
                                        <div class="preview-cards">
                                            <div class="preview-card">
                                                <span class="card-icon">🍔</span>
                                                <span class="card-text">Food</span>
                                            </div>
                                            <div class="preview-card">
                                                <span class="card-icon">🛵</span>
                                                <span class="card-text">Delivery</span>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="floating-card card-1">
                        <span class="card-emoji">⚡</span>
                        <span class="card-text-small">Pengiriman Cepat</span>
                    </div>
                    <div class="floating-card card-2">
                        <span class="card-emoji">💳</span>
                        <span class="card-text-small">Pembayaran Mudah</span>
                    </div>
                </div>
            </div>
        </div>
        <div class="hero-background">
            <div class="blob blob-1"></div>
            <div class="blob blob-2"></div>
        </div>
    </section>

    <!-- Features Section -->
    <section id="features" class="features">
        <div class="container">
            <div class="section-header">
                <h2 class="section-title">Fitur Unggulan</h2>
                <p class="section-description">Nikmati berbagai kemudahan yang kami tawarkan</p>
            </div>
            <div class="features-grid">
                <div class="feature-card">
                    <div class="feature-icon">
                        <svg width="48" height="48" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                            <path d="M3 9l9-7 9 7v11a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2z"></path>
                            <polyline points="9 22 9 12 15 12 15 22"></polyline>
                        </svg>
                    </div>
                    <h3 class="feature-title">Food Delivery</h3>
                    <p class="feature-description">
                        Pesan makanan dari restoran favorit Anda dengan pilihan menu yang beragam dan harga terjangkau.
                    </p>
                </div>
                <div class="feature-card">
                    <div class="feature-icon">
                        <svg width="48" height="48" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                            <circle cx="12" cy="12" r="10"></circle>
                            <polyline points="12 6 12 12 16 14"></polyline>
                        </svg>
                    </div>
                    <h3 class="feature-title">Pengiriman Cepat</h3>
                    <p class="feature-description">
                        Driver profesional siap mengantar pesanan Anda dengan cepat dan aman ke lokasi tujuan.
                    </p>
                </div>
                <div class="feature-card">
                    <div class="feature-icon">
                        <svg width="48" height="48" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                            <rect x="1" y="4" width="22" height="16" rx="2" ry="2"></rect>
                            <line x1="1" y1="10" x2="23" y2="10"></line>
                        </svg>
                    </div>
                    <h3 class="feature-title">Pembayaran Aman</h3>
                    <p class="feature-description">
                        Berbagai metode pembayaran tersedia dengan sistem keamanan terjamin dan transaksi mudah.
                    </p>
                </div>
                <div class="feature-card">
                    <div class="feature-icon">
                        <svg width="48" height="48" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                            <path d="M17 21v-2a4 4 0 0 0-4-4H5a4 4 0 0 0-4 4v2"></path>
                            <circle cx="9" cy="7" r="4"></circle>
                            <path d="M23 21v-2a4 4 0 0 0-3-3.87"></path>
                            <path d="M16 3.13a4 4 0 0 1 0 7.75"></path>
                        </svg>
                    </div>
                    <h3 class="feature-title">Layanan Jasa</h3>
                    <p class="feature-description">
                        Akses berbagai layanan jasa profesional untuk memenuhi kebutuhan sehari-hari Anda.
                    </p>
                </div>
                <div class="feature-card">
                    <div class="feature-icon">
                        <svg width="48" height="48" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                            <path d="M21 16V8a2 2 0 0 0-1-1.73l-7-4a2 2 0 0 0-2 0l-7 4A2 2 0 0 0 3 8v8a2 2 0 0 0 1 1.73l7 4a2 2 0 0 0 2 0l7-4A2 2 0 0 0 21 16z"></path>
                            <polyline points="3.27 6.96 12 12.01 20.73 6.96"></polyline>
                            <line x1="12" y1="22.08" x2="12" y2="12"></line>
                        </svg>
                    </div>
                    <h3 class="feature-title">Tracking Real-time</h3>
                    <p class="feature-description">
                        Pantau status pesanan Anda secara real-time dari persiapan hingga sampai di tangan Anda.
                    </p>
                </div>
                <div class="feature-card">
                    <div class="feature-icon">
                        <svg width="48" height="48" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                            <polygon points="12 2 15.09 8.26 22 9.27 17 14.14 18.18 21.02 12 17.77 5.82 21.02 7 14.14 2 9.27 8.91 8.26 12 2"></polygon>
                        </svg>
                    </div>
                    <h3 class="feature-title">Promo Menarik</h3>
                    <p class="feature-description">
                        Dapatkan berbagai promo dan diskon menarik setiap harinya untuk menghemat pengeluaran Anda.
                    </p>
                </div>
            </div>
        </div>
    </section>

    <!-- How It Works Section -->
    <section id="how-it-works" class="how-it-works">
        <div class="container">
            <div class="section-header">
                <h2 class="section-title">Cara Kerja</h2>
                <p class="section-description">Mudah dan cepat, hanya dalam 3 langkah</p>
            </div>
            <div class="steps">
                <div class="step">
                    <div class="step-number">1</div>
                    <div class="step-content">
                        <h3 class="step-title">Pilih & Pesan</h3>
                        <p class="step-description">
                            Buka aplikasi, pilih makanan atau layanan yang Anda inginkan, dan lakukan pemesanan dengan mudah.
                        </p>
                    </div>
                </div>
                <div class="step-arrow">→</div>
                <div class="step">
                    <div class="step-number">2</div>
                    <div class="step-content">
                        <h3 class="step-title">Bayar</h3>
                        <p class="step-description">
                            Pilih metode pembayaran yang Anda inginkan dan selesaikan transaksi dengan aman.
                        </p>
                    </div>
                </div>
                <div class="step-arrow">→</div>
                <div class="step">
                    <div class="step-number">3</div>
                    <div class="step-content">
                        <h3 class="step-title">Terima</h3>
                        <p class="step-description">
                            Pantau pesanan Anda dan terima dengan cepat di lokasi yang Anda tentukan.
                        </p>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Download Section -->
    <section id="download" class="download">
        <div class="container">
            <div class="download-content">
                <div class="download-text">
                    <h2 class="download-title">Siap Untuk Memulai?</h2>
                    <p class="download-description">
                        Download aplikasi SIRI sekarang dan nikmati kemudahan pesan makanan dan layanan jasa
                        langsung dari smartphone Anda. Tersedia untuk Android.
                    </p>
                    <div class="download-buttons">
                        <a href="/downloads/siri-app.apk" class="btn btn-download" download>
                            <svg width="24" height="24" viewBox="0 0 24 24" fill="currentColor">
                                <path d="M17.523 15.341c-.1-.3-.2-.6-.3-.9-.1-.3-.2-.6-.3-.9-.1-.3-.2-.6-.3-.9-.1-.3-.2-.6-.3-.9-.1-.3-.2-.6-.3-.9-.1-.3-.2-.6-.3-.9-.1-.3-.2-.6-.3-.9-.1-.3-.2-.6-.3-.9-.1-.3-.2-.6-.3-.9-.1-.3-.2-.6-.3-.9-.1-.3-.2-.6-.3-.9-.1-.3-.2-.6-.3-.9-.1-.3-.2-.6-.3-.9-.1-.3-.2-.6-.3-.9-.1-.3-.2-.6-.3-.9-.1-.3-.2-.6-.3-.9-.1-.3-.2-.6-.3-.9-.1-.3-.2-.6-.3-.9-.1-.3-.2-.6-.3-.9-.1-.3-.2-.6-.3-.9z"/>
                            </svg>
                            <div class="btn-content">
                                <span class="btn-label">Download APK</span>
                                <span class="btn-sublabel">Android App</span>
                            </div>
                        </a>
                    </div>
                    <div class="download-info">
                        <div class="info-item">
                            <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                <path d="M22 11.08V12a10 10 0 1 1-5.93-9.14"></path>
                                <polyline points="22 4 12 14.01 9 11.01"></polyline>
                            </svg>
                            <span>Gratis Download</span>
                        </div>
                        <div class="info-item">
                            <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                <path d="M22 11.08V12a10 10 0 1 1-5.93-9.14"></path>
                                <polyline points="22 4 12 14.01 9 11.01"></polyline>
                            </svg>
                            <span>Aman & Terpercaya</span>
                        </div>
                        <div class="info-item">
                            <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                <path d="M22 11.08V12a10 10 0 1 1-5.93-9.14"></path>
                                <polyline points="22 4 12 14.01 9 11.01"></polyline>
                            </svg>
                            <span>Update Berkala</span>
                        </div>
                    </div>
                </div>
                <div class="download-image">
                    <div class="download-phone">
                        <div class="phone-glow"></div>
                        <div class="download-icon">
                            <svg width="120" height="120" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5">
                                <path d="M21 15v4a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2v-4"></path>
                                <polyline points="7 10 12 15 17 10"></polyline>
                                <line x1="12" y1="15" x2="12" y2="3"></line>
                            </svg>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Footer -->
    <footer class="footer">
        <div class="container">
            <div class="footer-content">
                <div class="footer-section">
                    <div class="footer-logo">
                        <svg width="32" height="32" viewBox="0 0 40 40" fill="none" xmlns="http://www.w3.org/2000/svg">
                            <circle cx="20" cy="20" r="20" fill="url(#gradient2)"/>
                            <path d="M20 10L25 15L20 20L15 15L20 10Z" fill="white"/>
                            <path d="M20 20L25 25L20 30L15 25L20 20Z" fill="white" opacity="0.8"/>
                            <defs>
                                <linearGradient id="gradient2" x1="0" y1="0" x2="40" y2="40">
                                    <stop offset="0%" stop-color="#EC4899"/>
                                    <stop offset="50%" stop-color="#F472B6"/>
                                    <stop offset="100%" stop-color="#A855F7"/>
                                </linearGradient>
                            </defs>
                        </svg>
                        <span class="footer-logo-text">SIRI</span>
                    </div>
                    <p class="footer-description">
                        Aplikasi food delivery dan layanan jasa terpercaya untuk memudahkan hidup Anda.
                    </p>
                </div>
                <div class="footer-section">
                    <h4 class="footer-title">Perusahaan</h4>
                    <ul class="footer-links">
                        <li><a href="#about">Tentang Kami</a></li>
                        <li><a href="#careers">Karir</a></li>
                        <li><a href="#press">Press</a></li>
                        <li><a href="#blog">Blog</a></li>
                    </ul>
                </div>
                <div class="footer-section">
                    <h4 class="footer-title">Bantuan</h4>
                    <ul class="footer-links">
                        <li><a href="#faq">FAQ</a></li>
                        <li><a href="#support">Dukungan</a></li>
                        <li><a href="#privacy">Kebijakan Privasi</a></li>
                        <li><a href="#terms">Syarat & Ketentuan</a></li>
                    </ul>
                </div>
                <div class="footer-section">
                    <h4 class="footer-title">Hubungi Kami</h4>
                    <ul class="footer-links">
                        <li><a href="mailto:info@siri.app">info@siri.app</a></li>
                        <li><a href="tel:+6281234567890">+62 812-3456-7890</a></li>
                    </ul>
                    <div class="social-links">
                        <a href="#" class="social-link" aria-label="Facebook">
                            <svg width="20" height="20" viewBox="0 0 24 24" fill="currentColor">
                                <path d="M24 12.073c0-6.627-5.373-12-12-12s-12 5.373-12 12c0 5.99 4.388 10.954 10.125 11.854v-8.385H7.078v-3.47h3.047V9.43c0-3.007 1.792-4.669 4.533-4.669 1.312 0 2.686.235 2.686.235v2.953H15.83c-1.491 0-1.956.925-1.956 1.874v2.25h3.328l-.532 3.47h-2.796v8.385C19.612 23.027 24 18.062 24 12.073z"/>
                            </svg>
                        </a>
                        <a href="#" class="social-link" aria-label="Instagram">
                            <svg width="20" height="20" viewBox="0 0 24 24" fill="currentColor">
                                <path d="M12 2.163c3.204 0 3.584.012 4.85.07 3.252.148 4.771 1.691 4.919 4.919.058 1.265.069 1.645.069 4.849 0 3.205-.012 3.584-.069 4.849-.149 3.225-1.664 4.771-4.919 4.919-1.266.058-1.644.07-4.85.07-3.204 0-3.584-.012-4.849-.07-3.26-.149-4.771-1.699-4.919-4.92-.058-1.265-.07-1.644-.07-4.849 0-3.204.013-3.583.07-4.849.149-3.227 1.664-4.771 4.919-4.919 1.266-.057 1.645-.069 4.849-.069zm0-2.163c-3.259 0-3.667.014-4.947.072-4.358.2-6.78 2.618-6.98 6.98-.059 1.281-.073 1.689-.073 4.948 0 3.259.014 3.668.072 4.948.2 4.358 2.618 6.78 6.98 6.98 1.281.058 1.689.072 4.948.072 3.259 0 3.668-.014 4.948-.072 4.354-.2 6.782-2.618 6.979-6.98.059-1.28.073-1.689.073-4.948 0-3.259-.014-3.667-.072-4.947-.196-4.354-2.617-6.78-6.979-6.98-1.281-.059-1.69-.073-4.949-.073zm0 5.838c-3.403 0-6.162 2.759-6.162 6.162s2.759 6.163 6.162 6.163 6.162-2.759 6.162-6.163c0-3.403-2.759-6.162-6.162-6.162zm0 10.162c-2.209 0-4-1.79-4-4 0-2.209 1.791-4 4-4s4 1.791 4 4c0 2.21-1.791 4-4 4zm6.406-11.845c-.796 0-1.441.645-1.441 1.44s.645 1.44 1.441 1.44c.795 0 1.439-.645 1.439-1.44s-.644-1.44-1.439-1.44z"/>
                            </svg>
                        </a>
                        <a href="#" class="social-link" aria-label="Twitter">
                            <svg width="20" height="20" viewBox="0 0 24 24" fill="currentColor">
                                <path d="M23.953 4.57a10 10 0 01-2.825.775 4.958 4.958 0 002.163-2.723c-.951.555-2.005.959-3.127 1.184a4.92 4.92 0 00-8.384 4.482C7.69 8.095 4.067 6.13 1.64 3.162a4.822 4.822 0 00-.666 2.475c0 1.71.87 3.213 2.188 4.096a4.904 4.904 0 01-2.228-.616v.06a4.923 4.923 0 003.946 4.827 4.996 4.996 0 01-2.212.085 4.936 4.936 0 004.604 3.417 9.867 9.867 0 01-6.102 2.105c-.39 0-.779-.023-1.17-.067a13.995 13.995 0 007.557 2.209c9.053 0 13.998-7.496 13.998-13.985 0-.21 0-.42-.015-.63A9.935 9.935 0 0024 4.59z"/>
                            </svg>
                        </a>
                    </div>
                </div>
            </div>
            <div class="footer-bottom">
                <p>&copy; 2026 SIRI. All rights reserved.</p>
            </div>
        </div>
    </footer>

    <script src="{{ asset('js/script.js') }}"></script>
</body>
</html>
