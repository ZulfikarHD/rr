    function openInvitation() {
      const overlay = document.getElementById('invitationOverlay');
      const audio = document.getElementById('music');
      const musicToggle = document.getElementById('musicToggle');

      overlay.classList.add('hidden');

      audio.play().then(() => {
        musicToggle.classList.add('playing');
      }).catch(err => {
        console.log('Audio play failed:', err);
      });

      document.body.style.overflow = 'auto';
    }

    const WISHES_API = (window.WISHES_API || 'api/wishes.php');

    document.addEventListener('DOMContentLoaded', () => {
      document.body.style.overflow = 'hidden';
      loadWishes();
    });

    function updateCountdown() {
      const weddingDate = new Date('2026-06-27T09:00:00+07:00').getTime();
      const now = new Date().getTime();
      const distance = weddingDate - now;

      if (distance < 0) {
        document.getElementById('days').textContent = '00';
        document.getElementById('hours').textContent = '00';
        document.getElementById('minutes').textContent = '00';
        document.getElementById('seconds').textContent = '00';
        return;
      }

      const days = Math.floor(distance / (1000 * 60 * 60 * 24));
      const hours = Math.floor((distance % (1000 * 60 * 60 * 24)) / (1000 * 60 * 60));
      const minutes = Math.floor((distance % (1000 * 60 * 60)) / (1000 * 60));
      const seconds = Math.floor((distance % (1000 * 60)) / 1000);

      document.getElementById('days').textContent = String(days).padStart(2, '0');
      document.getElementById('hours').textContent = String(hours).padStart(2, '0');
      document.getElementById('minutes').textContent = String(minutes).padStart(2, '0');
      document.getElementById('seconds').textContent = String(seconds).padStart(2, '0');
    }

    updateCountdown();
    setInterval(updateCountdown, 1000);

    const observer = new IntersectionObserver((entries) => {
      entries.forEach(entry => {
        if (entry.isIntersecting) {
          entry.target.classList.add('visible');
        }
      });
    }, { threshold: 0.15, rootMargin: '0px 0px -50px 0px' });

    document.querySelectorAll('.reveal').forEach(el => observer.observe(el));

    async function handleRsvp(e) {
      e.preventDefault();
      const form = e.target;
      const nameInput = form.querySelector('input');
      const messageInput = form.querySelector('textarea');
      const name = nameInput.value.trim();
      const message = messageInput.value.trim();

      const btn = form.querySelector('.btn-rsvp');
      const originalText = btn.textContent;

      if (!message) {
        messageInput.focus();
        return;
      }

      btn.disabled = true;
      btn.textContent = 'Mengirim...';

      try {
        const res = await fetch(WISHES_API, {
          method: 'POST',
          headers: { 'Content-Type': 'application/json' },
          body: JSON.stringify({ name, message })
        });
        const json = await res.json();
        if (!res.ok) throw new Error(json.error || 'Gagal mengirim ucapan.');

        prependWish(json.data, true);
        form.reset();

        btn.textContent = 'Terima Kasih! ✓';
        btn.style.background = 'var(--gold)';
      } catch (err) {
        console.error(err);
        btn.textContent = 'Gagal, coba lagi';
        btn.style.background = '#b00020';
      } finally {
        setTimeout(() => {
          btn.textContent = originalText;
          btn.style.background = '';
          btn.disabled = false;
        }, 2500);
      }
    }

    function prependWish(wish, animate) {
      const wishList = document.getElementById('wishesList');
      if (!wishList) return;

      const empty = wishList.querySelector('.wishes-empty');
      if (empty) empty.remove();

      const wishCard = document.createElement('div');
      wishCard.className = 'wish-card';
      wishCard.innerHTML = `
        <div class="wish-name">${escapeHtml(wish.name || 'Tanpa Nama')}</div>
        <div class="wish-text">${escapeHtml(wish.message || '')}</div>
        <div class="wish-time">${timeAgo(wish.created_at)}</div>
      `;

      if (animate) {
        wishCard.style.opacity = '0';
        wishCard.style.transform = 'translateY(20px)';
        wishList.insertBefore(wishCard, wishList.firstChild);
        requestAnimationFrame(() => {
          wishCard.style.transition = 'opacity 0.5s ease, transform 0.5s ease';
          wishCard.style.opacity = '1';
          wishCard.style.transform = 'translateY(0)';
        });
      } else {
        wishList.appendChild(wishCard);
      }
    }

    async function loadWishes() {
      const wishList = document.getElementById('wishesList');
      if (!wishList) return;

      try {
        const res = await fetch(WISHES_API, { headers: { 'Accept': 'application/json' } });
        const json = await res.json();
        const items = (json && json.data) ? json.data : [];
        wishList.innerHTML = '';
        if (!items.length) {
          wishList.innerHTML = '<div class="wishes-empty">Jadilah yang pertama memberikan ucapan & doa.</div>';
          return;
        }
        items.forEach(w => prependWish(w, false));
      } catch (err) {
        console.error('Gagal memuat ucapan:', err);
      }
    }

    function timeAgo(ts) {
      if (!ts) return 'Baru saja';
      const then = Number(ts) * 1000;
      const diff = Math.floor((Date.now() - then) / 1000);
      if (diff < 60) return 'Baru saja';
      if (diff < 3600) return Math.floor(diff / 60) + ' menit lalu';
      if (diff < 86400) return Math.floor(diff / 3600) + ' jam lalu';
      if (diff < 2592000) return Math.floor(diff / 86400) + ' hari lalu';
      return new Date(then).toLocaleDateString('id-ID', { day: 'numeric', month: 'long', year: 'numeric', timeZone: 'Asia/Jakarta' });
    }

    function escapeHtml(text) {
      const div = document.createElement('div');
      div.textContent = text;
      return div.innerHTML;
    }

    function toggleMusic() {
      const audio = document.getElementById('music');
      const btn = document.getElementById('musicToggle');

      if (audio.paused) {
        audio.play().then(() => {
          btn.classList.add('playing');
        }).catch(err => {
          console.log('Failed to play audio:', err);
        });
      } else {
        audio.pause();
        btn.classList.remove('playing');
      }
    }

    function copyAccountNumber() {
      const accountNumber = '1260007420150';
      const btn = document.getElementById('copyBtn');

      navigator.clipboard.writeText(accountNumber).then(() => {
        btn.classList.add('copied');
        btn.innerHTML = `
          <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
            <polyline points="20 6 9 17 4 12"/>
          </svg>
          Tersalin!
        `;
        setTimeout(() => {
          btn.classList.remove('copied');
          btn.innerHTML = `
            <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
              <rect x="9" y="9" width="13" height="13" rx="2" ry="2"/>
              <path d="M5 15H4a2 2 0 0 1-2-2V4a2 2 0 0 1 2-2h9a2 2 0 0 1 2 2v1"/>
            </svg>
            Salin Nomor Rekening
          `;
        }, 2500);
      }).catch(() => {
        const textArea = document.createElement('textarea');
        textArea.value = accountNumber;
        textArea.style.position = 'fixed';
        textArea.style.opacity = '0';
        document.body.appendChild(textArea);
        textArea.select();
        document.execCommand('copy');
        document.body.removeChild(textArea);

        btn.classList.add('copied');
        btn.innerHTML = `
          <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
            <polyline points="20 6 9 17 4 12"/>
          </svg>
          Tersalin!
        `;
        setTimeout(() => {
          btn.classList.remove('copied');
          btn.innerHTML = `
            <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
              <rect x="9" y="9" width="13" height="13" rx="2" ry="2"/>
              <path d="M5 15H4a2 2 0 0 1-2-2V4a2 2 0 0 1 2-2h9a2 2 0 0 1 2 2v1"/>
            </svg>
            Salin Nomor Rekening
          `;
        }, 2500);
      });
    }

    document.querySelectorAll('a[href^="#"]').forEach(anchor => {
      anchor.addEventListener('click', function (e) {
        e.preventDefault();
        const target = document.querySelector(this.getAttribute('href'));
        if (target) target.scrollIntoView({ behavior: 'smooth' });
      });
    });
