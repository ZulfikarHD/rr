<?php

declare(strict_types=1);

require __DIR__ . '/../lib/app.php';

date_default_timezone_set('Asia/Jakarta');
session_start();

header('Cache-Control: no-store, no-cache, must-revalidate, max-age=0');

$config = app_config();
$error  = null;
$notice = null;

// ---- Logout ----
if (isset($_GET['logout'])) {
    $_SESSION = [];
    session_destroy();
    header('Location: index.php');
    exit;
}

// ---- Login ----
if (($_SERVER['REQUEST_METHOD'] ?? 'GET') === 'POST' && isset($_POST['login'])) {
    $given = (string) ($_POST['password'] ?? '');
    if (hash_equals((string) $config['admin_password'], $given)) {
        session_regenerate_id(true);
        $_SESSION['wadmin'] = true;
        $_SESSION['csrf']   = bin2hex(random_bytes(16));
        header('Location: index.php');
        exit;
    }
    $error = 'Password salah.';
}

$isAdmin = !empty($_SESSION['wadmin']);

// ---- Actions (delete / hide / unhide) ----
if ($isAdmin && ($_SERVER['REQUEST_METHOD'] ?? 'GET') === 'POST' && isset($_POST['action'])) {
    $token = (string) ($_POST['csrf'] ?? '');
    if (!hash_equals((string) ($_SESSION['csrf'] ?? ''), $token)) {
        $error = 'Sesi tidak valid, silakan ulangi.';
    } else {
        $id     = (int) ($_POST['id'] ?? 0);
        $action = (string) $_POST['action'];
        $pdo    = wishes_db();

        if ($id > 0 && $action === 'delete') {
            $pdo->prepare('DELETE FROM wishes WHERE id = :id')->execute([':id' => $id]);
            $notice = 'Ucapan dihapus.';
        } elseif ($id > 0 && $action === 'hide') {
            $pdo->prepare('UPDATE wishes SET hidden = 1 WHERE id = :id')->execute([':id' => $id]);
            $notice = 'Ucapan disembunyikan.';
        } elseif ($id > 0 && $action === 'unhide') {
            $pdo->prepare('UPDATE wishes SET hidden = 0 WHERE id = :id')->execute([':id' => $id]);
            $notice = 'Ucapan ditampilkan kembali.';
        }
    }
}

$wishes = [];
if ($isAdmin) {
    $wishes = wishes_db()
        ->query('SELECT id, name, message, created_at, hidden, ip FROM wishes ORDER BY id DESC')
        ->fetchAll(PDO::FETCH_ASSOC);
}

$usingDefaultPassword = ($config['admin_password'] === 'ubah-password-ini');

function e(?string $s): string
{
    return htmlspecialchars((string) $s, ENT_QUOTES, 'UTF-8');
}
?>
<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <meta name="robots" content="noindex, nofollow">
  <title>Admin - Ucapan & Doa</title>
  <style>
    * { box-sizing: border-box; margin: 0; padding: 0; }
    body { font-family: system-ui, -apple-system, "Segoe UI", Roboto, sans-serif; background: #f4f2ee; color: #3b322c; padding: 1.5rem; }
    .wrap { max-width: 860px; margin: 0 auto; }
    h1 { font-size: 1.3rem; margin-bottom: 1rem; color: #6b5550; }
    .card { background: #fff; border: 1px solid #e6ded5; border-radius: 12px; padding: 1.25rem; box-shadow: 0 2px 12px rgba(90,73,64,.05); }
    .topbar { display: flex; align-items: center; justify-content: space-between; margin-bottom: 1rem; gap: 1rem; flex-wrap: wrap; }
    .muted { color: #9e8e82; font-size: .85rem; }
    .alert { padding: .7rem 1rem; border-radius: 8px; margin-bottom: 1rem; font-size: .9rem; }
    .alert-error { background: #fde8e8; color: #9b1c1c; }
    .alert-ok { background: #e7f6ec; color: #1c7a3e; }
    .alert-warn { background: #fff4e0; color: #8a5a00; }
    input[type=password] { width: 100%; padding: .7rem .9rem; border: 1px solid #d8ccc0; border-radius: 8px; font-size: 1rem; }
    button { cursor: pointer; border: none; border-radius: 7px; font-size: .85rem; padding: .5rem .9rem; font-family: inherit; }
    .btn-primary { background: #6b5550; color: #fff; padding: .7rem 1.2rem; }
    .btn-link { background: transparent; color: #6b5550; text-decoration: underline; padding: 0; }
    .wish { border: 1px solid #ece4da; border-radius: 10px; padding: .9rem 1rem; margin-bottom: .8rem; }
    .wish.hidden-row { opacity: .6; background: #faf7f3; }
    .wish-head { display: flex; justify-content: space-between; gap: .8rem; align-items: baseline; flex-wrap: wrap; }
    .wish-name { font-weight: 700; }
    .wish-msg { margin: .4rem 0; white-space: pre-wrap; word-break: break-word; }
    .wish-meta { font-size: .72rem; color: #b0a294; }
    .badge { font-size: .68rem; padding: .1rem .5rem; border-radius: 20px; background: #efe7dd; color: #8a7a6c; }
    .badge.hidden { background: #f0d9d9; color: #9b1c1c; }
    .actions { display: flex; gap: .5rem; margin-top: .6rem; }
    .btn-del { background: #fbeaea; color: #9b1c1c; }
    .btn-hide { background: #eef0f2; color: #44515e; }
    .btn-show { background: #e7f6ec; color: #1c7a3e; }
    form.inline { display: inline; }
  </style>
</head>
<body>
<div class="wrap">

<?php if (!$isAdmin): ?>
  <h1>Admin — Ucapan & Doa</h1>
  <div class="card" style="max-width:380px;margin:2rem auto;">
    <?php if ($error): ?><div class="alert alert-error"><?= e($error) ?></div><?php endif; ?>
    <form method="post">
      <input type="hidden" name="login" value="1">
      <label class="muted">Password admin</label>
      <input type="password" name="password" autofocus required style="margin:.4rem 0 1rem;">
      <button type="submit" class="btn-primary" style="width:100%;">Masuk</button>
    </form>
  </div>
<?php else: ?>
  <div class="topbar">
    <h1>Ucapan &amp; Doa <span class="muted">(<?= count($wishes) ?> total)</span></h1>
    <a class="btn-link" href="?logout=1">Keluar</a>
  </div>

  <?php if ($usingDefaultPassword): ?>
    <div class="alert alert-warn">⚠ Anda masih memakai password default. Ubah <code>admin_password</code> di <code>config.php</code>.</div>
  <?php endif; ?>
  <?php if ($notice): ?><div class="alert alert-ok"><?= e($notice) ?></div><?php endif; ?>
  <?php if ($error): ?><div class="alert alert-error"><?= e($error) ?></div><?php endif; ?>

  <div class="card">
    <?php if (!$wishes): ?>
      <p class="muted">Belum ada ucapan.</p>
    <?php else: ?>
      <?php foreach ($wishes as $w): ?>
        <div class="wish <?= $w['hidden'] ? 'hidden-row' : '' ?>">
          <div class="wish-head">
            <span class="wish-name"><?= e($w['name']) ?></span>
            <?php if ($w['hidden']): ?><span class="badge hidden">Disembunyikan</span><?php endif; ?>
          </div>
          <div class="wish-msg"><?= e($w['message']) ?></div>
          <div class="wish-meta">
            <?= e(date('d M Y, H:i', (int) $w['created_at'])) ?> WIB
            &middot; IP: <?= e($w['ip'] ?? '-') ?>
          </div>
          <div class="actions">
            <?php if ($w['hidden']): ?>
              <form method="post" class="inline">
                <input type="hidden" name="csrf" value="<?= e($_SESSION['csrf']) ?>">
                <input type="hidden" name="id" value="<?= (int) $w['id'] ?>">
                <button type="submit" name="action" value="unhide" class="btn-show">Tampilkan</button>
              </form>
            <?php else: ?>
              <form method="post" class="inline">
                <input type="hidden" name="csrf" value="<?= e($_SESSION['csrf']) ?>">
                <input type="hidden" name="id" value="<?= (int) $w['id'] ?>">
                <button type="submit" name="action" value="hide" class="btn-hide">Sembunyikan</button>
              </form>
            <?php endif; ?>
            <form method="post" class="inline" onsubmit="return confirm('Hapus ucapan ini secara permanen?');">
              <input type="hidden" name="csrf" value="<?= e($_SESSION['csrf']) ?>">
              <input type="hidden" name="id" value="<?= (int) $w['id'] ?>">
              <button type="submit" name="action" value="delete" class="btn-del">Hapus</button>
            </form>
          </div>
        </div>
      <?php endforeach; ?>
    <?php endif; ?>
  </div>
  <p class="muted" style="margin-top:1rem;">Sembunyikan = tetap tersimpan tapi tidak tampil di undangan. Hapus = permanen.</p>
<?php endif; ?>

</div>
</body>
</html>
