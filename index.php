<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="Pelajari 7 Layer OSI Model secara interaktif dengan simulasi pengiriman data real-time. Pahami cara kerja jaringan komputer dari Application hingga Physical layer.">
    <title>OSI Layer Explorer — Simulasi Interaktif Model OSI</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800;900&family=JetBrains+Mono:wght@400;500;600&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="assets/css/style.css">
</head>
<body>
    <!-- Particle Background -->
    <canvas id="particleCanvas"></canvas>

    <!-- Navigation -->
    <nav class="navbar" id="navbar">
        <div class="nav-container">
            <a href="#hero" class="nav-logo">
                <span class="logo-icon">⬡</span>
                <span class="logo-text">OSI<span class="logo-accent">Explorer</span></span>
            </a>
            <ul class="nav-links" id="navLinks">
                <li><a href="#hero" class="nav-link active">Home</a></li>
                <li><a href="#overview" class="nav-link">Overview</a></li>
                <li><a href="#layers" class="nav-link">7 Layers</a></li>
                <li><a href="#simulation" class="nav-link">Simulasi</a></li>
                <li><a href="#quiz" class="nav-link">Quiz</a></li>
            </ul>
            <button class="nav-toggle" id="navToggle" aria-label="Toggle navigation">
                <span></span><span></span><span></span>
            </button>
        </div>
    </nav>

    <!-- Hero Section -->
    <section class="hero" id="hero">
        <div class="hero-content">
            <div class="hero-badge">🌐 Interactive Learning Platform</div>
            <h1 class="hero-title">
                Memahami <span class="gradient-text">OSI Model</span>
                <br>Dari Nol Hingga Mahir
            </h1>
            <p class="hero-subtitle">
                Jelajahi 7 layer arsitektur jaringan komputer secara interaktif. 
                Lihat bagaimana data mengalir dari aplikasi Anda hingga ke kabel fisik — 
                dan kembali lagi.
            </p>
            <div class="hero-actions">
                <a href="#overview" class="btn btn-primary" id="btnStart">
                    <span>Mulai Belajar</span>
                    <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M5 12h14M12 5l7 7-7 7"/></svg>
                </a>
                <a href="#simulation" class="btn btn-secondary" id="btnSimulation">
                    <span>Lihat Simulasi</span>
                    <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><polygon points="5 3 19 12 5 21 5 3"/></svg>
                </a>
            </div>
            <div class="hero-stats">
                <div class="stat-item">
                    <span class="stat-number" data-count="7">0</span>
                    <span class="stat-label">Layers</span>
                </div>
                <div class="stat-item">
                    <span class="stat-number" data-count="4">0</span>
                    <span class="stat-label">PDU Types</span>
                </div>
                <div class="stat-item">
                    <span class="stat-number" data-count="1984">0</span>
                    <span class="stat-label">Tahun Dibuat</span>
                </div>
            </div>
        </div>
        <div class="hero-visual">
            <div class="osi-tower-mini" id="osiTowerMini">
                <div class="tower-layer" data-layer="7" style="--layer-color: #a855f7;">
                    <span class="tower-num">7</span><span class="tower-name">Application</span>
                </div>
                <div class="tower-layer" data-layer="6" style="--layer-color: #6366f1;">
                    <span class="tower-num">6</span><span class="tower-name">Presentation</span>
                </div>
                <div class="tower-layer" data-layer="5" style="--layer-color: #3b82f6;">
                    <span class="tower-num">5</span><span class="tower-name">Session</span>
                </div>
                <div class="tower-layer" data-layer="4" style="--layer-color: #06b6d4;">
                    <span class="tower-num">4</span><span class="tower-name">Transport</span>
                </div>
                <div class="tower-layer" data-layer="3" style="--layer-color: #10b981;">
                    <span class="tower-num">3</span><span class="tower-name">Network</span>
                </div>
                <div class="tower-layer" data-layer="2" style="--layer-color: #f59e0b;">
                    <span class="tower-num">2</span><span class="tower-name">Data Link</span>
                </div>
                <div class="tower-layer" data-layer="1" style="--layer-color: #ef4444;">
                    <span class="tower-num">1</span><span class="tower-name">Physical</span>
                </div>
            </div>
        </div>
    </section>

    <!-- Overview Section -->
    <section class="section" id="overview">
        <div class="container">
            <div class="section-header">
                <span class="section-badge">📚 Pengenalan</span>
                <h2 class="section-title">Apa Itu <span class="gradient-text">OSI Model</span>?</h2>
                <p class="section-subtitle">Open Systems Interconnection — standar universal komunikasi jaringan</p>
            </div>
            <div class="overview-grid">
                <div class="overview-card glass-card">
                    <div class="card-icon" style="--icon-color: #a855f7;">📖</div>
                    <h3>Definisi</h3>
                    <p>OSI Model adalah kerangka konseptual yang membagi proses komunikasi jaringan menjadi <strong>7 lapisan (layer)</strong>. Dikembangkan oleh ISO (International Organization for Standardization) pada tahun 1984 sebagai standar universal untuk memahami dan mendesain arsitektur jaringan.</p>
                </div>
                <div class="overview-card glass-card">
                    <div class="card-icon" style="--icon-color: #3b82f6;">🎯</div>
                    <h3>Tujuan</h3>
                    <p>Model ini bertujuan agar <strong>sistem jaringan yang berbeda</strong> dapat saling berkomunikasi dengan menggunakan standar yang sama. Setiap layer memiliki tugas spesifik dan berkomunikasi dengan layer di atas dan di bawahnya.</p>
                </div>
                <div class="overview-card glass-card">
                    <div class="card-icon" style="--icon-color: #10b981;">⚙️</div>
                    <h3>Cara Kerja</h3>
                    <p>Data mengalir <strong>dari atas ke bawah</strong> saat dikirim (enkapsulasi) — setiap layer menambahkan header/trailer. Saat diterima, data mengalir <strong>dari bawah ke atas</strong> (dekapsulasi) — setiap layer membaca dan melepas header/trailer-nya.</p>
                </div>
                <div class="overview-card glass-card">
                    <div class="card-icon" style="--icon-color: #f59e0b;">🔄</div>
                    <h3>Enkapsulasi & Dekapsulasi</h3>
                    <p>Proses <strong>enkapsulasi</strong> menambahkan informasi kontrol di setiap layer. Proses <strong>dekapsulasi</strong> melepas informasi tersebut di sisi penerima. Inilah yang memungkinkan data sampai dengan benar ke tujuan.</p>
                </div>
            </div>
        </div>
    </section>

    <!-- 7 Layers Detail -->
    <section class="section section-dark" id="layers">
        <div class="container">
            <div class="section-header">
                <span class="section-badge">🏗️ Arsitektur</span>
                <h2 class="section-title">7 Layer <span class="gradient-text">OSI Model</span></h2>
                <p class="section-subtitle">Klik setiap layer untuk melihat detail lengkapnya</p>
            </div>
            <div class="layers-container">
                <!-- Layer details loaded dynamically via JS + PHP AJAX -->
                <div class="layer-stack" id="layerStack"></div>
                <div class="layer-detail-panel glass-card" id="layerDetailPanel">
                    <div class="detail-placeholder">
                        <div class="placeholder-icon">👆</div>
                        <p>Klik salah satu layer di sebelah kiri untuk melihat detail lengkapnya</p>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Simulation Section -->
    <section class="section" id="simulation">
        <div class="container">
            <div class="section-header">
                <span class="section-badge">🚀 Simulasi Interaktif</span>
                <h2 class="section-title">Simulasi <span class="gradient-text">Pengiriman Data</span></h2>
                <p class="section-subtitle">Lihat bagaimana data Anda diproses melalui setiap layer OSI</p>
            </div>

            <!-- Simulation Controls -->
            <div class="sim-controls glass-card">
                <div class="sim-input-group">
                    <label for="simMessage">Pesan yang akan dikirim:</label>
                    <input type="text" id="simMessage" placeholder='Ketik pesan, contoh: "Hello World!"' maxlength="100" value="Hello World!">
                </div>
                <div class="sim-input-group">
                    <label for="simProtocol">Protokol:</label>
                    <select id="simProtocol">
                        <option value="HTTP">HTTP (Web)</option>
                        <option value="FTP">FTP (File Transfer)</option>
                        <option value="SMTP">SMTP (Email)</option>
                        <option value="DNS">DNS (Domain Name)</option>
                    </select>
                </div>
                <div class="sim-input-group">
                    <label for="simSpeed">Kecepatan:</label>
                    <select id="simSpeed">
                        <option value="slow">Lambat (Detail)</option>
                        <option value="normal" selected>Normal</option>
                        <option value="fast">Cepat</option>
                    </select>
                </div>
                <div class="sim-buttons">
                    <button class="btn btn-primary" id="btnStartSim">
                        <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><polygon points="5 3 19 12 5 21 5 3"/></svg>
                        <span>Mulai Simulasi</span>
                    </button>
                    <button class="btn btn-outline" id="btnResetSim">
                        <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><polyline points="1 4 1 10 7 10"/><path d="M3.51 15a9 9 0 1 0 2.13-9.36L1 10"/></svg>
                        <span>Reset</span>
                    </button>
                </div>
            </div>

            <!-- Simulation Area -->
            <div class="sim-area" id="simArea">
                <!-- Sender Side -->
                <div class="sim-device sim-sender">
                    <div class="device-header">
                        <div class="device-icon">💻</div>
                        <span>Pengirim (Sender)</span>
                    </div>
                    <div class="sim-layers" id="senderLayers">
                        <div class="sim-layer" data-layer="7" data-side="sender"><span class="sl-num">7</span><span class="sl-name">Application</span><span class="sl-status"></span></div>
                        <div class="sim-layer" data-layer="6" data-side="sender"><span class="sl-num">6</span><span class="sl-name">Presentation</span><span class="sl-status"></span></div>
                        <div class="sim-layer" data-layer="5" data-side="sender"><span class="sl-num">5</span><span class="sl-name">Session</span><span class="sl-status"></span></div>
                        <div class="sim-layer" data-layer="4" data-side="sender"><span class="sl-num">4</span><span class="sl-name">Transport</span><span class="sl-status"></span></div>
                        <div class="sim-layer" data-layer="3" data-side="sender"><span class="sl-num">3</span><span class="sl-name">Network</span><span class="sl-status"></span></div>
                        <div class="sim-layer" data-layer="2" data-side="sender"><span class="sl-num">2</span><span class="sl-name">Data Link</span><span class="sl-status"></span></div>
                        <div class="sim-layer" data-layer="1" data-side="sender"><span class="sl-num">1</span><span class="sl-name">Physical</span><span class="sl-status"></span></div>
                    </div>
                </div>

                <!-- Network Medium -->
                <div class="sim-network" id="simNetwork">
                    <div class="network-cable">
                        <div class="cable-line"></div>
                        <div class="data-packet" id="dataPacket">
                            <span>📦</span>
                        </div>
                        <div class="cable-line"></div>
                    </div>
                    <span class="network-label">Media Transmisi</span>
                </div>

                <!-- Receiver Side -->
                <div class="sim-device sim-receiver">
                    <div class="device-header">
                        <div class="device-icon">🖥️</div>
                        <span>Penerima (Receiver)</span>
                    </div>
                    <div class="sim-layers" id="receiverLayers">
                        <div class="sim-layer" data-layer="7" data-side="receiver"><span class="sl-num">7</span><span class="sl-name">Application</span><span class="sl-status"></span></div>
                        <div class="sim-layer" data-layer="6" data-side="receiver"><span class="sl-num">6</span><span class="sl-name">Presentation</span><span class="sl-status"></span></div>
                        <div class="sim-layer" data-layer="5" data-side="receiver"><span class="sl-num">5</span><span class="sl-name">Session</span><span class="sl-status"></span></div>
                        <div class="sim-layer" data-layer="4" data-side="receiver"><span class="sl-num">4</span><span class="sl-name">Transport</span><span class="sl-status"></span></div>
                        <div class="sim-layer" data-layer="3" data-side="receiver"><span class="sl-num">3</span><span class="sl-name">Network</span><span class="sl-status"></span></div>
                        <div class="sim-layer" data-layer="2" data-side="receiver"><span class="sl-num">2</span><span class="sl-name">Data Link</span><span class="sl-status"></span></div>
                        <div class="sim-layer" data-layer="1" data-side="receiver"><span class="sl-num">1</span><span class="sl-name">Physical</span><span class="sl-status"></span></div>
                    </div>
                </div>
            </div>

            <!-- Simulation Log -->
            <div class="sim-log glass-card" id="simLog">
                <div class="log-header">
                    <span>📋 Log Proses</span>
                    <button class="btn-icon" id="btnClearLog" title="Clear log">
                        <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><polyline points="3 6 5 6 21 6"/><path d="M19 6v14a2 2 0 0 1-2 2H7a2 2 0 0 1-2-2V6m3 0V4a2 2 0 0 1 2-2h4a2 2 0 0 1 2 2v2"/></svg>
                    </button>
                </div>
                <div class="log-body" id="logBody">
                    <div class="log-entry log-info">
                        <span class="log-time">--:--:--</span>
                        <span class="log-msg">Siap untuk memulai simulasi. Klik tombol "Mulai Simulasi" untuk memulai.</span>
                    </div>
                </div>
            </div>

            <!-- Data Encapsulation Viewer -->
            <div class="encap-viewer glass-card" id="encapViewer">
                <h3>📦 Visualisasi Enkapsulasi Data</h3>
                <div class="encap-display" id="encapDisplay">
                    <div class="encap-initial">
                        <p>Mulai simulasi untuk melihat proses enkapsulasi data secara real-time</p>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Quiz Section -->
    <section class="section section-dark" id="quiz">
        <div class="container">
            <div class="section-header">
                <span class="section-badge">🧠 Uji Pengetahuan</span>
                <h2 class="section-title">Quiz <span class="gradient-text">OSI Layer</span></h2>
                <p class="section-subtitle">Tes pemahaman Anda tentang model OSI</p>
            </div>
            <div class="quiz-container glass-card" id="quizContainer">
                <div class="quiz-progress">
                    <div class="quiz-progress-bar" id="quizProgressBar"></div>
                </div>
                <div class="quiz-content" id="quizContent">
                    <!-- Quiz loaded via JS + PHP AJAX -->
                </div>
                <div class="quiz-actions" id="quizActions">
                    <button class="btn btn-primary" id="btnStartQuiz">Mulai Quiz</button>
                </div>
            </div>
        </div>
    </section>

    <!-- Footer -->
    <footer class="footer">
        <div class="container">
            <div class="footer-content">
                <div class="footer-brand">
                    <span class="logo-icon">⬡</span>
                    <span class="logo-text">OSI<span class="logo-accent">Explorer</span></span>
                    <p>Platform edukasi interaktif untuk memahami Model OSI dan jaringan komputer.</p>
                </div>
                <div class="footer-links">
                    <h4>Navigasi</h4>
                    <a href="#hero">Home</a>
                    <a href="#overview">Overview</a>
                    <a href="#layers">7 Layers</a>
                    <a href="#simulation">Simulasi</a>
                    <a href="#quiz">Quiz</a>
                </div>
                <div class="footer-links">
                    <h4>Referensi</h4>
                    <a href="https://www.iso.org" target="_blank">ISO Organization</a>
                    <a href="https://www.ietf.org" target="_blank">IETF Standards</a>
                    <a href="https://en.wikipedia.org/wiki/OSI_model" target="_blank">Wikipedia OSI</a>
                </div>
            </div>
            <div class="footer-bottom">
                <p>&copy; 2026 OSI Explorer. Dibuat untuk tujuan edukasi.</p>
            </div>
        </div>
    </footer>

    <script src="assets/js/particles.js"></script>
    <script src="assets/js/app.js"></script>
    <script src="assets/js/simulation.js"></script>
</body>
</html>
