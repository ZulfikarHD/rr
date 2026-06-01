<?php

declare(strict_types=1);

require __DIR__ . '/../lib/app.php';

date_default_timezone_set('Asia/Jakarta');

header('Content-Type: application/json; charset=utf-8');
header('Cache-Control: no-store, no-cache, must-revalidate, max-age=0');
header('Pragma: no-cache');
header('Expires: 0');

$config = app_config();
$debug  = isset($_GET['debug']);

try {
    $pdo = wishes_db();
} catch (Throwable $e) {
    http_response_code(500);
    echo json_encode([
        'error'  => 'Database tidak dapat diakses.',
        'detail' => $debug ? $e->getMessage() : null,
    ], JSON_UNESCAPED_UNICODE);
    exit;
}

if ($debug) {
    $dataDir = __DIR__ . '/../data';
    echo json_encode([
        'debug'             => true,
        'php_version'       => PHP_VERSION,
        'pdo_sqlite'        => extension_loaded('pdo_sqlite'),
        'data_dir'          => realpath($dataDir) ?: $dataDir,
        'data_dir_writable' => is_writable($dataDir),
        'rows_total'        => (int) $pdo->query('SELECT COUNT(*) FROM wishes')->fetchColumn(),
        'rows_visible'      => (int) $pdo->query('SELECT COUNT(*) FROM wishes WHERE hidden = 0')->fetchColumn(),
    ], JSON_UNESCAPED_UNICODE | JSON_PRETTY_PRINT);
    exit;
}

$method = $_SERVER['REQUEST_METHOD'] ?? 'GET';

if ($method === 'GET') {
    $rows = $pdo
        ->query('SELECT name, message, created_at FROM wishes WHERE hidden = 0 ORDER BY id DESC LIMIT 500')
        ->fetchAll(PDO::FETCH_ASSOC);

    foreach ($rows as &$row) {
        $row['created_at'] = (int) $row['created_at'];
    }
    unset($row);

    echo json_encode(['data' => $rows], JSON_UNESCAPED_UNICODE);
    exit;
}

if ($method === 'POST') {
    $raw   = file_get_contents('php://input');
    $input = json_decode((string) $raw, true);
    if (!is_array($input)) {
        $input = $_POST;
    }

    $name    = trim((string) ($input['name'] ?? ''));
    $message = trim((string) ($input['message'] ?? ''));
    $honey   = trim((string) ($input['website'] ?? ''));
    $ip      = client_ip();

    // 1) Honeypot: real visitors never fill the hidden "website" field.
    //    Pretend success so bots don't learn they were blocked.
    if ($honey !== '') {
        echo json_encode(['data' => [
            'name'       => $name !== '' ? $name : 'Tanpa Nama',
            'message'    => $message,
            'created_at' => time(),
        ]], JSON_UNESCAPED_UNICODE);
        exit;
    }

    if ($name === '') {
        $name = 'Tanpa Nama';
    }
    if (mb_strlen($name) > 80) {
        $name = mb_substr($name, 0, 80);
    }

    if ($message === '') {
        http_response_code(422);
        echo json_encode(['error' => 'Ucapan tidak boleh kosong.'], JSON_UNESCAPED_UNICODE);
        exit;
    }
    if (mb_strlen($message) > 1000) {
        $message = mb_substr($message, 0, 1000);
    }

    // 2) Block links.
    if (!empty($config['block_links']) && (contains_link($message) || contains_link($name))) {
        http_response_code(422);
        echo json_encode(['error' => 'Maaf, ucapan tidak boleh mengandung tautan/link.'], JSON_UNESCAPED_UNICODE);
        exit;
    }

    // 3) Rate limiting per IP.
    $now    = time();
    $window = (int) $config['rate_limit_window'];
    $stmt = $pdo->prepare('SELECT COUNT(*) AS c, MAX(created_at) AS last FROM wishes WHERE ip = :ip AND created_at > :since');
    $stmt->execute([':ip' => $ip, ':since' => $now - $window]);
    $rl = $stmt->fetch(PDO::FETCH_ASSOC) ?: ['c' => 0, 'last' => 0];

    if ((int) $rl['c'] >= (int) $config['rate_limit_max']) {
        http_response_code(429);
        echo json_encode(['error' => 'Terlalu banyak ucapan dari perangkat ini. Coba lagi nanti.'], JSON_UNESCAPED_UNICODE);
        exit;
    }
    if ($rl['last'] && ($now - (int) $rl['last']) < (int) $config['rate_limit_seconds']) {
        http_response_code(429);
        echo json_encode(['error' => 'Mohon tunggu sebentar sebelum mengirim ucapan lagi.'], JSON_UNESCAPED_UNICODE);
        exit;
    }

    // 4) Censor banned words.
    $bannedWords = is_array($config['banned_words']) ? $config['banned_words'] : [];
    $name    = censor_text($name, $bannedWords);
    $message = censor_text($message, $bannedWords);

    try {
        $stmt = $pdo->prepare(
            'INSERT INTO wishes (name, message, created_at, hidden, ip) VALUES (:name, :message, :created_at, 0, :ip)'
        );
        $stmt->execute([
            ':name'       => $name,
            ':message'    => $message,
            ':created_at' => $now,
            ':ip'         => $ip,
        ]);
    } catch (Throwable $e) {
        http_response_code(500);
        echo json_encode([
            'error'  => 'Gagal menyimpan ucapan (folder data tidak bisa ditulis?).',
            'detail' => $debug ? $e->getMessage() : null,
        ], JSON_UNESCAPED_UNICODE);
        exit;
    }

    echo json_encode(['data' => [
        'name'       => $name,
        'message'    => $message,
        'created_at' => $now,
    ]], JSON_UNESCAPED_UNICODE);
    exit;
}

http_response_code(405);
header('Allow: GET, POST');
echo json_encode(['error' => 'Metode tidak diizinkan.'], JSON_UNESCAPED_UNICODE);
