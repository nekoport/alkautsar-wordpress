(function() {
    'use strict';

    // Dark Mode
    function initDarkMode() {
        const saved = localStorage.getItem('alkDarkMode');
        if (saved === 'true') {
            document.documentElement.setAttribute('data-theme', 'dark');
        }
    }

    window.toggleDarkMode = function() {
        const html = document.documentElement;
        const isDark = html.getAttribute('data-theme') === 'dark';
        if (isDark) {
            html.removeAttribute('data-theme');
            localStorage.setItem('alkDarkMode', 'false');
        } else {
            html.setAttribute('data-theme', 'dark');
            localStorage.setItem('alkDarkMode', 'true');
        }
    };

    initDarkMode();

    // Search Overlay
    window.toggleSearch = function() {
        const overlay = document.getElementById('searchOverlay');
        overlay.classList.toggle('active');
        if (overlay.classList.contains('active')) {
            setTimeout(() => {
                overlay.querySelector('input[type="search"]').focus();
            }, 300);
        }
    };

    // Mobile Menu
    window.toggleMenu = function() {
        const menu = document.querySelector('.main-navigation ul');
        menu.classList.toggle('active');
    };

    // Lightbox
    let lightboxImages = [];
    let currentIndex = 0;

    window.openLightbox = function(imgSrc) {
        const items = document.querySelectorAll('.gallery-item img');
        lightboxImages = Array.from(items).map(img => img.src);
        currentIndex = lightboxImages.indexOf(imgSrc);
        if (currentIndex === -1) currentIndex = 0;

        const lightbox = document.getElementById('lightbox');
        const img = document.getElementById('lightboxImg');
        img.src = imgSrc;
        lightbox.classList.add('active');
        document.body.style.overflow = 'hidden';
    };

    window.closeLightbox = function() {
        const lightbox = document.getElementById('lightbox');
        lightbox.classList.remove('active');
        document.body.style.overflow = '';
    };

    window.prevLightbox = function() {
        if (lightboxImages.length === 0) return;
        currentIndex = (currentIndex - 1 + lightboxImages.length) % lightboxImages.length;
        document.getElementById('lightboxImg').src = lightboxImages[currentIndex];
    };

    window.nextLightbox = function() {
        if (lightboxImages.length === 0) return;
        currentIndex = (currentIndex + 1) % lightboxImages.length;
        document.getElementById('lightboxImg').src = lightboxImages[currentIndex];
    };

    document.addEventListener('keydown', function(e) {
        if (e.key === 'Escape') {
            closeLightbox();
            const searchOverlay = document.getElementById('searchOverlay');
            if (searchOverlay.classList.contains('active')) {
                toggleSearch();
            }
        }
        if (e.key === 'ArrowLeft') prevLightbox();
        if (e.key === 'ArrowRight') nextLightbox();
    });

    // Header scroll effect
    function handleScroll() {
        const header = document.getElementById('masthead');
        if (window.scrollY > 50) {
            header.classList.add('scrolled');
        } else {
            header.classList.remove('scrolled');
        }
    }

    window.addEventListener('scroll', handleScroll, { passive: true });

    // Prayer Times - Render dengan highlight dinamis
    function renderPrayerTimes(timings) {
        const prayers = [
            { name: 'Imsak',   key: 'Imsak'   },
            { name: 'Subuh',   key: 'Fajr'    },
            { name: 'Terbit',  key: 'Sunrise' },
            { name: 'Dzuhur',  key: 'Dhuhr'   },
            { name: 'Ashar',   key: 'Asr'     },
            { name: 'Maghrib', key: 'Maghrib' },
            { name: 'Isya',    key: 'Isha'    }
        ];

        const now = new Date();
        const currentMinutes = now.getHours() * 60 + now.getMinutes();

        function toMinutes(timeStr) {
            const clean = timeStr.split(' ')[0];
            const [h, m] = clean.split(':').map(Number);
            return h * 60 + m;
        }

        let nextIndex = -1;
        let passedCount = 0;

        for (let i = 0; i < prayers.length; i++) {
            const prayerMinutes = toMinutes(timings[prayers[i].key] || '00:00');
            if (currentMinutes < prayerMinutes) {
                nextIndex = i;
                break;
            } else {
                passedCount = i + 1;
            }
        }

        const grid = document.getElementById('prayer-times-grid');
        if (!grid) return;

        grid.innerHTML = prayers.map(function(p, i) {
            const time = (timings[p.key] || '--:--').split(' ')[0];
            var cls = 'prayer-time-item';
            if (i === nextIndex) cls += ' active';
            else if (i < passedCount) cls += ' passed';

            return '<div class="' + cls + '">' +
                '<span class="prayer-name">' + p.name + '</span>' +
                '<span class="prayer-time">' + time + '</span>' +
                '</div>';
        }).join('');

        const banner = document.getElementById('next-prayer-banner');
        if (banner) {
            if (nextIndex >= 0) {
                const next = prayers[nextIndex];
                const nextTime = (timings[next.key] || '--:--').split(' ')[0];
                const [h, m] = nextTime.split(':').map(Number);
                const nextMin = h * 60 + m;
                const diff = nextMin - currentMinutes;
                const diffH = Math.floor(diff / 60);
                const diffM = diff % 60;
                const countdown = diffH > 0
                    ? diffH + ' jam ' + diffM + ' menit lagi'
                    : diffM + ' menit lagi';
                banner.innerHTML = '\u23F0 Waktu sholat berikutnya: ' +
                    '<strong>' + next.name + '</strong> pukul ' +
                    '<strong>' + nextTime + '</strong> \u2014 ' +
                    '<span style="color:var(--color-gold)">' + countdown + '</span>';
            } else {
                banner.innerHTML = '\u2705 Semua waktu sholat hari ini telah berlalu. Jazakallah khair.';
            }
        }
    }

    // Update tanggal dalam bahasa Indonesia
    function updatePrayerDate() {
        const dateEl = document.getElementById('prayer-date');
        if (!dateEl) return;
        const hari = ['Minggu','Senin','Selasa','Rabu','Kamis','Jumat','Sabtu'];
        const bulan = ['Januari','Februari','Maret','April','Mei','Juni',
                       'Juli','Agustus','September','Oktober','November','Desember'];
        var d = new Date();
        dateEl.textContent = hari[d.getDay()] + ', ' + d.getDate() + ' ' + bulan[d.getMonth()] + ' ' + d.getFullYear();
    }

    // Fetch dari API Aladhan
    async function loadPrayerTimes() {
        const city = 'Jakarta';
        const country = 'ID';
        const date = new Date();
        const dateStr = date.getFullYear() + '-' + String(date.getMonth() + 1).padStart(2, '0') + '-' + String(date.getDate()).padStart(2, '0');

        try {
            const response = await fetch('https://api.aladhan.com/v1/timingsByCity/' + dateStr + '?city=' + city + '&country=' + country + '&method=2');
            const data = await response.json();

            if (data.code === 200) {
                window.lastPrayerTimings = data.data.timings;
                renderPrayerTimes(data.data.timings);
                updatePrayerDate();
            }
        } catch (error) {
            console.log('Gagal memuat jadwal sholat');
        }
    }

    const prayerGrid = document.getElementById('prayer-times-grid');
    if (prayerGrid) {
        loadPrayerTimes();
        setInterval(function() {
            if (window.lastPrayerTimings) {
                renderPrayerTimes(window.lastPrayerTimings);
            }
        }, 60000);
    }

    // Smooth scroll for anchor links
    document.querySelectorAll('a[href^="#"]').forEach(anchor => {
        anchor.addEventListener('click', function(e) {
            const target = document.querySelector(this.getAttribute('href'));
            if (target) {
                e.preventDefault();
                target.scrollIntoView({ behavior: 'smooth' });
            }
        });
    });

})();
