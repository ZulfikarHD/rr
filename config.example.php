<?php

/**
 * Copy this file to config.php and adjust the values.
 * config.php is git-ignored (like Laravel's .env) so your password
 * is never committed to GitHub. Upload config.php to the server once.
 */

return [
    // Password for the /admin page. CHANGE THIS.
    'admin_password' => 'ubah-password-ini',

    // --- Spam protection ---
    // Reject any wish that contains a URL/link (spam almost always has links).
    'block_links' => true,

    // Per-visitor (IP) rate limiting.
    'rate_limit_seconds' => 15,   // minimum seconds between two submissions
    'rate_limit_max'     => 6,    // max submissions allowed within the window
    'rate_limit_window'  => 600,  // window length in seconds (600 = 10 minutes)

    // --- Censorship ---
    // Words listed here are automatically masked with **** in stored wishes.
    'banned_words' => [
        // 'contoh', 'katakasar',
    ],
];
