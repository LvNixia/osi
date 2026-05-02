<?php
/**
 * OSI Layer API — Quiz Endpoint
 * Returns quiz questions and processes answers
 */

header('Content-Type: application/json; charset=utf-8');
header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Methods: GET, POST, OPTIONS');
header('Access-Control-Allow-Headers: Content-Type');

// Handle preflight
if ($_SERVER['REQUEST_METHOD'] === 'OPTIONS') {
    http_response_code(200);
    exit;
}

$quizQuestions = [
    [
        'id' => 1,
        'question' => 'Layer OSI manakah yang bertanggung jawab untuk routing dan pengalamatan IP?',
        'options' => ['Transport', 'Network', 'Data Link', 'Session'],
        'correct' => 1,
        'explanation' => 'Layer Network (Layer 3) bertanggung jawab untuk pengalamatan logis (IP addressing) dan routing — menentukan jalur terbaik untuk mengirim paket data.',
        'difficulty' => 'easy'
    ],
    [
        'id' => 2,
        'question' => 'Apa PDU (Protocol Data Unit) pada layer Transport?',
        'options' => ['Bit', 'Frame', 'Packet', 'Segment'],
        'correct' => 3,
        'explanation' => 'PDU pada layer Transport adalah Segment (untuk TCP) atau Datagram (untuk UDP).',
        'difficulty' => 'easy'
    ],
    [
        'id' => 3,
        'question' => 'Protokol mana yang bekerja di Layer Application?',
        'options' => ['TCP', 'IP', 'HTTP', 'Ethernet'],
        'correct' => 2,
        'explanation' => 'HTTP (Hypertext Transfer Protocol) adalah protokol layer Application yang digunakan untuk komunikasi web.',
        'difficulty' => 'easy'
    ],
    [
        'id' => 4,
        'question' => 'Layer mana yang menggunakan MAC Address?',
        'options' => ['Network', 'Data Link', 'Physical', 'Transport'],
        'correct' => 1,
        'explanation' => 'Layer Data Link (Layer 2) menggunakan MAC Address untuk pengalamatan fisik dalam jaringan lokal.',
        'difficulty' => 'medium'
    ],
    [
        'id' => 5,
        'question' => 'Proses penambahan header di setiap layer saat data dikirim disebut?',
        'options' => ['Dekapsulasi', 'Routing', 'Enkapsulasi', 'Fragmentasi'],
        'correct' => 2,
        'explanation' => 'Enkapsulasi adalah proses penambahan header (dan kadang trailer) di setiap layer saat data bergerak dari Application ke Physical.',
        'difficulty' => 'medium'
    ],
    [
        'id' => 6,
        'question' => 'Perangkat jaringan apa yang bekerja di Layer 3 (Network)?',
        'options' => ['Hub', 'Switch', 'Router', 'Repeater'],
        'correct' => 2,
        'explanation' => 'Router bekerja di Layer 3 karena menggunakan IP address untuk menentukan jalur pengiriman paket.',
        'difficulty' => 'easy'
    ],
    [
        'id' => 7,
        'question' => 'Layer Presentation bertanggung jawab untuk?',
        'options' => ['Routing paket', 'Enkripsi dan format data', 'Pengiriman fisik sinyal', 'Manajemen sesi'],
        'correct' => 1,
        'explanation' => 'Layer Presentation (Layer 6) bertanggung jawab untuk translasi format data, enkripsi/dekripsi, dan kompresi.',
        'difficulty' => 'medium'
    ],
    [
        'id' => 8,
        'question' => 'TCP dan UDP merupakan protokol pada layer?',
        'options' => ['Application', 'Session', 'Transport', 'Network'],
        'correct' => 2,
        'explanation' => 'TCP dan UDP bekerja di Layer Transport (Layer 4). TCP bersifat connection-oriented, UDP connectionless.',
        'difficulty' => 'easy'
    ],
    [
        'id' => 9,
        'question' => 'Apa yang dimaksud dengan PDU pada Layer 1 (Physical)?',
        'options' => ['Frame', 'Packet', 'Segment', 'Bit'],
        'correct' => 3,
        'explanation' => 'PDU pada Layer Physical adalah Bit — data dikonversi menjadi sinyal listrik, optik, atau gelombang radio.',
        'difficulty' => 'easy'
    ],
    [
        'id' => 10,
        'question' => 'Siapa yang mengembangkan model OSI?',
        'options' => ['IEEE', 'ISO', 'IETF', 'W3C'],
        'correct' => 1,
        'explanation' => 'Model OSI dikembangkan oleh ISO (International Organization for Standardization) pada tahun 1984.',
        'difficulty' => 'medium'
    ]
];

if ($_SERVER['REQUEST_METHOD'] === 'GET') {
    // Return quiz questions (without correct answers for security, optional)
    $showAnswers = isset($_GET['answers']) && $_GET['answers'] === 'true';
    
    $output = array_map(function($q) use ($showAnswers) {
        $item = [
            'id' => $q['id'],
            'question' => $q['question'],
            'options' => $q['options'],
            'difficulty' => $q['difficulty']
        ];
        if ($showAnswers) {
            $item['correct'] = $q['correct'];
            $item['explanation'] = $q['explanation'];
        }
        return $item;
    }, $quizQuestions);
    
    echo json_encode([
        'status' => 'success',
        'total_questions' => count($output),
        'questions' => $output
    ], JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE);

} elseif ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Process quiz answer submission
    $input = json_decode(file_get_contents('php://input'), true);
    
    if (!$input) {
        http_response_code(400);
        echo json_encode(['status' => 'error', 'message' => 'Invalid JSON input']);
        exit;
    }
    
    // Log quiz attempt
    $logEntry = [
        'timestamp' => date('Y-m-d H:i:s'),
        'question_index' => $input['question'] ?? null,
        'answer_index' => $input['answer'] ?? null,
        'is_correct' => $input['correct'] ?? false,
        'current_score' => $input['score'] ?? 0,
        'total_questions' => $input['total'] ?? 10,
        'ip' => $_SERVER['REMOTE_ADDR'] ?? 'unknown'
    ];
    
    $logFile = __DIR__ . '/../logs/quiz.log';
    $logDir = dirname($logFile);
    if (!is_dir($logDir)) {
        @mkdir($logDir, 0755, true);
    }
    @file_put_contents($logFile, json_encode($logEntry) . PHP_EOL, FILE_APPEND);
    
    // Validate answer if question index provided
    $response = [
        'status' => 'success',
        'message' => 'Answer recorded'
    ];
    
    if (isset($input['question']) && is_int($input['question'])) {
        $qIndex = $input['question'];
        if ($qIndex >= 0 && $qIndex < count($quizQuestions)) {
            $q = $quizQuestions[$qIndex];
            $isCorrect = (isset($input['answer']) && $input['answer'] === $q['correct']);
            $response['verified'] = true;
            $response['is_correct'] = $isCorrect;
            $response['correct_answer'] = $q['correct'];
            $response['explanation'] = $q['explanation'];
        }
    }
    
    echo json_encode($response, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE);

} else {
    http_response_code(405);
    echo json_encode(['status' => 'error', 'message' => 'Method not allowed']);
}
