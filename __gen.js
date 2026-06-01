// One-time generator: extracts shared CSS/JS and builds the PHP template.
// Deleted after running.
const fs = require('fs');
const path = require('path');

const root = __dirname;
const src = fs.readFileSync(path.join(root, 'gift', 'index.html'), 'utf8');

// 1. Extract <style> ... </style> -> assets/style.css
const styleMatch = src.match(/[ \t]*<style>\r?\n([\s\S]*?)\r?\n[ \t]*<\/style>/);
if (!styleMatch) throw new Error('style block not found');
const css = styleMatch[1];

// 2. Extract <script> ... </script> -> assets/app.js
const scriptMatch = src.match(/[ \t]*<script>\r?\n([\s\S]*?)\r?\n[ \t]*<\/script>/);
if (!scriptMatch) throw new Error('script block not found');
const js = scriptMatch[1];

fs.writeFileSync(path.join(root, 'assets', 'style.css'), css + '\n');
fs.writeFileSync(path.join(root, 'assets', 'app.js'), js + '\n');

// 3. Build the PHP template from the gift (superset) HTML.
let tpl = src;

// 3a. assets paths -> base-aware
tpl = tpl.replace(/\.\.\/assets\//g, '<?= $base ?>assets/');

// 3b. wrap the gift section in a $showRekening guard
const giftRe = /([ \t]*)<!-- ===== GIFT \/ AMPLOP DIGITAL ===== -->[\s\S]*?<\/section>/;
const giftM = tpl.match(giftRe);
if (!giftM) throw new Error('gift section not found');
const indent = giftM[1];
tpl = tpl.replace(giftRe, (block) => {
  const inner = block.replace(/^[ \t]*/, '');
  return `${indent}<?php if ($showRekening): ?>\n${indent}${inner}\n${indent}<?php endif; ?>`;
});

// 3c. replace the <style> block with an external stylesheet link
tpl = tpl.replace(/[ \t]*<style>\r?\n[\s\S]*?\r?\n[ \t]*<\/style>/,
  '  <link rel="stylesheet" href="<?= $base ?>assets/style.css">');

// 3d. replace the <script> block with the API config + external script
tpl = tpl.replace(/[ \t]*<script>\r?\n[\s\S]*?\r?\n[ \t]*<\/script>/,
  "  <script>window.WISHES_API = '<?= $base ?>api/wishes.php';</script>\n" +
  '  <script src="<?= $base ?>assets/app.js"></script>');

// 3e. prepend PHP defaults guard
const header = "<?php\n$base = $base ?? '';\n$showRekening = $showRekening ?? false;\n?>\n";
tpl = header + tpl;

fs.mkdirSync(path.join(root, 'partials'), { recursive: true });
fs.writeFileSync(path.join(root, 'partials', 'invitation.php'), tpl);

// 4. Entry files
fs.writeFileSync(path.join(root, 'index.php'),
  "<?php\n$showRekening = false;\n$base = '';\nrequire __DIR__ . '/partials/invitation.php';\n");

fs.writeFileSync(path.join(root, 'gift', 'index.php'),
  "<?php\n$showRekening = true;\n$base = '../';\nrequire __DIR__ . '/../partials/invitation.php';\n");

console.log('OK: generated style.css(%d), app.js(%d), partials/invitation.php, index.php, gift/index.php',
  css.length, js.length);
