<?php
/**
 * OSI Layer API — Layer Details
 * Returns detailed information about each OSI layer
 */

header('Content-Type: application/json; charset=utf-8');
header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Methods: GET');

$layers = [
    [
        'number' => 7,
        'name' => 'Application',
        'name_id' => 'Lapisan Aplikasi',
        'color' => '#a855f7',
        'pdu' => 'Data',
        'description' => 'Layer Application adalah lapisan tertinggi dalam model OSI yang berinteraksi langsung dengan pengguna. Layer ini menyediakan antarmuka untuk aplikasi agar dapat mengakses layanan jaringan.',
        'functions' => [
            'Menyediakan antarmuka antara aplikasi dan jaringan',
            'Mengidentifikasi mitra komunikasi',
            'Menentukan ketersediaan sumber daya',
            'Menyinkronkan komunikasi'
        ],
        'protocols' => ['HTTP', 'HTTPS', 'FTP', 'SMTP', 'POP3', 'IMAP', 'DNS', 'DHCP', 'SNMP', 'Telnet', 'SSH'],
        'devices' => ['Web Browser', 'Email Client', 'FTP Client'],
        'example' => 'Saat Anda membuka browser dan mengetik google.com, layer Application menggunakan protokol HTTP/HTTPS untuk memulai permintaan ke server web.',
        'analogy' => 'Seperti menulis surat — Anda menentukan isi pesan dan kepada siapa surat tersebut ditujukan.'
    ],
    [
        'number' => 6,
        'name' => 'Presentation',
        'name_id' => 'Lapisan Presentasi',
        'color' => '#6366f1',
        'pdu' => 'Data',
        'description' => 'Layer Presentation bertanggung jawab untuk menerjemahkan, mengenkripsi, dan mengkompresi data. Layer ini memastikan data dari layer Application di satu sistem dapat dibaca oleh layer Application di sistem lain.',
        'functions' => [
            'Translasi/konversi format data (ASCII, EBCDIC, JPEG, dsb.)',
            'Enkripsi dan dekripsi data untuk keamanan',
            'Kompresi data untuk mengurangi bandwidth',
            'Serialisasi data'
        ],
        'protocols' => ['SSL/TLS', 'JPEG', 'GIF', 'PNG', 'MPEG', 'ASCII', 'EBCDIC', 'MIME'],
        'devices' => ['Gateway', 'Redirector'],
        'example' => 'Saat mengirim file gambar, layer ini mengonversi format gambar (JPEG/PNG) dan bisa mengenkripsi data menggunakan SSL/TLS sebelum dikirim.',
        'analogy' => 'Seperti penerjemah — memastikan surat ditulis dalam bahasa yang dipahami penerima, dan mungkin menggunakan kode rahasia.'
    ],
    [
        'number' => 5,
        'name' => 'Session',
        'name_id' => 'Lapisan Sesi',
        'color' => '#3b82f6',
        'pdu' => 'Data',
        'description' => 'Layer Session bertanggung jawab untuk membangun, mengelola, dan mengakhiri sesi komunikasi antar dua perangkat.',
        'functions' => [
            'Membuat, memelihara, dan mengakhiri sesi',
            'Sinkronisasi dialog (half-duplex/full-duplex)',
            'Mengelola token dan checkpoint',
            'Recovery & restart sesi jika terjadi gangguan'
        ],
        'protocols' => ['NetBIOS', 'RPC', 'PPTP', 'SAP', 'SDP', 'NFS'],
        'devices' => ['Gateway'],
        'example' => 'Saat melakukan video call, layer Session menjaga koneksi tetap aktif selama percakapan.',
        'analogy' => 'Seperti membuat janji temu — mengatur kapan percakapan dimulai, berlangsung, dan berakhir.'
    ],
    [
        'number' => 4,
        'name' => 'Transport',
        'name_id' => 'Lapisan Transport',
        'color' => '#06b6d4',
        'pdu' => 'Segment / Datagram',
        'description' => 'Layer Transport menyediakan transfer data yang andal antara dua host. Layer ini bertanggung jawab untuk segmentasi, flow control, dan error recovery.',
        'functions' => [
            'Segmentasi dan reassembly data',
            'Flow control (mencegah overload pada penerima)',
            'Error detection & recovery',
            'Multiplexing menggunakan port number',
            'Connection-oriented (TCP) atau connectionless (UDP)'
        ],
        'protocols' => ['TCP', 'UDP', 'SPX', 'SCTP'],
        'devices' => ['Firewall', 'Load Balancer'],
        'example' => 'TCP memastikan semua paket data sampai secara berurutan dan lengkap, sedangkan UDP mengirim tanpa verifikasi.',
        'analogy' => 'Seperti jasa pengiriman — memecah barang besar menjadi paket-paket kecil, memberi nomor urut, dan memastikan semua sampai.'
    ],
    [
        'number' => 3,
        'name' => 'Network',
        'name_id' => 'Lapisan Jaringan',
        'color' => '#10b981',
        'pdu' => 'Packet',
        'description' => 'Layer Network bertanggung jawab untuk pengalamatan logis (IP addressing) dan routing — menentukan jalur terbaik untuk mengirim data.',
        'functions' => [
            'Pengalamatan logis (IP addressing)',
            'Routing (pencarian jalur terbaik)',
            'Fragmentasi dan reassembly paket',
            'Traffic control & congestion avoidance'
        ],
        'protocols' => ['IP (IPv4/IPv6)', 'ICMP', 'ARP', 'OSPF', 'BGP', 'RIP', 'EIGRP'],
        'devices' => ['Router', 'Layer 3 Switch'],
        'example' => 'Saat mengirim email, layer Network menentukan rute tercepat melalui berbagai router di internet.',
        'analogy' => 'Seperti sistem navigasi GPS — menentukan alamat tujuan dan rute tercepat untuk sampai ke sana.'
    ],
    [
        'number' => 2,
        'name' => 'Data Link',
        'name_id' => 'Lapisan Data Link',
        'color' => '#f59e0b',
        'pdu' => 'Frame',
        'description' => 'Layer Data Link bertanggung jawab untuk transfer data yang bebas error antar node yang terhubung langsung menggunakan MAC address.',
        'functions' => [
            'Framing — membungkus paket menjadi frame',
            'Pengalamatan fisik (MAC address)',
            'Flow control di level link',
            'Error detection (CRC, checksum)',
            'Akses media (CSMA/CD, CSMA/CA)'
        ],
        'protocols' => ['Ethernet', 'Wi-Fi (802.11)', 'PPP', 'HDLC', 'Frame Relay'],
        'devices' => ['Switch', 'Bridge', 'NIC (Network Interface Card)'],
        'example' => 'Switch menggunakan MAC address untuk mengirim frame data ke port yang benar dalam jaringan lokal.',
        'analogy' => 'Seperti tukang pos lokal — tahu persis rumah mana yang harus menerima surat di lingkungan tersebut.'
    ],
    [
        'number' => 1,
        'name' => 'Physical',
        'name_id' => 'Lapisan Fisik',
        'color' => '#ef4444',
        'pdu' => 'Bit',
        'description' => 'Layer Physical adalah lapisan paling bawah yang berhubungan dengan transmisi sinyal mentah (bit) melalui media fisik.',
        'functions' => [
            'Konversi data menjadi sinyal (listrik, cahaya, gelombang radio)',
            'Mendefinisikan konektor dan kabel (RJ-45, fiber optic, dsb.)',
            'Bit rate dan sinkronisasi bit',
            'Topologi jaringan fisik',
            'Mode transmisi (simplex, half-duplex, full-duplex)'
        ],
        'protocols' => ['Ethernet (physical)', 'USB', 'Bluetooth', 'DSL', 'ISDN', 'RS-232'],
        'devices' => ['Hub', 'Repeater', 'Modem', 'Kabel (UTP, Fiber Optic)', 'Wireless Access Point'],
        'example' => 'Kabel Ethernet (UTP Cat 5/6) dan konektor RJ-45 — sinyal listrik dikirim sebagai representasi bit 0 dan 1.',
        'analogy' => 'Seperti jalan raya — infrastruktur fisik tempat kendaraan (data) melintasi dari satu lokasi ke lokasi lain.'
    ]
];

// Handle GET parameter for specific layer
$layerNum = isset($_GET['layer']) ? intval($_GET['layer']) : null;

if ($layerNum !== null && $layerNum >= 1 && $layerNum <= 7) {
    $found = null;
    foreach ($layers as $layer) {
        if ($layer['number'] === $layerNum) {
            $found = $layer;
            break;
        }
    }
    
    if ($found) {
        echo json_encode([
            'status' => 'success',
            'data' => $found
        ], JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE);
    } else {
        http_response_code(404);
        echo json_encode(['status' => 'error', 'message' => 'Layer not found']);
    }
} else {
    echo json_encode([
        'status' => 'success',
        'message' => 'OSI Layer data loaded successfully',
        'total_layers' => count($layers),
        'data' => $layers
    ], JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE);
}
