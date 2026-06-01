<?php

declare(strict_types=1);

/**
 * Shared helpers for the wedding invitation: configuration, the SQLite
 * connection (with schema/migrations), client IP, and spam/censor utilities.
 * Used by both api/wishes.php and admin/index.php.
 */

function app_config(): array
{
    static $cfg = null;
    if ($cfg !== null) {
        return $cfg;
    }

    $base = __DIR__ . '/..';
    $file = is_file($base . '/config.php') ? $base . '/config.php' : $base . '/config.example.php';

    $loaded = require $file;
    $defaults = [
        'admin_password'     => 'ubah-password-ini',
        'block_links'        => true,
        'rate_limit_seconds' => 15,
        'rate_limit_max'     => 6,
        'rate_limit_window'  => 600,
        'banned_words'       => [],
    ];

    $cfg = array_merge($defaults, is_array($loaded) ? $loaded : []);
    return $cfg;
}

function wishes_db(): PDO
{
    static $pdo = null;
    if ($pdo instanceof PDO) {
        return $pdo;
    }

    $dataDir = __DIR__ . '/../data';
    $dbFile  = $dataDir . '/wishes.sqlite';

    if (!is_dir($dataDir)) {
        @mkdir($dataDir, 0775, true);
    }

    $pdo = new PDO('sqlite:' . $dbFile);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    $pdo->exec('CREATE TABLE IF NOT EXISTS wishes (
        id INTEGER PRIMARY KEY AUTOINCREMENT,
        name TEXT NOT NULL,
        message TEXT NOT NULL,
        created_at INTEGER NOT NULL
    )');

    // Migrations for databases created before moderation was added.
    $cols = array_column(
        $pdo->query('PRAGMA table_info(wishes)')->fetchAll(PDO::FETCH_ASSOC),
        'name'
    );
    if (!in_array('hidden', $cols, true)) {
        $pdo->exec('ALTER TABLE wishes ADD COLUMN hidden INTEGER NOT NULL DEFAULT 0');
    }
    if (!in_array('ip', $cols, true)) {
        $pdo->exec('ALTER TABLE wishes ADD COLUMN ip TEXT');
    }

    return $pdo;
}

function client_ip(): string
{
    foreach (['HTTP_CF_CONNECTING_IP', 'HTTP_X_FORWARDED_FOR', 'REMOTE_ADDR'] as $key) {
        if (!empty($_SERVER[$key])) {
            $ip = trim(explode(',', (string) $_SERVER[$key])[0]);
            if ($ip !== '') {
                return $ip;
            }
        }
    }
    return '0.0.0.0';
}

function censor_text(string $text, array $words): string
{
    foreach ($words as $word) {
        $word = trim((string) $word);
        if ($word === '') {
            continue;
        }
        $text = preg_replace_callback(
            '/' . preg_quote($word, '/') . '/iu',
            static fn ($m) => str_repeat('*', mb_strlen($m[0])),
            $text
        );
    }
    return $text;
}

function contains_link(string $text): bool
{
    return (bool) preg_match(
        '#(https?://|www\.|\b[\w-]+\.(com|net|org|info|biz|xyz|ru|top|link|site|online|click)\b)#i',
        $text
    );
}
