<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="SIRI - Aplikasi Food Delivery & Layanan Jasa Terpercaya. Pesan makanan favorit dan layanan jasa dengan mudah, cepat, dan aman.">
    <title>SIRI — Food Delivery & Services</title>
    <link rel="stylesheet" href="{{ asset('css/styles.css') }}">
</head>
<body>
    <!-- Navigation -->
    <nav class="navbar">
        <div class="container">
            <div class="nav-wrapper">
                <div class="logo">
                    <svg width="36" height="36" viewBox="0 0 40 40" fill="none" xmlns="http://www.w3.org/2000/svg">
                        <circle cx="20" cy="20" r="20" fill="url(#logoGrad)"/>
                        <path d="M20 10L26 16L20 22L14 16L20 10Z" fill="white"/>
                        <path d="M20 18L26 24L20 30L14 24L20 18Z" fill="white" opacity="0.7"/>
                        <defs>
                            <linearGradient id="logoGrad" x1="0" y1="0" x2="40" y2="40">
                                <stop offset="0%" stop-color="#059669"/>
                                <stop offset="100%" stop-color="#16a34a"/>
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
                    <div class="hero-badge">
                        <span class="hero-badge-dot"></span>
                        Tersedia untuk Android
                    </div>
                    <h1 class="hero-title">
                        Pesan Makanan &
                        <span class="gradient-text">Layanan Jasa</span>
                        Dalam Genggaman
                    </h1>
                    <p class="hero-description">
                        SIRI memudahkan Anda memesan makanan dari restoran terbaik dan mengakses
                        berbagai layanan jasa profesional — cepat, aman, dan terpercaya.
                    </p>
                    <div class="hero-buttons">
                        <a href="#download" class="btn btn-primary">
                            <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5">
                                <path d="M21 15v4a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2v-4"></path>
                                <polyline points="7 10 12 15 17 10"></polyline>
                                <line x1="12" y1="15" x2="12" y2="3"></line>
                            </svg>
                            Download APK
                        </a>
                        <a href="#features" class="btn btn-secondary">
                            Pelajari Fitur
                        </a>
                    </div>
                    <div class="hero-stats">
                        <div class="stat-item">
                            <div class="stat-number">10K+</div>
                            <div class="stat-label">Pengguna Aktif</div>
                        </div>
                        <div class="stat-item">
                            <div class="stat-number">500+</div>
                            <div class="stat-label">Mitra Toko</div>
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
                                        <div class="preview-time">09:41</div>
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
                                                <span class="card-text">Food Delivery</span>
                                            </div>
                                            <div class="preview-card">
                                                <span class="card-icon">🛵</span>
                                                <span class="card-text">Layanan Jasa</span>
                                            </div>
                                            <div class="preview-card">
                                                <span class="card-icon">📦</span>
                                                <span class="card-text">Lacak Pesanan</span>
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
                        <span class="card-emoji">🔒</span>
                        <span class="card-text-small">Transaksi Aman</span>
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
                <div class="section-tag">Fitur Unggulan</div>
                <h2 class="section-title">Semua yang Anda Butuhkan</h2>
                <p class="section-description">Dari pesan makan hingga layanan jasa, SIRI hadir sebagai solusi lengkap sehari-hari.</p>
            </div>
            <div class="features-grid">
                <div class="feature-card">
                    <div class="feature-icon">
                        <svg width="28" height="28" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                            <path d="M3 3h2l.4 2M7 13h10l4-8H5.4M7 13L5.4 5M7 13l-2.293 2.293c-.63.63-.184 1.707.707 1.707H17m0 0a2 2 0 1 0 0 4 2 2 0 0 0 0-4zm-8 2a2 2 0 1 0 0 4 2 2 0 0 0 0-4z"></path>
                        </svg>
                    </div>
                    <h3 class="feature-title">Food Delivery</h3>
                    <p class="feature-description">
                        Pesan makanan dari ratusan mitra toko pilihan. Menu beragam, harga transparan, langsung diantar ke lokasi Anda.
                    </p>
                </div>
                <div class="feature-card">
                    <div class="feature-icon">
                        <svg width="28" height="28" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                            <circle cx="12" cy="12" r="10"></circle>
                            <polyline points="12 6 12 12 16 14"></polyline>
                        </svg>
                    </div>
                    <h3 class="feature-title">Pengiriman Cepat</h3>
                    <p class="feature-description">
                        Driver terverifikasi siap mengantar pesanan Anda dengan cepat dan aman ke mana pun Anda berada.
                    </p>
                </div>
                <div class="feature-card">
                    <div class="feature-icon">
                        <svg width="28" height="28" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                            <rect x="1" y="4" width="22" height="16" rx="2" ry="2"></rect>
                            <line x1="1" y1="10" x2="23" y2="10"></line>
                        </svg>
                    </div>
                    <h3 class="feature-title">Pembayaran Aman</h3>
                    <p class="feature-description">
                        Bayar dengan saldo dompet digital SIRI. Transaksi terenkripsi, riwayat lengkap, dan top-up mudah kapan saja.
                    </p>
                </div>
                <div class="feature-card">
                    <div class="feature-icon">
                        <svg width="28" height="28" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                            <path d="M17 21v-2a4 4 0 0 0-4-4H5a4 4 0 0 0-4 4v2"></path>
                            <circle cx="9" cy="7" r="4"></circle>
                            <path d="M23 21v-2a4 4 0 0 0-3-3.87"></path>
                            <path d="M16 3.13a4 4 0 0 1 0 7.75"></path>
                        </svg>
                    </div>
                    <h3 class="feature-title">Layanan Jasa</h3>
                    <p class="feature-description">
                        Akses berbagai layanan jasa profesional untuk kebutuhan sehari-hari, langsung dari satu aplikasi.
                    </p>
                </div>
                <div class="feature-card">
                    <div class="feature-icon">
                        <svg width="28" height="28" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                            <path d="M21 10c0 7-9 13-9 13s-9-6-9-13a9 9 0 0 1 18 0z"></path>
                            <circle cx="12" cy="10" r="3"></circle>
                        </svg>
                    </div>
                    <h3 class="feature-title">Tracking Real-time</h3>
                    <p class="feature-description">
                        Pantau posisi driver dan status pesanan secara langsung — dari konfirmasi toko hingga tiba di tangan Anda.
                    </p>
                </div>
                <div class="feature-card">
                    <div class="feature-icon">
                        <svg width="28" height="28" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                            <path d="M18 8h1a4 4 0 0 1 0 8h-1"></path>
                            <path d="M2 8h16v9a4 4 0 0 1-4 4H6a4 4 0 0 1-4-4V8z"></path>
                            <line x1="6" y1="1" x2="6" y2="4"></line>
                            <line x1="10" y1="1" x2="10" y2="4"></line>
                            <line x1="14" y1="1" x2="14" y2="4"></line>
                        </svg>
                    </div>
                    <h3 class="feature-title">Notifikasi Push</h3>
                    <p class="feature-description">
                        Dapatkan update pesanan secara real-time lewat notifikasi. Tidak ada pesanan yang terlewat.
                    </p>
                </div>
            </div>
        </div>
    </section>

    <!-- How It Works Section -->
    <section id="how-it-works" class="how-it-works">
        <div class="container">
            <div class="section-header">
                <div class="section-tag">Cara Kerja</div>
                <h2 class="section-title">Mudah dalam 3 Langkah</h2>
                <p class="section-description">Mulai dari buka aplikasi hingga pesanan tiba, prosesnya simpel dan cepat.</p>
            </div>
            <div class="steps">
                <div class="step">
                    <div class="step-number">1</div>
                    <div class="step-content">
                        <h3 class="step-title">Pilih & Pesan</h3>
                        <p class="step-description">
                            Buka aplikasi, telusuri menu atau layanan yang Anda inginkan, lalu tambahkan ke keranjang.
                        </p>
                    </div>
                </div>
                <div class="step-arrow">→</div>
                <div class="step">
                    <div class="step-number">2</div>
                    <div class="step-content">
                        <h3 class="step-title">Bayar</h3>
                        <p class="step-description">
                            Selesaikan pembayaran menggunakan saldo dompet SIRI dengan aman dan instan.
                        </p>
                    </div>
                </div>
                <div class="step-arrow">→</div>
                <div class="step">
                    <div class="step-number">3</div>
                    <div class="step-content">
                        <h3 class="step-title">Terima</h3>
                        <p class="step-description">
                            Lacak pesanan secara real-time dan terima di lokasi yang Anda tentukan.
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
                    <h2 class="download-title">Siap Memulai?<br>Download Sekarang.</h2>
                    <p class="download-description">
                        Unduh aplikasi SIRI dan nikmati kemudahan pesan makanan serta layanan jasa
                        langsung dari smartphone Anda. Gratis, aman, dan selalu diperbarui.
                    </p>
                    <div class="download-buttons">
                        <a href="/downloads/siri-app.apk" class="btn btn-download" download>
                            <svg width="28" height="28" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                <rect x="5" y="2" width="14" height="20" rx="2" ry="2"></rect>
                                <line x1="12" y1="18" x2="12" y2="18"></line>
                            </svg>
                            <div class="btn-content">
                                <span class="btn-label">Download APK</span>
                                <span class="btn-sublabel">Android · Gratis</span>
                            </div>
                        </a>
                    </div>
                    <div class="download-info">
                        <div class="info-item">
                            <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5">
                                <path d="M22 11.08V12a10 10 0 1 1-5.93-9.14"></path>
                                <polyline points="22 4 12 14.01 9 11.01"></polyline>
                            </svg>
                            <span>Gratis tanpa biaya tersembunyi</span>
                        </div>
                        <div class="info-item">
                            <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5">
                                <path d="M22 11.08V12a10 10 0 1 1-5.93-9.14"></path>
                                <polyline points="22 4 12 14.01 9 11.01"></polyline>
                            </svg>
                            <span>Transaksi terenkripsi & aman</span>
                        </div>
                        <div class="info-item">
                            <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5">
                                <path d="M22 11.08V12a10 10 0 1 1-5.93-9.14"></path>
                                <polyline points="22 4 12 14.01 9 11.01"></polyline>
                            </svg>
                            <span>Update rutin & dukungan aktif</span>
                        </div>
                    </div>
                </div>
                <div class="download-image">
                    <div class="download-phone">
                        <div class="phone-glow"></div>
                        <div class="download-icon">
                            <svg width="110" height="110" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5">
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
                        <svg width="30" height="30" viewBox="0 0 40 40" fill="none" xmlns="http://www.w3.org/2000/svg">
                            <circle cx="20" cy="20" r="20" fill="url(#footerGrad)"/>
                            <path d="M20 10L26 16L20 22L14 16L20 10Z" fill="white"/>
                            <path d="M20 18L26 24L20 30L14 24L20 18Z" fill="white" opacity="0.7"/>
                            <defs>
                                <linearGradient id="footerGrad" x1="0" y1="0" x2="40" y2="40">
                                    <stop offset="0%" stop-color="#059669"/>
                                    <stop offset="100%" stop-color="#16a34a"/>
                                </linearGradient>
                            </defs>
                        </svg>
                        <span class="footer-logo-text">SIRI</span>
                    </div>
                    <p class="footer-description">
                        Aplikasi food delivery dan layanan jasa terpercaya untuk memudahkan aktivitas sehari-hari Anda.
                    </p>
                </div>
                <div class="footer-section">
                    <h4 class="footer-title">Perusahaan</h4>
                    <ul class="footer-links">
                        <li><a href="#about">Tentang Kami</a></li>
                        <li><a href="#careers">Karir</a></li>
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
                    <h4 class="footer-title">Kontak</h4>
                    <ul class="footer-links">
                        <li><a href="mailto:info@siri.app">info@siri.app</a></li>
                        <li><a href="tel:+6281234567890">+62 812-3456-7890</a></li>
                    </ul>
                    <div class="social-links">
                        <a href="#" class="social-link" aria-label="Facebook">
                            <svg width="18" height="18" viewBox="0 0 24 24" fill="currentColor">
                                <path d="M24 12.073c0-6.627-5.373-12-12-12s-12 5.373-12 12c0 5.99 4.388 10.954 10.125 11.854v-8.385H7.078v-3.47h3.047V9.43c0-3.007 1.792-4.669 4.533-4.669 1.312 0 2.686.235 2.686.235v2.953H15.83c-1.491 0-1.956.925-1.956 1.874v2.25h3.328l-.532 3.47h-2.796v8.385C19.612 23.027 24 18.062 24 12.073z"/>
                            </svg>
                        </a>
                        <a href="#" class="social-link" aria-label="Instagram">
                            <svg width="18" height="18" viewBox="0 0 24 24" fill="currentColor">
                                <path d="M12 2.163c3.204 0 3.584.012 4.85.07 3.252.148 4.771 1.691 4.919 4.919.058 1.265.069 1.645.069 4.849 0 3.205-.012 3.584-.069 4.849-.149 3.225-1.664 4.771-4.919 4.919-1.266.058-1.644.07-4.85.07-3.204 0-3.584-.012-4.849-.07-3.26-.149-4.771-1.699-4.919-4.92-.058-1.265-.07-1.644-.07-4.849 0-3.204.013-3.583.07-4.849.149-3.227 1.664-4.771 4.919-4.919 1.266-.057 1.645-.069 4.849-.069zm0-2.163c-3.259 0-3.667.014-4.947.072-4.358.2-6.78 2.618-6.98 6.98-.059 1.281-.073 1.689-.073 4.948 0 3.259.014 3.668.072 4.948.2 4.358 2.618 6.78 6.98 6.98 1.281.058 1.689.072 4.948.072 3.259 0 3.668-.014 4.948-.072 4.354-.2 6.782-2.618 6.979-6.98.059-1.28.073-1.689.073-4.948 0-3.259-.014-3.667-.072-4.947-.196-4.354-2.617-6.78-6.979-6.98-1.281-.059-1.69-.073-4.949-.073zm0 5.838c-3.403 0-6.162 2.759-6.162 6.162s2.759 6.163 6.162 6.163 6.162-2.759 6.162-6.163c0-3.403-2.759-6.162-6.162-6.162zm0 10.162c-2.209 0-4-1.79-4-4 0-2.209 1.791-4 4-4s4 1.791 4 4c0 2.21-1.791 4-4 4zm6.406-11.845c-.796 0-1.441.645-1.441 1.44s.645 1.44 1.441 1.44c.795 0 1.439-.645 1.439-1.44s-.644-1.44-1.439-1.44z"/>
                            </svg>
                        </a>
                        <a href="#" class="social-link" aria-label="Twitter / X">
                            <svg width="18" height="18" viewBox="0 0 24 24" fill="currentColor">
                                <path d="M18.244 2.25h3.308l-7.227 8.26 8.502 11.24H16.17l-5.214-6.817L4.99 21.75H1.68l7.73-8.835L1.254 2.25H8.08l4.713 6.231zm-1.161 17.52h1.833L7.084 4.126H5.117z"/>
                            </svg>
                        </a>
                    </div>
                </div>
            </div>
            <div class="footer-bottom">
                <p>&copy; {{ date('Y') }} SIRI. All rights reserved.</p>
            </div>
        </div>
    </footer>

    <script src="{{ asset('js/script.js') }}"></script>
</body>
</html>
