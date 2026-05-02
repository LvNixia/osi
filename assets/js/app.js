/**
 * OSI Explorer — Main Application Logic
 * Handles navigation, layer details, quiz, and general UI
 */

document.addEventListener('DOMContentLoaded', () => {
    initNavigation();
    initScrollReveal();
    initCounters();
    initLayerStack();
    initQuiz();
});

/* =============================================
   NAVIGATION
   ============================================= */
function initNavigation() {
    const navbar = document.getElementById('navbar');
    const navToggle = document.getElementById('navToggle');
    const navLinks = document.getElementById('navLinks');
    const links = document.querySelectorAll('.nav-link');

    // Scroll effects
    window.addEventListener('scroll', () => {
        if (window.scrollY > 50) {
            navbar.classList.add('scrolled');
        } else {
            navbar.classList.remove('scrolled');
        }

        // Active link highlighting
        const sections = ['hero', 'overview', 'layers', 'simulation', 'quiz'];
        let current = '';
        sections.forEach(id => {
            const section = document.getElementById(id);
            if (section) {
                const rect = section.getBoundingClientRect();
                if (rect.top <= 120) current = id;
            }
        });
        links.forEach(link => {
            link.classList.remove('active');
            if (link.getAttribute('href') === '#' + current) {
                link.classList.add('active');
            }
        });
    });

    // Mobile toggle
    if (navToggle) {
        navToggle.addEventListener('click', () => {
            navLinks.classList.toggle('open');
        });
    }

    // Close mobile menu on link click
    links.forEach(link => {
        link.addEventListener('click', () => {
            navLinks.classList.remove('open');
        });
    });
}

/* =============================================
   SCROLL REVEAL
   ============================================= */
function initScrollReveal() {
    const observerOptions = {
        threshold: 0.1,
        rootMargin: '0px 0px -50px 0px'
    };

    const observer = new IntersectionObserver((entries) => {
        entries.forEach(entry => {
            if (entry.isIntersecting) {
                entry.target.classList.add('visible');
            }
        });
    }, observerOptions);

    document.querySelectorAll('.overview-card, .section-header, .sim-controls, .sim-area, .sim-log, .encap-viewer, .quiz-container').forEach(el => {
        el.classList.add('reveal');
        observer.observe(el);
    });
}

/* =============================================
   ANIMATED COUNTERS
   ============================================= */
function initCounters() {
    const counters = document.querySelectorAll('.stat-number');
    const observer = new IntersectionObserver((entries) => {
        entries.forEach(entry => {
            if (entry.isIntersecting) {
                const el = entry.target;
                const target = parseInt(el.dataset.count);
                animateCounter(el, target);
                observer.unobserve(el);
            }
        });
    }, { threshold: 0.5 });

    counters.forEach(c => observer.observe(c));
}

function animateCounter(el, target) {
    const duration = 1500;
    const start = performance.now();

    function update(now) {
        const elapsed = now - start;
        const progress = Math.min(elapsed / duration, 1);
        const eased = 1 - Math.pow(1 - progress, 3);
        el.textContent = Math.round(eased * target);
        if (progress < 1) requestAnimationFrame(update);
    }

    requestAnimationFrame(update);
}

/* =============================================
   LAYER STACK — 7 Layers Detail
   ============================================= */

const OSI_LAYERS_DATA = [
    {
        number: 7,
        name: "Application",
        color: "#a855f7",
        pdu: "Data",
        description: "Layer Application adalah lapisan tertinggi dalam model OSI yang berinteraksi langsung dengan pengguna. Layer ini menyediakan antarmuka untuk aplikasi agar dapat mengakses layanan jaringan.",
        functions: [
            "Menyediakan antarmuka antara aplikasi dan jaringan",
            "Mengidentifikasi mitra komunikasi",
            "Menentukan ketersediaan sumber daya",
            "Menyinkronkan komunikasi"
        ],
        protocols: ["HTTP", "HTTPS", "FTP", "SMTP", "POP3", "IMAP", "DNS", "DHCP", "SNMP", "Telnet", "SSH"],
        example: "Saat Anda membuka browser dan mengetik google.com, layer Application menggunakan protokol HTTP/HTTPS untuk memulai permintaan ke server web.",
        devices: ["Web Browser", "Email Client", "FTP Client"]
    },
    {
        number: 6,
        name: "Presentation",
        color: "#6366f1",
        pdu: "Data",
        description: "Layer Presentation bertanggung jawab untuk menerjemahkan, mengenkripsi, dan mengkompresi data. Layer ini memastikan data dari layer Application di satu sistem dapat dibaca oleh layer Application di sistem lain.",
        functions: [
            "Translasi/konversi format data (ASCII, EBCDIC, JPEG, dsb.)",
            "Enkripsi dan dekripsi data untuk keamanan",
            "Kompresi data untuk mengurangi bandwidth",
            "Serialisasi data"
        ],
        protocols: ["SSL/TLS", "JPEG", "GIF", "PNG", "MPEG", "ASCII", "EBCDIC", "MIME"],
        example: "Saat Anda mengirim file gambar, layer ini mengonversi format gambar (JPEG/PNG) dan bisa mengenkripsi data menggunakan SSL/TLS sebelum dikirim.",
        devices: ["Gateway", "Redirector"]
    },
    {
        number: 5,
        name: "Session",
        color: "#3b82f6",
        pdu: "Data",
        description: "Layer Session bertanggung jawab untuk membangun, mengelola, dan mengakhiri sesi komunikasi antar dua perangkat. Layer ini mengontrol dialog antara komputer-komputer yang berkomunikasi.",
        functions: [
            "Membuat, memelihara, dan mengakhiri sesi",
            "Sinkronisasi dialog (half-duplex/full-duplex)",
            "Mengelola token dan checkpoint",
            "Recovery & restart sesi jika terjadi gangguan"
        ],
        protocols: ["NetBIOS", "RPC", "PPTP", "SAP", "SDP", "NFS"],
        example: "Saat Anda melakukan video call, layer Session menjaga koneksi tetap aktif selama percakapan, dan memulihkannya jika terjadi gangguan singkat.",
        devices: ["Gateway"]
    },
    {
        number: 4,
        name: "Transport",
        color: "#06b6d4",
        pdu: "Segment / Datagram",
        description: "Layer Transport menyediakan transfer data yang andal (atau tidak andal, tergantung protokol) antara dua host. Layer ini bertanggung jawab untuk segmentasi, flow control, dan error recovery.",
        functions: [
            "Segmentasi dan reassembly data",
            "Flow control (mencegah overload pada penerima)",
            "Error detection & recovery",
            "Multiplexing menggunakan port number",
            "Connection-oriented (TCP) atau connectionless (UDP)"
        ],
        protocols: ["TCP", "UDP", "SPX", "SCTP"],
        example: "TCP memastikan semua paket data sampai secara berurutan dan lengkap (misal saat download file), sedangkan UDP mengirim tanpa verifikasi (misal streaming video).",
        devices: ["Firewall", "Load Balancer"]
    },
    {
        number: 3,
        name: "Network",
        color: "#10b981",
        pdu: "Packet",
        description: "Layer Network bertanggung jawab untuk pengalamatan logis (IP addressing) dan routing — menentukan jalur terbaik untuk mengirim data dari sumber ke tujuan melalui jaringan yang berbeda-beda.",
        functions: [
            "Pengalamatan logis (IP addressing)",
            "Routing (pencarian jalur terbaik)",
            "Fragmentasi dan reassembly paket",
            "Traffic control & congestion avoidance"
        ],
        protocols: ["IP (IPv4/IPv6)", "ICMP", "ARP", "OSPF", "BGP", "RIP", "EIGRP"],
        example: "Saat Anda mengirim email, layer Network menentukan rute tercepat melalui berbagai router di internet agar paket data sampai ke server email tujuan.",
        devices: ["Router", "Layer 3 Switch"]
    },
    {
        number: 2,
        name: "Data Link",
        color: "#f59e0b",
        pdu: "Frame",
        description: "Layer Data Link bertanggung jawab untuk transfer data yang bebas error antar node yang terhubung langsung. Layer ini mengatur akses ke media fisik dan mendeteksi/mengoreksi error yang terjadi di Physical layer.",
        functions: [
            "Framing — membungkus paket menjadi frame",
            "Pengalamatan fisik (MAC address)",
            "Flow control di level link",
            "Error detection (CRC, checksum)",
            "Akses media (CSMA/CD, CSMA/CA)"
        ],
        protocols: ["Ethernet", "Wi-Fi (802.11)", "PPP", "HDLC", "Frame Relay", "ARP"],
        example: "Switch menggunakan MAC address di layer ini untuk mengirim frame data ke port yang benar, memastikan data sampai ke komputer yang tepat dalam jaringan lokal.",
        devices: ["Switch", "Bridge", "NIC (Network Interface Card)"]
    },
    {
        number: 1,
        name: "Physical",
        color: "#ef4444",
        pdu: "Bit",
        description: "Layer Physical adalah lapisan paling bawah yang berhubungan dengan transmisi sinyal mentah (bit) melalui media transmisi fisik. Layer ini mendefinisikan spesifikasi hardware, kabel, tegangan, dan frekuensi radio.",
        functions: [
            "Konversi data menjadi sinyal (listrik, cahaya, gelombang radio)",
            "Mendefinisikan konektor dan kabel (RJ-45, fiber optic, dsb.)",
            "Bit rate dan sinkronisasi bit",
            "Topologi jaringan fisik",
            "Mode transmisi (simplex, half-duplex, full-duplex)"
        ],
        protocols: ["Ethernet (physical)", "USB", "Bluetooth", "DSL", "ISDN", "RS-232"],
        example: "Kabel Ethernet (UTP Cat 5/6) dan konektor RJ-45 adalah contoh komponen Physical layer. Sinyal listrik dikirim melalui kabel ini sebagai representasi bit 0 dan 1.",
        devices: ["Hub", "Repeater", "Modem", "Kabel (UTP, Fiber Optic)", "Wireless Access Point"]
    }
];

function initLayerStack() {
    const stack = document.getElementById('layerStack');
    if (!stack) return;

    OSI_LAYERS_DATA.forEach(layer => {
        const card = document.createElement('div');
        card.className = 'layer-card';
        card.style.setProperty('--lc-color', layer.color);
        card.dataset.layer = layer.number;
        card.innerHTML = `
            <span class="lc-number">${layer.number}</span>
            <div class="lc-info">
                <div class="lc-name">${layer.name}</div>
                <div class="lc-pdu">PDU: ${layer.pdu}</div>
            </div>
            <span class="lc-arrow">→</span>
        `;
        card.addEventListener('click', () => showLayerDetail(layer));
        stack.appendChild(card);
    });

    // Also try loading from PHP API
    fetchLayerFromPHP();
}

function showLayerDetail(layer) {
    const panel = document.getElementById('layerDetailPanel');
    if (!panel) return;

    // Update active card
    document.querySelectorAll('.layer-card').forEach(c => c.classList.remove('active'));
    document.querySelector(`.layer-card[data-layer="${layer.number}"]`)?.classList.add('active');

    const protocolTags = layer.protocols.map(p => `<span class="protocol-tag">${p}</span>`).join('');
    const functionsList = layer.functions.map(f => `<li>${f}</li>`).join('');
    const devicesList = layer.devices.map(d => `<li>${d}</li>`).join('');

    panel.innerHTML = `
        <div class="detail-header">
            <span class="detail-num" style="color: ${layer.color}">${layer.number}</span>
            <div class="detail-title">
                <h3>Layer ${layer.number}: ${layer.name}</h3>
                <span class="pdu-badge">PDU: ${layer.pdu}</span>
            </div>
        </div>
        <div class="detail-body">
            <p>${layer.description}</p>
            
            <h4>📌 Fungsi Utama</h4>
            <ul>${functionsList}</ul>
            
            <h4>🔧 Protokol yang Digunakan</h4>
            <div class="protocol-tags">${protocolTags}</div>
            
            <h4>💡 Contoh Penggunaan</h4>
            <p>${layer.example}</p>
            
            <h4>🖥️ Perangkat Terkait</h4>
            <ul>${devicesList}</ul>
        </div>
    `;

    panel.style.animation = 'none';
    panel.offsetHeight; // Trigger reflow
    panel.style.animation = 'fadeInUp 0.4s ease both';
}

async function fetchLayerFromPHP() {
    try {
        const response = await fetch('api/layers.php');
        if (response.ok) {
            const data = await response.json();
            console.log('OSI Layer data loaded from PHP API:', data.status);
        }
    } catch (e) {
        console.log('PHP API not available, using local data.');
    }
}

/* =============================================
   QUIZ SYSTEM
   ============================================= */
const QUIZ_DATA = [
    {
        question: "Layer OSI manakah yang bertanggung jawab untuk routing dan pengalamatan IP?",
        options: ["Transport", "Network", "Data Link", "Session"],
        correct: 1,
        explanation: "Layer Network (Layer 3) bertanggung jawab untuk pengalamatan logis (IP addressing) dan routing — menentukan jalur terbaik untuk mengirim paket data."
    },
    {
        question: "Apa PDU (Protocol Data Unit) pada layer Transport?",
        options: ["Bit", "Frame", "Packet", "Segment"],
        correct: 3,
        explanation: "PDU pada layer Transport adalah Segment (untuk TCP) atau Datagram (untuk UDP). Segment berisi data yang sudah dipecah beserta informasi port."
    },
    {
        question: "Protokol mana yang bekerja di Layer Application?",
        options: ["TCP", "IP", "HTTP", "Ethernet"],
        correct: 2,
        explanation: "HTTP (Hypertext Transfer Protocol) adalah protokol layer Application yang digunakan untuk komunikasi web. TCP bekerja di Transport, IP di Network, dan Ethernet di Data Link/Physical."
    },
    {
        question: "Layer mana yang menggunakan MAC Address?",
        options: ["Network", "Data Link", "Physical", "Transport"],
        correct: 1,
        explanation: "Layer Data Link (Layer 2) menggunakan MAC Address (Media Access Control) untuk pengalamatan fisik dalam jaringan lokal (LAN)."
    },
    {
        question: "Proses penambahan header di setiap layer saat data dikirim disebut?",
        options: ["Dekapsulasi", "Routing", "Enkapsulasi", "Fragmentasi"],
        correct: 2,
        explanation: "Enkapsulasi adalah proses penambahan header (dan kadang trailer) di setiap layer saat data bergerak dari layer Application ke Physical. Proses sebaliknya disebut dekapsulasi."
    },
    {
        question: "Perangkat jaringan apa yang bekerja di Layer 3 (Network)?",
        options: ["Hub", "Switch", "Router", "Repeater"],
        correct: 2,
        explanation: "Router bekerja di Layer 3 (Network) karena menggunakan IP address untuk menentukan jalur pengiriman paket antar jaringan yang berbeda."
    },
    {
        question: "Layer Presentation bertanggung jawab untuk?",
        options: ["Routing paket", "Enkripsi dan format data", "Pengiriman fisik sinyal", "Manajemen sesi"],
        correct: 1,
        explanation: "Layer Presentation (Layer 6) bertanggung jawab untuk translasi format data, enkripsi/dekripsi, dan kompresi/dekompresi data."
    },
    {
        question: "TCP dan UDP merupakan protokol pada layer?",
        options: ["Application", "Session", "Transport", "Network"],
        correct: 2,
        explanation: "TCP (Transmission Control Protocol) dan UDP (User Datagram Protocol) bekerja di Layer Transport (Layer 4). TCP bersifat connection-oriented, UDP bersifat connectionless."
    },
    {
        question: "Apa yang dimaksud dengan PDU pada Layer 1 (Physical)?",
        options: ["Frame", "Packet", "Segment", "Bit"],
        correct: 3,
        explanation: "PDU pada Layer Physical adalah Bit. Di layer ini, data dikonversi menjadi sinyal listrik, optik, atau gelombang radio untuk dikirim melalui media fisik."
    },
    {
        question: "Siapa yang mengembangkan model OSI?",
        options: ["IEEE", "ISO", "IETF", "W3C"],
        correct: 1,
        explanation: "Model OSI dikembangkan oleh ISO (International Organization for Standardization) dan dipublikasikan pada tahun 1984 sebagai standar referensi untuk arsitektur jaringan."
    }
];

let quizState = {
    currentQuestion: 0,
    score: 0,
    answered: false,
    started: false
};

function initQuiz() {
    const btnStart = document.getElementById('btnStartQuiz');
    if (!btnStart) return;

    const quizContent = document.getElementById('quizContent');
    quizContent.innerHTML = `
        <div class="quiz-welcome">
            <h3>🧠 Uji Pengetahuan Anda</h3>
            <p>10 pertanyaan tentang model OSI Layer. Jawab dengan benar untuk menguji pemahaman Anda!</p>
        </div>
    `;

    btnStart.addEventListener('click', startQuiz);
}

function startQuiz() {
    quizState = { currentQuestion: 0, score: 0, answered: false, started: true };
    
    // Try to load quiz from PHP, fallback to local
    fetchQuizFromPHP().then(data => {
        if (data && data.questions) {
            // Use PHP quiz data if available
            showQuestion();
        } else {
            showQuestion();
        }
    });
}

async function fetchQuizFromPHP() {
    try {
        const response = await fetch('api/quiz.php');
        if (response.ok) {
            return await response.json();
        }
    } catch (e) {
        console.log('Quiz PHP API not available, using local data.');
    }
    return null;
}

function showQuestion() {
    const quizContent = document.getElementById('quizContent');
    const quizActions = document.getElementById('quizActions');
    const progressBar = document.getElementById('quizProgressBar');
    const q = QUIZ_DATA[quizState.currentQuestion];

    quizState.answered = false;
    progressBar.style.width = `${((quizState.currentQuestion) / QUIZ_DATA.length) * 100}%`;

    const letters = ['A', 'B', 'C', 'D'];
    const optionsHTML = q.options.map((opt, i) => `
        <button class="quiz-option" data-index="${i}" onclick="selectAnswer(${i})">
            <span class="opt-letter">${letters[i]}</span>
            <span>${opt}</span>
        </button>
    `).join('');

    quizContent.innerHTML = `
        <div class="quiz-question">
            <div class="quiz-question-num">Pertanyaan ${quizState.currentQuestion + 1} dari ${QUIZ_DATA.length}</div>
            <h3>${q.question}</h3>
            <div class="quiz-options">${optionsHTML}</div>
        </div>
    `;

    quizActions.innerHTML = '';
}

function selectAnswer(index) {
    if (quizState.answered) return;
    quizState.answered = true;

    const q = QUIZ_DATA[quizState.currentQuestion];
    const options = document.querySelectorAll('.quiz-option');

    options.forEach((opt, i) => {
        opt.style.pointerEvents = 'none';
        if (i === q.correct) {
            opt.classList.add('correct');
        }
        if (i === index && i !== q.correct) {
            opt.classList.add('wrong');
        }
        if (i === index) {
            opt.classList.add('selected');
        }
    });

    if (index === q.correct) {
        quizState.score++;
    }

    // Show explanation
    const quizContent = document.getElementById('quizContent');
    const explanation = document.createElement('div');
    explanation.className = 'quiz-explanation';
    explanation.innerHTML = `<strong>${index === q.correct ? '✅ Benar!' : '❌ Salah.'}</strong> ${q.explanation}`;
    quizContent.querySelector('.quiz-question').appendChild(explanation);

    // Show next button
    const quizActions = document.getElementById('quizActions');
    if (quizState.currentQuestion < QUIZ_DATA.length - 1) {
        quizActions.innerHTML = `<button class="btn btn-primary" onclick="nextQuestion()">Pertanyaan Selanjutnya →</button>`;
    } else {
        quizActions.innerHTML = `<button class="btn btn-primary" onclick="showResult()">Lihat Hasil</button>`;
    }

    // Submit to PHP
    submitAnswerToPHP(quizState.currentQuestion, index, index === q.correct);
}

function nextQuestion() {
    quizState.currentQuestion++;
    showQuestion();
}

function showResult() {
    const quizContent = document.getElementById('quizContent');
    const quizActions = document.getElementById('quizActions');
    const progressBar = document.getElementById('quizProgressBar');
    const percentage = Math.round((quizState.score / QUIZ_DATA.length) * 100);

    progressBar.style.width = '100%';

    let message = '';
    if (percentage === 100) message = '🏆 Sempurna! Anda menguasai model OSI!';
    else if (percentage >= 80) message = '🌟 Excellent! Pemahaman yang sangat baik!';
    else if (percentage >= 60) message = '👍 Bagus! Terus belajar!';
    else if (percentage >= 40) message = '📚 Cukup, perlu belajar lebih dalam lagi.';
    else message = '💪 Jangan menyerah, coba lagi!';

    quizContent.innerHTML = `
        <div class="quiz-result">
            <div class="result-score">${percentage}%</div>
            <h3>${message}</h3>
            <p>Anda menjawab benar ${quizState.score} dari ${QUIZ_DATA.length} pertanyaan.</p>
        </div>
    `;

    quizActions.innerHTML = `<button class="btn btn-primary" onclick="startQuiz()">🔄 Coba Lagi</button>`;
}

async function submitAnswerToPHP(questionIndex, answerIndex, isCorrect) {
    try {
        await fetch('api/quiz.php', {
            method: 'POST',
            headers: { 'Content-Type': 'application/json' },
            body: JSON.stringify({
                question: questionIndex,
                answer: answerIndex,
                correct: isCorrect,
                score: quizState.score,
                total: QUIZ_DATA.length
            })
        });
    } catch (e) {
        // Silently fail if PHP not available
    }
}
