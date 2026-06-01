<?php
$base = $base ?? '';
$showRekening = $showRekening ?? false;
?>
<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Undangan Pernikahan - Raka & Risti</title>
  <link rel="preconnect" href="https://fonts.googleapis.com">
  <link href="https://fonts.googleapis.com/css2?family=Cormorant+Garamond:ital,wght@0,300;0,400;0,600;1,300;1,400&family=Lora:ital,wght@0,400;0,600;1,400&family=Amiri:ital,wght@0,400;0,700;1,400&display=swap" rel="stylesheet">
  <link rel="stylesheet" href="<?= $base ?>assets/style.css">
</head>
<body>
  <audio src="<?= $base ?>assets/music.mp3" id="music" loop preload="auto" style="display:none"></audio>

  <!-- ===== INVITATION OVERLAY ===== -->
  <div class="invitation-overlay" id="invitationOverlay">
    <svg class="batik-bg" viewBox="0 0 800 1200" preserveAspectRatio="none">
      <defs>
        <pattern id="islamicOverlay" x="0" y="0" width="80" height="80" patternUnits="userSpaceOnUse">
          <polygon points="40,8 46,26 64,20 52,34 72,40 52,46 64,60 46,54 40,72 34,54 16,60 28,46 8,40 28,34 16,20 34,26" fill="none" stroke="#DDC3B6" stroke-width="0.5"/>
          <polygon points="40,20 44,32 56,28 48,36 60,40 48,44 56,52 44,48 40,60 36,48 24,52 32,44 20,40 32,36 24,28 36,32" fill="none" stroke="#DDC3B6" stroke-width="0.3"/>
          <circle cx="40" cy="40" r="5" fill="none" stroke="#DDC3B6" stroke-width="0.4"/>
          <circle cx="40" cy="40" r="2" fill="#DDC3B6" opacity="0.2"/>
          <line x1="0" y1="0" x2="16" y2="20" stroke="#DDC3B6" stroke-width="0.3" opacity="0.5"/>
          <line x1="80" y1="0" x2="64" y2="20" stroke="#DDC3B6" stroke-width="0.3" opacity="0.5"/>
          <line x1="0" y1="80" x2="16" y2="60" stroke="#DDC3B6" stroke-width="0.3" opacity="0.5"/>
          <line x1="80" y1="80" x2="64" y2="60" stroke="#DDC3B6" stroke-width="0.3" opacity="0.5"/>
          <circle cx="0" cy="0" r="3" fill="none" stroke="#DDC3B6" stroke-width="0.3"/>
          <circle cx="80" cy="0" r="3" fill="none" stroke="#DDC3B6" stroke-width="0.3"/>
          <circle cx="0" cy="80" r="3" fill="none" stroke="#DDC3B6" stroke-width="0.3"/>
          <circle cx="80" cy="80" r="3" fill="none" stroke="#DDC3B6" stroke-width="0.3"/>
        </pattern>
      </defs>
      <rect width="100%" height="100%" fill="url(#islamicOverlay)"/>
    </svg>

    <div class="invitation-glow-top"></div>
    <div class="invitation-glow-bottom"></div>

    <!-- Flo1 corner decorations -->
    <img class="overlay-flo1 top-left" src="<?= $base ?>assets/flo1.png" alt="">
    <img class="overlay-flo1 bottom-right" src="<?= $base ?>assets/flo1.png" alt="">

    <svg class="invitation-ornament-top" width="300" height="140" viewBox="0 0 300 140" fill="none">
      <path d="M150 5 C110 5, 50 40, 35 80 C25 105, 20 120, 15 140" stroke="rgba(221,195,182,0.5)" stroke-width="1" fill="none"/>
      <path d="M150 5 C190 5, 250 40, 265 80 C275 105, 280 120, 285 140" stroke="rgba(221,195,182,0.5)" stroke-width="1" fill="none"/>
      <path d="M150 15 C118 15, 65 45, 50 82 C42 102, 38 118, 32 140" stroke="rgba(221,195,182,0.3)" stroke-width="0.7" fill="none"/>
      <path d="M150 15 C182 15, 235 45, 250 82 C258 102, 262 118, 268 140" stroke="rgba(221,195,182,0.3)" stroke-width="0.7" fill="none"/>
      <polygon points="150,2 153,10 161,7 157,14 165,17 157,20 161,27 153,24 150,32 147,24 139,27 143,20 135,17 143,14 139,7 147,10" fill="rgba(221,195,182,0.4)" stroke="rgba(221,195,182,0.5)" stroke-width="0.5"/>
      <polygon points="105,35 108,40 113,38 111,43 116,45 111,47 113,52 108,50 105,55 102,50 97,52 99,47 94,45 99,43 97,38 102,40" fill="none" stroke="rgba(221,195,182,0.3)" stroke-width="0.4"/>
      <polygon points="195,35 198,40 203,38 201,43 206,45 201,47 203,52 198,50 195,55 192,50 187,52 189,47 184,45 189,43 187,38 192,40" fill="none" stroke="rgba(221,195,182,0.3)" stroke-width="0.4"/>
      <path d="M70,70 L75,65 L80,70 L75,75 Z" fill="none" stroke="rgba(221,195,182,0.25)" stroke-width="0.4"/>
      <path d="M230,70 L235,65 L240,70 L235,75 Z" fill="none" stroke="rgba(221,195,182,0.25)" stroke-width="0.4"/>
      <circle cx="120" cy="22" r="1.2" fill="rgba(221,195,182,0.4)"/>
      <circle cx="180" cy="22" r="1.2" fill="rgba(221,195,182,0.4)"/>
      <circle cx="85" cy="55" r="1" fill="rgba(221,195,182,0.3)"/>
      <circle cx="215" cy="55" r="1" fill="rgba(221,195,182,0.3)"/>
      <circle cx="55" cy="95" r="0.8" fill="rgba(221,195,182,0.2)"/>
      <circle cx="245" cy="95" r="0.8" fill="rgba(221,195,182,0.2)"/>
    </svg>

    <div class="invitation-content">
      <p class="invitation-bismillah">بِسْمِ اللَّهِ الرَّحْمَنِ الرَّحِيمِ</p>
      <p class="invitation-bismillah-sub">Dengan Nama Allah Yang Maha Pengasih Lagi Maha Penyayang</p>

      <div class="invitation-divider">
        <div class="invitation-divider-line"></div>
        <div class="invitation-divider-diamond"></div>
        <div class="invitation-divider-line"></div>
      </div>

      <!-- Oval photo -->
      <div class="invitation-cover-frame" style="margin: 0 auto 1.5rem; opacity: 0; animation: fadeInUp 0.8s ease forwards 0.58s;">
        <img src="<?= $base ?>assets/raka.png" alt="Raka & Risti">
      </div>

      <p class="invitation-title">Undangan Pernikahan</p>
      <h1 class="invitation-names">
        Raka
        <span class="amp">&</span>
        Risti
      </h1>
      <p class="invitation-date">27 &bull; 06 &bull; 2026</p>

      <button class="invitation-button" id="openInvitation" onclick="openInvitation()">
        <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5">
          <path d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/>
        </svg>
        Buka Undangan
      </button>
    </div>

    <svg class="invitation-ornament-bottom" width="300" height="140" viewBox="0 0 300 140" fill="none" style="transform: translateX(-50%) scaleY(-1);">
      <path d="M150 5 C110 5, 50 40, 35 80 C25 105, 20 120, 15 140" stroke="rgba(221,195,182,0.5)" stroke-width="1" fill="none"/>
      <path d="M150 5 C190 5, 250 40, 265 80 C275 105, 280 120, 285 140" stroke="rgba(221,195,182,0.5)" stroke-width="1" fill="none"/>
      <path d="M150 15 C118 15, 65 45, 50 82 C42 102, 38 118, 32 140" stroke="rgba(221,195,182,0.3)" stroke-width="0.7" fill="none"/>
      <path d="M150 15 C182 15, 235 45, 250 82 C258 102, 262 118, 268 140" stroke="rgba(221,195,182,0.3)" stroke-width="0.7" fill="none"/>
      <polygon points="105,35 108,40 113,38 111,43 116,45 111,47 113,52 108,50 105,55 102,50 97,52 99,47 94,45 99,43 97,38 102,40" fill="none" stroke="rgba(221,195,182,0.3)" stroke-width="0.4"/>
      <polygon points="195,35 198,40 203,38 201,43 206,45 201,47 203,52 198,50 195,55 192,50 187,52 189,47 184,45 189,43 187,38 192,40" fill="none" stroke="rgba(221,195,182,0.3)" stroke-width="0.4"/>
      <circle cx="120" cy="22" r="1.2" fill="rgba(221,195,182,0.4)"/>
      <circle cx="180" cy="22" r="1.2" fill="rgba(221,195,182,0.4)"/>
      <circle cx="85" cy="55" r="1" fill="rgba(221,195,182,0.3)"/>
      <circle cx="215" cy="55" r="1" fill="rgba(221,195,182,0.3)"/>
    </svg>
  </div>

  <!-- ===== COVER ===== -->
  <section class="cover-section">
    <!-- Flo1 decoration on the cover section -->
    <img class="cover-flo1 bottom-right" src="<?= $base ?>assets/flo1.png" alt="">

    <div class="cover-image-wrapper">
      <img src="<?= $base ?>assets/Group1.png" alt="Raka & Risti">
      <svg class="cover-wave" viewBox="0 0 1440 80" preserveAspectRatio="none">
        <path d="M0,40 C360,80 720,0 1080,40 C1260,60 1380,50 1440,40 L1440,80 L0,80 Z" fill="#FDFBF9"/>
      </svg>
    </div>

    <div class="cover-text-area">
      <svg class="floral-float" style="top: 10%; left: 5%; width: 80px;" viewBox="0 0 100 100" fill="none">
        <circle cx="50" cy="40" r="8" fill="#EAC7C3" opacity="0.6"/>
        <circle cx="42" cy="35" r="6" fill="#F3E1E1" opacity="0.5"/>
        <circle cx="58" cy="35" r="6" fill="#F3E1E1" opacity="0.5"/>
        <circle cx="45" cy="46" r="6" fill="#F3E1E1" opacity="0.5"/>
        <circle cx="55" cy="46" r="6" fill="#F3E1E1" opacity="0.5"/>
        <circle cx="50" cy="40" r="4" fill="#DDC3B6" opacity="0.7"/>
        <path d="M50 48 C48 55, 46 70, 48 85" stroke="#C7B9AC" stroke-width="1" fill="none"/>
        <path d="M48 65 C42 60, 36 58, 30 60" stroke="#C7B9AC" stroke-width="0.8" fill="none"/>
        <ellipse cx="28" cy="60" rx="5" ry="3" fill="#DDC3B6" opacity="0.3" transform="rotate(-20,28,60)"/>
      </svg>
      <svg class="floral-float" style="top: 15%; right: 5%; width: 60px;" viewBox="0 0 80 80" fill="none">
        <circle cx="40" cy="30" r="6" fill="#EAC7C3" opacity="0.5"/>
        <circle cx="34" cy="26" r="5" fill="#F3E1E1" opacity="0.4"/>
        <circle cx="46" cy="26" r="5" fill="#F3E1E1" opacity="0.4"/>
        <circle cx="37" cy="35" r="5" fill="#F3E1E1" opacity="0.4"/>
        <circle cx="43" cy="35" r="5" fill="#F3E1E1" opacity="0.4"/>
        <circle cx="40" cy="30" r="3" fill="#DDC3B6" opacity="0.6"/>
        <path d="M40 37 C38 45, 37 55, 39 68" stroke="#C7B9AC" stroke-width="0.8" fill="none"/>
      </svg>

      <p class="bismillah">بِسْمِ اللَّهِ الرَّحْمَنِ الرَّحِيمِ</p>
      <p class="bismillah-sub">Dengan Nama Allah Yang Maha Pengasih Lagi Maha Penyayang</p>

      <p class="cover-title-small">Undangan Pernikahan</p>

      <h1 class="couple-names-cover">
        Raka
        <span class="ampersand">&</span>
        Risti
      </h1>

      <p class="cover-date">27 &bull; 06 &bull; 2026</p>

      <div class="scroll-indicator">
        <span>Gulir ke Bawah</span>
        <div class="scroll-arrow"></div>
      </div>
    </div>
  </section>

  <!-- ===== QURAN VERSE ===== -->
  <section class="quran-section">
    <svg class="floral-corner top-left" width="140" height="140" viewBox="0 0 140 140" fill="none">
      <path d="M0 0 C10 30, 20 60, 15 90 C12 110, 5 125, 0 140" stroke="#EAC7C3" stroke-width="1.2" fill="none" opacity="0.5"/>
      <path d="M0 0 C30 10, 60 20, 90 15 C110 12, 125 5, 140 0" stroke="#EAC7C3" stroke-width="1.2" fill="none" opacity="0.5"/>
      <circle cx="25" cy="25" r="10" fill="#F3E1E1" opacity="0.4"/>
      <circle cx="20" cy="20" r="7" fill="#EAC7C3" opacity="0.3"/>
      <circle cx="30" cy="20" r="6" fill="#F3E1E1" opacity="0.3"/>
      <circle cx="20" cy="30" r="6" fill="#F3E1E1" opacity="0.3"/>
      <circle cx="25" cy="25" r="4" fill="#DDC3B6" opacity="0.4"/>
      <circle cx="55" cy="12" r="5" fill="#F3E1E1" opacity="0.3"/>
      <circle cx="55" cy="12" r="3" fill="#EAC7C3" opacity="0.3"/>
      <circle cx="12" cy="55" r="5" fill="#F3E1E1" opacity="0.3"/>
      <circle cx="12" cy="55" r="3" fill="#EAC7C3" opacity="0.3"/>
      <path d="M25 35 C22 50, 18 65, 10 80" stroke="#C7B9AC" stroke-width="0.8" fill="none" opacity="0.4"/>
      <path d="M35 25 C50 22, 65 18, 80 10" stroke="#C7B9AC" stroke-width="0.8" fill="none" opacity="0.4"/>
      <ellipse cx="8" cy="82" rx="4" ry="3" fill="#DDC3B6" opacity="0.25" transform="rotate(-30,8,82)"/>
      <ellipse cx="82" cy="8" rx="4" ry="3" fill="#DDC3B6" opacity="0.25" transform="rotate(60,82,8)"/>
    </svg>
    <svg class="floral-corner top-right" width="140" height="140" viewBox="0 0 140 140" fill="none">
      <path d="M0 0 C10 30, 20 60, 15 90 C12 110, 5 125, 0 140" stroke="#EAC7C3" stroke-width="1.2" fill="none" opacity="0.5"/>
      <path d="M0 0 C30 10, 60 20, 90 15 C110 12, 125 5, 140 0" stroke="#EAC7C3" stroke-width="1.2" fill="none" opacity="0.5"/>
      <circle cx="25" cy="25" r="10" fill="#F3E1E1" opacity="0.4"/>
      <circle cx="20" cy="20" r="7" fill="#EAC7C3" opacity="0.3"/>
      <circle cx="30" cy="20" r="6" fill="#F3E1E1" opacity="0.3"/>
      <circle cx="25" cy="25" r="4" fill="#DDC3B6" opacity="0.4"/>
      <circle cx="55" cy="12" r="5" fill="#F3E1E1" opacity="0.3"/>
      <circle cx="12" cy="55" r="5" fill="#F3E1E1" opacity="0.3"/>
      <path d="M25 35 C22 50, 18 65, 10 80" stroke="#C7B9AC" stroke-width="0.8" fill="none" opacity="0.4"/>
      <path d="M35 25 C50 22, 65 18, 80 10" stroke="#C7B9AC" stroke-width="0.8" fill="none" opacity="0.4"/>
    </svg>

    <div class="section-inner reveal">
      <div class="quran-verse">
        <p class="quran-arabic">وَمِنْ آيَاتِهِ أَنْ خَلَقَ لَكُم مِّنْ أَنفُسِكُمْ أَزْوَاجًا لِّتَسْكُنُوا إِلَيْهَا وَجَعَلَ بَيْنَكُم مَّوَدَّةً وَرَحْمَةً</p>
        <p class="quran-translation">
          "Dan di antara tanda-tanda (kebesaran)-Nya ialah Dia menciptakan pasangan-pasangan untukmu dari jenismu sendiri,
          agar kamu cenderung dan merasa tenteram kepadanya, dan Dia menjadikan di antaramu rasa kasih dan sayang."
        </p>
        <p class="quran-ref">QS. Ar-Rum : 21</p>
      </div>
    </div>
  </section>

  <!-- ===== COUPLE ===== -->
  <section class="couple-section">
    <svg class="batik-pattern" viewBox="0 0 800 600" preserveAspectRatio="none">
      <defs>
        <pattern id="islamicCouple" x="0" y="0" width="60" height="60" patternUnits="userSpaceOnUse">
          <polygon points="30,5 50,15 50,35 30,45 10,35 10,15" fill="none" stroke="#DDC3B6" stroke-width="0.6"/>
          <polygon points="30,12 42,19 42,31 30,38 18,31 18,19" fill="none" stroke="#EAC7C3" stroke-width="0.4"/>
          <circle cx="30" cy="23" r="3" fill="none" stroke="#DDC3B6" stroke-width="0.4"/>
          <circle cx="30" cy="23" r="1" fill="#DDC3B6" opacity="0.15"/>
          <line x1="0" y1="0" x2="10" y2="15" stroke="#DDC3B6" stroke-width="0.3" opacity="0.4"/>
          <line x1="60" y1="0" x2="50" y2="15" stroke="#DDC3B6" stroke-width="0.3" opacity="0.4"/>
          <line x1="0" y1="60" x2="10" y2="35" stroke="#DDC3B6" stroke-width="0.3" opacity="0.4"/>
          <line x1="60" y1="60" x2="50" y2="35" stroke="#DDC3B6" stroke-width="0.3" opacity="0.4"/>
        </pattern>
      </defs>
      <rect width="100%" height="100%" fill="url(#islamicCouple)"/>
    </svg>

    <div class="section-inner">
      <div class="section-label reveal">Mempelai</div>
      <h2 class="section-title reveal">Yang Berbahagia</h2>

      <div class="couple-card reveal">
        <div class="couple-photo-frame">
          <img class="couple-photo-img" src="<?= $base ?>assets/raka01.png" alt="Raka Ditya Septiawan">
        </div>
        <h3 class="couple-name">Raka Ditya Septiawan</h3>
        <p class="couple-parents">Putra pertama dari<br>Bapak Irawan & Ibu Erna Purwati</p>
      </div>

      <div style="position: relative; text-align: center;">
        <svg class="floral-divider" width="200" height="50" viewBox="0 0 200 50" fill="none" style="margin-bottom: -0.5rem;">
          <path d="M20 25 C40 25, 50 15, 70 18 C85 20, 90 25, 100 25" stroke="#DDC3B6" stroke-width="0.8" fill="none"/>
          <path d="M100 25 C110 25, 115 20, 130 18 C150 15, 160 25, 180 25" stroke="#DDC3B6" stroke-width="0.8" fill="none"/>
          <circle cx="60" cy="16" r="5" fill="#F3E1E1" opacity="0.5"/>
          <circle cx="57" cy="14" r="4" fill="#EAC7C3" opacity="0.4"/>
          <circle cx="63" cy="14" r="3.5" fill="#F3E1E1" opacity="0.4"/>
          <circle cx="60" cy="16" r="2.5" fill="#DDC3B6" opacity="0.5"/>
          <circle cx="140" cy="16" r="5" fill="#F3E1E1" opacity="0.5"/>
          <circle cx="137" cy="14" r="4" fill="#EAC7C3" opacity="0.4"/>
          <circle cx="143" cy="14" r="3.5" fill="#F3E1E1" opacity="0.4"/>
          <circle cx="140" cy="16" r="2.5" fill="#DDC3B6" opacity="0.5"/>
          <ellipse cx="45" cy="22" rx="3" ry="2" fill="#DDC3B6" opacity="0.25" transform="rotate(-15,45,22)"/>
          <ellipse cx="155" cy="22" rx="3" ry="2" fill="#DDC3B6" opacity="0.25" transform="rotate(15,155,22)"/>
        </svg>
      </div>
      <div class="couple-ampersand reveal">&</div>

      <div class="couple-card reveal">
        <div class="couple-photo-frame">
          <img class="couple-photo-img" src="<?= $base ?>assets/risti01.png" alt="Risti Fatihatul Afifah">
        </div>
        <h3 class="couple-name">Risti Fatihatul Afifah</h3>
        <p class="couple-parents">Putri pertama dari<br>Bapak Suprapto & Ibu Rusminah</p>
      </div>
    </div>
  </section>

  <!-- ===== EVENT DETAILS ===== -->
  <section class="event-section">
    <svg class="floral-corner bottom-left" width="120" height="120" viewBox="0 0 120 120" fill="none">
      <path d="M0 0 C8 25, 15 50, 12 75 C10 90, 4 105, 0 120" stroke="#EAC7C3" stroke-width="1" fill="none" opacity="0.4"/>
      <path d="M0 0 C25 8, 50 15, 75 12 C90 10, 105 4, 120 0" stroke="#EAC7C3" stroke-width="1" fill="none" opacity="0.4"/>
      <circle cx="20" cy="20" r="8" fill="#F3E1E1" opacity="0.35"/>
      <circle cx="16" cy="16" r="6" fill="#EAC7C3" opacity="0.25"/>
      <circle cx="24" cy="16" r="5" fill="#F3E1E1" opacity="0.25"/>
      <circle cx="20" cy="20" r="3.5" fill="#DDC3B6" opacity="0.3"/>
      <circle cx="45" cy="10" r="4" fill="#F3E1E1" opacity="0.25"/>
      <circle cx="10" cy="45" r="4" fill="#F3E1E1" opacity="0.25"/>
    </svg>
    <svg class="floral-corner bottom-right" width="120" height="120" viewBox="0 0 120 120" fill="none">
      <path d="M0 0 C8 25, 15 50, 12 75 C10 90, 4 105, 0 120" stroke="#EAC7C3" stroke-width="1" fill="none" opacity="0.4"/>
      <path d="M0 0 C25 8, 50 15, 75 12 C90 10, 105 4, 120 0" stroke="#EAC7C3" stroke-width="1" fill="none" opacity="0.4"/>
      <circle cx="20" cy="20" r="8" fill="#F3E1E1" opacity="0.35"/>
      <circle cx="16" cy="16" r="6" fill="#EAC7C3" opacity="0.25"/>
      <circle cx="20" cy="20" r="3.5" fill="#DDC3B6" opacity="0.3"/>
    </svg>

    <div class="section-inner">
      <div class="section-label reveal">Waktu & Tempat</div>
      <h2 class="section-title reveal">Acara Pernikahan</h2>

      <div class="event-cards" style="max-width: 420px; margin: 2rem auto 0;">
        <div class="event-card reveal">
          <div class="event-icon">
            <svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="white" stroke-width="1.5">
              <path d="M4 19.5A2.5 2.5 0 0 1 6.5 17H20"/>
              <path d="M6.5 2H20v20H6.5A2.5 2.5 0 0 1 4 19.5v-15A2.5 2.5 0 0 1 6.5 2z"/>
            </svg>
          </div>
          <h3>Akad Nikah</h3>
          <div class="event-detail">
            <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
              <rect x="3" y="4" width="18" height="18" rx="2" ry="2"/>
              <line x1="16" y1="2" x2="16" y2="6"/>
              <line x1="8" y1="2" x2="8" y2="6"/>
              <line x1="3" y1="10" x2="21" y2="10"/>
            </svg>
            <span>Jum'at, 26 Juni 2026</span>
          </div>
          <div class="event-detail">
            <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
              <circle cx="12" cy="12" r="10"/>
              <polyline points="12 6 12 12 16 14"/>
            </svg>
            <span>08:00 - 10:00 WIB</span>
          </div>
          <div class="event-detail">
            <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
              <path d="M21 10c0 7-9 13-9 13s-9-6-9-13a9 9 0 0 1 18 0z"/>
              <circle cx="12" cy="10" r="3"/>
            </svg>
            <span>Kantor KUA Tambun Utara</span>
          </div>
        </div>

        <div class="event-card reveal">
          <div class="event-icon">
            <svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="white" stroke-width="1.5">
              <path d="M20.84 4.61a5.5 5.5 0 0 0-7.78 0L12 5.67l-1.06-1.06a5.5 5.5 0 0 0-7.78 7.78l1.06 1.06L12 21.23l7.78-7.78 1.06-1.06a5.5 5.5 0 0 0 0-7.78z"/>
            </svg>
          </div>
          <h3>Resepsi</h3>
          <div class="event-detail">
            <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
              <rect x="3" y="4" width="18" height="18" rx="2" ry="2"/>
              <line x1="16" y1="2" x2="16" y2="6"/>
              <line x1="8" y1="2" x2="8" y2="6"/>
              <line x1="3" y1="10" x2="21" y2="10"/>
            </svg>
            <span>Sabtu, 27 Juni 2026</span>
          </div>
          <div class="event-detail">
            <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
              <circle cx="12" cy="12" r="10"/>
              <polyline points="12 6 12 12 16 14"/>
            </svg>
            <span>10:00 - 17:00 WIB</span>
          </div>
          <div class="event-detail">
            <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
              <path d="M21 10c0 7-9 13-9 13s-9-6-9-13a9 9 0 0 1 18 0z"/>
              <circle cx="12" cy="10" r="3"/>
            </svg>
            <span>Rumah Mempelai Wanita<br>Villa Permata Blok CB 11 No 19 Jl. Delima RT 001 RW 011, Ds. Jejalen Jaya, Tambun Utara, Bekasi</span>
          </div>
        </div>
      </div>

      <div style="text-align: center; margin-top: 2rem;" class="reveal">
        <a href="https://maps.app.goo.gl/ueXv31HThPbDoKix9" target="_blank" style="
          display: inline-flex;
          align-items: center;
          gap: 0.5rem;
          padding: 0.8rem 1.5rem;
          background: var(--green-main);
          color: white;
          text-decoration: none;
          border-radius: 8px;
          font-family: 'Lora', serif;
          font-size: 0.85rem;
          transition: background 0.3s ease;
        ">
          <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
            <path d="M21 10c0 7-9 13-9 13s-9-6-9-13a9 9 0 0 1 18 0z"/>
            <circle cx="12" cy="10" r="3"/>
          </svg>
          Buka Google Maps
        </a>
      </div>
    </div>
  </section>

  <!-- ===== COUNTDOWN ===== -->
  <section class="countdown-section">
    <svg class="batik-pattern" viewBox="0 0 800 400" preserveAspectRatio="none" style="opacity: 0.06;">
      <defs>
        <pattern id="islamicCountdown" x="0" y="0" width="60" height="60" patternUnits="userSpaceOnUse">
          <polygon points="30,5 50,15 50,35 30,45 10,35 10,15" fill="none" stroke="#fff" stroke-width="0.6"/>
          <polygon points="30,12 42,19 42,31 30,38 18,31 18,19" fill="none" stroke="#fff" stroke-width="0.4"/>
          <circle cx="30" cy="23" r="3" fill="none" stroke="#DDC3B6" stroke-width="0.4"/>
        </pattern>
      </defs>
      <rect width="100%" height="100%" fill="url(#islamicCountdown)"/>
    </svg>

    <div class="section-inner">
      <div class="section-label reveal">Hitung Mundur</div>
      <h2 class="section-title reveal">Menuju Hari Bahagia</h2>

      <div class="countdown-grid reveal">
        <div class="countdown-item">
          <span class="countdown-number" id="days">00</span>
          <span class="countdown-label">Hari</span>
        </div>
        <span class="countdown-separator">:</span>
        <div class="countdown-item">
          <span class="countdown-number" id="hours">00</span>
          <span class="countdown-label">Jam</span>
        </div>
        <span class="countdown-separator">:</span>
        <div class="countdown-item">
          <span class="countdown-number" id="minutes">00</span>
          <span class="countdown-label">Menit</span>
        </div>
        <span class="countdown-separator">:</span>
        <div class="countdown-item">
          <span class="countdown-number" id="seconds">00</span>
          <span class="countdown-label">Detik</span>
        </div>
      </div>
    </div>
  </section>

  <?php if ($showRekening): ?>
  <!-- ===== GIFT / AMPLOP DIGITAL ===== -->
  <section class="gift-section">
    <svg class="floral-corner top-left" width="120" height="120" viewBox="0 0 120 120" fill="none">
      <path d="M0 0 C8 25, 15 50, 12 75 C10 90, 4 105, 0 120" stroke="#EAC7C3" stroke-width="1" fill="none" opacity="0.4"/>
      <path d="M0 0 C25 8, 50 15, 75 12 C90 10, 105 4, 120 0" stroke="#EAC7C3" stroke-width="1" fill="none" opacity="0.4"/>
      <circle cx="20" cy="20" r="8" fill="#F3E1E1" opacity="0.35"/>
      <circle cx="16" cy="16" r="6" fill="#EAC7C3" opacity="0.25"/>
      <circle cx="20" cy="20" r="3.5" fill="#DDC3B6" opacity="0.3"/>
    </svg>
    <svg class="floral-corner bottom-right" width="120" height="120" viewBox="0 0 120 120" fill="none">
      <path d="M0 0 C8 25, 15 50, 12 75 C10 90, 4 105, 0 120" stroke="#EAC7C3" stroke-width="1" fill="none" opacity="0.4"/>
      <path d="M0 0 C25 8, 50 15, 75 12 C90 10, 105 4, 120 0" stroke="#EAC7C3" stroke-width="1" fill="none" opacity="0.4"/>
      <circle cx="20" cy="20" r="8" fill="#F3E1E1" opacity="0.35"/>
      <circle cx="16" cy="16" r="6" fill="#EAC7C3" opacity="0.25"/>
      <circle cx="20" cy="20" r="3.5" fill="#DDC3B6" opacity="0.3"/>
    </svg>

    <div class="section-inner">
      <div class="section-label reveal">Hadiah</div>
      <h2 class="section-title reveal">Amplop Digital</h2>

      <div class="gift-card reveal">
        <div class="gift-icon">
          <svg width="26" height="26" viewBox="0 0 24 24" fill="none" stroke="white" stroke-width="1.5">
            <rect x="3" y="8" width="18" height="13" rx="2"/>
            <path d="M12 8V21"/>
            <path d="M3 12h18"/>
            <path d="M12 8C12 8 12 4 8.5 4C5 4 5 8 8.5 8"/>
            <path d="M12 8C12 8 12 4 15.5 4C19 4 19 8 15.5 8"/>
          </svg>
        </div>

        <p class="gift-note">
          Doa restu Anda merupakan karunia yang sangat berarti bagi kami.
          Namun jika Anda ingin memberikan tanda kasih, kami menyediakan amplop digital di bawah ini.
        </p>

        <div class="gift-bank-info">
          <div class="gift-bank-name">Bank Mandiri</div>
          <div class="gift-account-number" id="accountNumber">1260007420150</div>
          <div class="gift-account-name">a.n. RAKADITYA SEPTIAWAN</div>
          <button class="gift-copy-btn" id="copyBtnMandiri" onclick="copyAccountNumberMandiri()">
            <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
              <rect x="9" y="9" width="13" height="13" rx="2" ry="2"/>
              <path d="M5 15H4a2 2 0 0 1-2-2V4a2 2 0 0 1 2-2h9a2 2 0 0 1 2 2v1"/>
            </svg>
            Salin Nomor Rekening
          </button>
        </div>

        <div class="gift-bank-info">
          <div class="gift-bank-name">Bank BCA Digital</div>
          <div class="gift-account-number" id="accountNumber">005880384943</div>
          <div class="gift-account-name">a.n. RAKADITYA SEPTIAWAN</div>
          <button class="gift-copy-btn" id="copyBtnBCA" onclick="copyAccountNumberBCA()">
            <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
              <rect x="9" y="9" width="13" height="13" rx="2" ry="2"/>
              <path d="M5 15H4a2 2 0 0 1-2-2V4a2 2 0 0 1 2-2h9a2 2 0 0 1 2 2v1"/>
            </svg>
            Salin Nomor Rekening
          </button>
        </div>
      </div>
    </div>
  </section>
  <?php endif; ?>

  <!-- ===== RSVP ===== -->
  <section class="rsvp-section">
    <svg class="floral-corner top-right" width="100" height="100" viewBox="0 0 100 100" fill="none">
      <path d="M0 0 C8 20, 12 40, 10 60 C8 75, 3 88, 0 100" stroke="#EAC7C3" stroke-width="0.8" fill="none" opacity="0.4"/>
      <path d="M0 0 C20 8, 40 12, 60 10 C75 8, 88 3, 100 0" stroke="#EAC7C3" stroke-width="0.8" fill="none" opacity="0.4"/>
      <circle cx="18" cy="18" r="7" fill="#F3E1E1" opacity="0.35"/>
      <circle cx="15" cy="15" r="5" fill="#EAC7C3" opacity="0.3"/>
      <circle cx="18" cy="18" r="3" fill="#DDC3B6" opacity="0.35"/>
    </svg>

    <div class="section-inner">
      <div class="section-label reveal">Ucapan & Doa</div>
      <h2 class="section-title reveal">Ucapan & Doa</h2>

      <form class="rsvp-form reveal" id="rsvpForm" onsubmit="handleRsvp(event)">
        <div class="form-group">
          <label>Nama Lengkap</label>
          <input type="text" id="rsvpName" placeholder="Masukkan nama lengkap" required>
        </div>
        <div class="form-group">
          <label>Ucapan & Doa</label>
          <textarea id="rsvpMessage" placeholder="Tulis ucapan dan doa untuk kedua mempelai..."></textarea>
        </div>
        <input type="text" id="rsvpWebsite" name="website" class="hp-field" tabindex="-1" autocomplete="off" aria-hidden="true">
        <button type="submit" class="btn-rsvp">Kirim Ucapan</button>
        <p class="rsvp-status" id="rsvpStatus" role="status"></p>
      </form>
    </div>
  </section>

  <!-- ===== WISHES ===== -->
  <section class="wishes-section">
    <div class="section-inner">
      <h2 class="section-title reveal">Doa & Ucapan</h2>
      <div class="wishes-list reveal" id="wishesList"></div>
    </div>
  </section>

  <!-- ===== FOOTER ===== -->
  <section class="footer-section">
    <svg class="batik-pattern" viewBox="0 0 800 300" preserveAspectRatio="none" style="opacity: 0.05;">
      <defs>
        <pattern id="islamicFooter" x="0" y="0" width="50" height="50" patternUnits="userSpaceOnUse">
          <polygon points="25,3 38,10 38,24 25,31 12,24 12,10" fill="none" stroke="#fff" stroke-width="0.5"/>
          <circle cx="25" cy="17" r="4" fill="none" stroke="#DDC3B6" stroke-width="0.4"/>
          <circle cx="25" cy="17" r="1.5" fill="#fff" opacity="0.15"/>
        </pattern>
      </defs>
      <rect width="100%" height="100%" fill="url(#islamicFooter)"/>
    </svg>

    <div class="section-inner">
      <div class="footer-dua">وَ الْحَمْدُ لِلَّهِ رَبِّ الْعَالَمِينَ</div>
      <div class="divider" style="margin: 1.5rem auto;">
        <div class="divider-line" style="background: rgba(255,255,255,0.2);"></div>
        <div class="divider-diamond" style="border-color: var(--gold-light);"></div>
        <div class="divider-line" style="background: rgba(255,255,255,0.2);"></div>
      </div>
      <h2 class="footer-couple">Raka <span class="amp">&</span> Risti</h2>
      <p class="footer-thanks">
        Merupakan suatu kehormatan dan kebahagiaan bagi kami<br>
        apabila Bapak/Ibu/Saudara/i berkenan hadir<br>
        untuk memberikan doa restu kepada kami.
      </p>
      <p class="footer-thanks" style="margin-top: 1rem;">
        <em>Wassalamu'alaikum Warahmatullahi Wabarakatuh</em>
      </p>
      <p class="footer-credit">Made with ♥ | Raka & Risti 2026</p>
    </div>
  </section>

  <!-- ===== MUSIC TOGGLE ===== -->
  <button class="music-toggle" id="musicToggle" onclick="toggleMusic()" title="Toggle Music">
    <svg id="musicIcon" width="20" height="20" viewBox="0 0 24 24" fill="white">
      <path d="M9 18V5l12-2v13"/>
      <circle cx="6" cy="18" r="3"/>
      <circle cx="18" cy="16" r="3"/>
    </svg>
  </button>

  <script>window.WISHES_API = '<?= $base ?>api/wishes.php';</script>
  <script src="<?= $base ?>assets/app.js"></script>
</body>
</html>
