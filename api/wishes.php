<?php

declare(strict_types=1);

date_default_timezone_set('Asia/Jakarta');

header('Content-Type: application/json; charset=utf-8');
header('Cache-Control: no-store, no-cache, must-revalidate, max-age=0');
header('Pragma: no-cache');
header('Expires: 0');

$dataDir = __DIR__ . '/../data';
$dbFile  = $dataDir . '/wishes.sqlite';

if (!is_dir($dataDir)) {
    @mkdir($dataDir, 0775, true);
}

// Diagnostic: open <site>/api/wishes.php?debug=1 in a browser to see
// whether the data folder is writable and how many wishes are stored.
$debug = isset($_GET['debug']);

try {
    $pdo = new PDO('sqlite:' . $dbFile);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    $pdo->exec('CREATE TABLE IF NOT EXISTS wishes (
        id INTEGER PRIMARY KEY AUTOINCREMENT,
        name TEXT NOT NULL,
        message TEXT NOT NULL,
        created_at INTEGER NOT NULL
    )');
} catch (Throwable $e) {
    http_response_code(500);
    echo json_encode([
        'error' => 'Database tidak dapat diakses.',
        'detail' => $debug ? $e->getMessage() : null,
        'data_dir' => $debug ? $dataDir : null,
        'data_dir_writable' => $debug ? is_writable($dataDir) : null,
    ], JSON_UNESCAPED_UNICODE);
    exit;
}

if ($debug) {
    $count = (int) $pdo->query('SELECT COUNT(*) FROM wishes')->fetchColumn();
    echo json_encode([
        'debug'             => true,
        'php_version'       => PHP_VERSION,
        'pdo_sqlite'        => extension_loaded('pdo_sqlite'),
        'data_dir'          => realpath($dataDir) ?: $dataDir,
        'data_dir_writable' => is_writable($dataDir),
        'db_file'           => $dbFile,
        'db_exists'         => file_exists($dbFile),
        'db_writable'       => file_exists($dbFile) ? is_writable($dbFile) : null,
        'rows_stored'       => $count,
    ], JSON_UNESCAPED_UNICODE | JSON_PRETTY_PRINT);
    exit;
}

$method = $_SERVER['REQUEST_METHOD'] ?? 'GET';

if ($method === 'GET') {
    $rows = $pdo
        ->query('SELECT name, message, created_at FROM wishes ORDER BY id DESC LIMIT 500')
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

    $createdAt = time();

    try {
        $stmt = $pdo->prepare(
            'INSERT INTO wishes (name, message, created_at) VALUES (:name, :message, :created_at)'
        );
        $stmt->execute([
            ':name'       => $name,
            ':message'    => $message,
            ':created_at' => $createdAt,
        ]);
    } catch (Throwable $e) {
        http_response_code(500);
        echo json_encode([
            'error'  => 'Gagal menyimpan ucapan (folder data tidak bisa ditulis?).',
            'detail' => $debug ? $e->getMessage() : null,
        ], JSON_UNESCAPED_UNICODE);
        exit;
    }

    echo json_encode([
        'data' => [
            'name'       => $name,
            'message'    => $message,
            'created_at' => $createdAt,
        ],
    ], JSON_UNESCAPED_UNICODE);
    exit;
}

http_response_code(405);
header('Allow: GET, POST');
echo json_encode(['error' => 'Metode tidak diizinkan.'], JSON_UNESCAPED_UNICODE);
