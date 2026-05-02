<?php
/**
 * OSI Layer API — Simulation Endpoint
 * Processes simulation data and returns encapsulation details
 */

header('Content-Type: application/json; charset=utf-8');
header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Methods: POST, OPTIONS');
header('Access-Control-Allow-Headers: Content-Type');

// Handle preflight
if ($_SERVER['REQUEST_METHOD'] === 'OPTIONS') {
    http_response_code(200);
    exit;
}

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    http_response_code(405);
    echo json_encode(['status' => 'error', 'message' => 'Method not allowed. Use POST.']);
    exit;
}

// Read JSON input
$input = json_decode(file_get_contents('php://input'), true);

if (!$input || !isset($input['message']) || !isset($input['protocol'])) {
    http_response_code(400);
    echo json_encode(['status' => 'error', 'message' => 'Missing required fields: message, protocol']);
    exit;
}

$message = htmlspecialchars(trim($input['message']), ENT_QUOTES, 'UTF-8');
$protocol = strtoupper(trim($input['protocol']));

// Validate protocol
$validProtocols = ['HTTP', 'FTP', 'SMTP', 'DNS'];
if (!in_array($protocol, $validProtocols)) {
    $protocol = 'HTTP';
}

// Port mapping
$portMap = [
    'HTTP' => 80,
    'FTP'  => 21,
    'SMTP' => 25,
    'DNS'  => 53,
];

// Generate simulation data
$srcIP = '192.168.1.' . rand(2, 254);
$dstIP = '203.0.113.' . rand(2, 254);
$srcPort = rand(1024, 65535);
$dstPort = $portMap[$protocol];
$srcMAC = implode(':', array_map(function() { return sprintf('%02x', rand(0, 255)); }, range(1, 6)));
$dstMAC = implode(':', array_map(function() { return sprintf('%02x', rand(0, 255)); }, range(1, 6)));
$sessionID = 'SID-' . strtoupper(substr(md5(uniqid()), 0, 8));
$ttl = 64;
$dataSize = strlen($message);

// Calculate sizes at each layer
$appDataSize = $dataSize;
$presDataSize = $appDataSize + 8;   // Presentation header
$sessDataSize = $presDataSize + 8;  // Session header
$segmentSize = $sessDataSize + 20;  // TCP header (20 bytes)
$packetSize = $segmentSize + 20;    // IP header (20 bytes)
$frameSize = $packetSize + 18;      // Ethernet header (14) + FCS (4)
$bitCount = $frameSize * 8;

// Build layer-by-layer encapsulation detail
$encapsulation = [
    [
        'layer' => 7,
        'name' => 'Application',
        'action' => 'Membuat data aplikasi',
        'detail' => "Aplikasi membuat request {$protocol} dengan pesan: \"{$message}\"",
        'header_added' => "{$protocol} Header",
        'data_size' => $appDataSize,
        'total_size' => $appDataSize
    ],
    [
        'layer' => 6,
        'name' => 'Presentation',
        'action' => 'Enkripsi & format data',
        'detail' => "Data di-encode (UTF-8) dan dienkripsi dengan SSL/TLS",
        'header_added' => 'Presentation Header (8 bytes)',
        'data_size' => $appDataSize,
        'total_size' => $presDataSize
    ],
    [
        'layer' => 5,
        'name' => 'Session',
        'action' => 'Membuat sesi koneksi',
        'detail' => "Session ID: {$sessionID}",
        'header_added' => 'Session Header (8 bytes)',
        'data_size' => $presDataSize,
        'total_size' => $sessDataSize
    ],
    [
        'layer' => 4,
        'name' => 'Transport',
        'action' => 'Segmentasi & port assignment',
        'detail' => "Port Sumber: {$srcPort}, Port Tujuan: {$dstPort} ({$protocol})",
        'header_added' => 'TCP Header (20 bytes)',
        'data_size' => $sessDataSize,
        'total_size' => $segmentSize,
        'pdu' => 'Segment'
    ],
    [
        'layer' => 3,
        'name' => 'Network',
        'action' => 'Routing & IP addressing',
        'detail' => "IP Src: {$srcIP} → IP Dst: {$dstIP} | TTL: {$ttl}",
        'header_added' => 'IP Header (20 bytes)',
        'data_size' => $segmentSize,
        'total_size' => $packetSize,
        'pdu' => 'Packet'
    ],
    [
        'layer' => 2,
        'name' => 'Data Link',
        'action' => 'Framing & MAC addressing',
        'detail' => "MAC Src: {$srcMAC} → MAC Dst: {$dstMAC} | FCS ditambahkan",
        'header_added' => 'Ethernet Header (14 bytes) + FCS (4 bytes)',
        'data_size' => $packetSize,
        'total_size' => $frameSize,
        'pdu' => 'Frame'
    ],
    [
        'layer' => 1,
        'name' => 'Physical',
        'action' => 'Konversi ke sinyal',
        'detail' => "Data dikonversi menjadi {$bitCount} bit untuk transmisi",
        'header_added' => 'Preamble + SFD',
        'data_size' => $frameSize,
        'total_size' => $frameSize,
        'pdu' => 'Bit',
        'bit_count' => $bitCount
    ]
];

// Log simulation (optional — write to file)
$logEntry = [
    'timestamp' => date('Y-m-d H:i:s'),
    'message' => $message,
    'protocol' => $protocol,
    'src_ip' => $srcIP,
    'dst_ip' => $dstIP,
    'session_id' => $sessionID
];

$logFile = __DIR__ . '/../logs/simulation.log';
$logDir = dirname($logFile);
if (!is_dir($logDir)) {
    @mkdir($logDir, 0755, true);
}
@file_put_contents($logFile, json_encode($logEntry) . PHP_EOL, FILE_APPEND);

// Response
echo json_encode([
    'status' => 'success',
    'message' => 'Simulation data processed successfully',
    'simulation' => [
        'original_message' => $message,
        'protocol' => $protocol,
        'source' => [
            'ip' => $srcIP,
            'mac' => $srcMAC,
            'port' => $srcPort
        ],
        'destination' => [
            'ip' => $dstIP,
            'mac' => $dstMAC,
            'port' => $dstPort
        ],
        'session_id' => $sessionID,
        'ttl' => $ttl,
        'data_size_bytes' => $dataSize,
        'frame_size_bytes' => $frameSize,
        'total_bits' => $bitCount
    ],
    'encapsulation' => $encapsulation
], JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE);
