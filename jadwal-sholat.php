<?php
/**
 * Template Name: Jadwal Sholat
 * Template Post Type: page
 */

get_header(); ?>

<div class="jadwal-sholat-wrap">
  <div class="container">

    <div class="page-header-section">
      <h1><?php _e('Jadwal Sholat & Imsakiyah', 'alkautsar'); ?></h1>
      <p><?php _e('Masjid Al-Kautsar Rusunawa Green Jagakarsa', 'alkautsar'); ?></p>
      <div class="header-divider"></div>
    </div>

    <!-- Waktu Sholat Hari Ini -->
    <div class="prayer-today-section">
      <div class="prayer-today-header">
        <div>
          <h2>&#x23F0; <?php _e('Waktu Sholat Hari Ini', 'alkautsar'); ?></h2>
          <p id="jadwal-date"><?php _e('Memuat...', 'alkautsar'); ?></p>
        </div>
        <div class="prayer-location-badge">
          &#x1F4CD; <?php _e('Jagakarsa, Jakarta Selatan', 'alkautsar'); ?>
        </div>
      </div>
      <div class="prayer-today-grid" id="jadwal-today-grid">
        <div class="prayer-loading"><?php _e('Memuat jadwal sholat...', 'alkautsar'); ?></div>
      </div>
      <div class="prayer-next-info" id="jadwal-next-info"></div>
    </div>

    <!-- Tabel Jadwal Bulanan -->
    <div class="prayer-monthly-section">
      <div class="monthly-header">
        <h2>&#x1F4C5; <?php _e('Jadwal Bulanan', 'alkautsar'); ?></h2>
        <div class="month-nav">
          <button id="prev-month" class="month-btn">&larr; <?php _e('Sebelumnya', 'alkautsar'); ?></button>
          <span id="current-month-label" class="month-label"><?php _e('Memuat...', 'alkautsar'); ?></span>
          <button id="next-month" class="month-btn"><?php _e('Selanjutnya', 'alkautsar'); ?> &rarr;</button>
        </div>
      </div>
      <div class="monthly-table-wrap">
        <table class="prayer-monthly-table" id="prayer-monthly-table">
          <thead>
            <tr>
              <th><?php _e('Tanggal', 'alkautsar'); ?></th>
              <th><?php _e('Imsak', 'alkautsar'); ?></th>
              <th><?php _e('Subuh', 'alkautsar'); ?></th>
              <th><?php _e('Terbit', 'alkautsar'); ?></th>
              <th><?php _e('Dzuhur', 'alkautsar'); ?></th>
              <th><?php _e('Ashar', 'alkautsar'); ?></th>
              <th><?php _e('Maghrib', 'alkautsar'); ?></th>
              <th><?php _e('Isya', 'alkautsar'); ?></th>
            </tr>
          </thead>
          <tbody id="monthly-tbody">
            <tr><td colspan="8" class="loading-cell"><?php _e('Memuat...', 'alkautsar'); ?></td></tr>
          </tbody>
        </table>
      </div>
    </div>

  </div>
</div>

<script>
const LATITUDE  = -6.3646;
const LONGITUDE = 106.8223;
const METHOD    = 11;

const BULAN_ID = ['Januari','Februari','Maret','April','Mei','Juni',
                  'Juli','Agustus','September','Oktober','November','Desember'];
const HARI_ID  = ['Minggu','Senin','Selasa','Rabu','Kamis','Jumat','Sabtu'];

let currentYear  = new Date().getFullYear();
let currentMonth = new Date().getMonth() + 1;
let lastTimings  = null;

function cleanTime(t) {
  return t ? t.split(' ')[0].substring(0,5) : '--:--';
}

function toMin(t) {
  const [h,m] = cleanTime(t).split(':').map(Number);
  return h*60 + m;
}

function updateDate() {
  const now = new Date();
  const el  = document.getElementById('jadwal-date');
  if (el) el.textContent = 
    HARI_ID[now.getDay()] + ', ' + now.getDate() + ' ' + 
    BULAN_ID[now.getMonth()] + ' ' + now.getFullYear();
}

function renderToday(timings) {
  lastTimings = timings;
  const prayers = [
    {name:'Imsak',   key:'Imsak'},
    {name:'Subuh',   key:'Fajr'},
    {name:'Terbit',  key:'Sunrise'},
    {name:'Dzuhur',  key:'Dhuhr'},
    {name:'Ashar',   key:'Asr'},
    {name:'Maghrib', key:'Maghrib'},
    {name:'Isya',    key:'Isha'},
  ];
  const now = new Date();
  const cur = now.getHours()*60 + now.getMinutes();
  
  let nextIdx = -1;
  for (let i=0; i<prayers.length; i++) {
    if (cur < toMin(timings[prayers[i].key])) { nextIdx=i; break; }
  }

  const grid = document.getElementById('jadwal-today-grid');
  if (grid) {
    grid.innerHTML = prayers.map((p,i) => {
      const t = cleanTime(timings[p.key]);
      let cls = 'pt-item';
      if (i === nextIdx) cls += ' pt-next';
      else if (nextIdx === -1 || i < nextIdx) cls += ' pt-passed';
      return '<div class="' + cls + '">' +
        '<span class="pt-name">' + p.name + '</span>' +
        '<span class="pt-time">' + t + '</span></div>';
    }).join('');
  }

  const info = document.getElementById('jadwal-next-info');
  if (info && nextIdx >= 0) {
    const next = prayers[nextIdx];
    const diff = toMin(timings[next.key]) - cur;
    const h = Math.floor(diff/60), m = diff%60;
    const countdown = h > 0 ? h + ' jam ' + m + ' menit lagi' : m + ' menit lagi';
    info.innerHTML = '\u23F0 Waktu sholat berikutnya: <strong>' + next.name + '</strong> \u2014 <span class="countdown-gold">' + countdown + '</span>';
  } else if (info) {
    info.textContent = '\u2705 Semua waktu sholat hari ini telah berlalu.';
  }
}

function fetchToday() {
  fetch('https://api.aladhan.com/v1/timingsByCity?city=Jakarta&country=Indonesia&method=' + METHOD)
    .then(r => r.json())
    .then(d => { if(d.data) renderToday(d.data.timings); })
    .catch(() => {
      const grid = document.getElementById('jadwal-today-grid');
      if (grid) grid.innerHTML = '<p class="error-msg">Gagal memuat jadwal. Periksa koneksi internet.</p>';
    });
}

function fetchMonthly(year, month) {
  const label = document.getElementById('current-month-label');
  const tbody = document.getElementById('monthly-tbody');
  if (label) label.textContent = BULAN_ID[month-1] + ' ' + year;
  if (tbody) tbody.innerHTML = '<tr><td colspan="8" class="loading-cell">Memuat...</td></tr>';

  fetch('https://api.aladhan.com/v1/calendarByCity/' + year + '/' + month + '?city=Jakarta&country=Indonesia&method=' + METHOD)
    .then(r => r.json())
    .then(d => {
      if (!d.data || !tbody) return;
      const today = new Date();
      
      tbody.innerHTML = d.data.map(function(day) {
        const t  = day.timings;
        const gr = day.date.gregorian;
        const dt = parseInt(gr.day);
        const isToday = (dt === today.getDate() && 
                         month === today.getMonth()+1 && 
                         parseInt(gr.year) === today.getFullYear());
        const rowCls = isToday ? 'today-row' : '';
        const dayName = HARI_ID[new Date(gr.year, month-1, dt).getDay()];
        const isFriday = dayName === 'Jumat';
        
        return '<tr class="' + rowCls + (isFriday ? ' friday-row' : '') + '">' +
          '<td class="date-cell">' +
            '<span class="date-num">' + dt + ' ' + BULAN_ID[month-1].substring(0,3) + '</span>' +
            '<span class="date-day">' + dayName + (isToday ? ' <span class="today-badge">Hari Ini</span>' : '') + '</span>' +
          '</td>' +
          '<td>' + cleanTime(t.Imsak) + '</td>' +
          '<td class="highlight-col">' + cleanTime(t.Fajr) + '</td>' +
          '<td>' + cleanTime(t.Sunrise) + '</td>' +
          '<td>' + cleanTime(t.Dhuhr) + '</td>' +
          '<td>' + cleanTime(t.Asr) + '</td>' +
          '<td class="highlight-col">' + cleanTime(t.Maghrib) + '</td>' +
          '<td>' + cleanTime(t.Isha) + '</td>' +
        '</tr>';
      }).join('');
    })
    .catch(() => {
      if (tbody) tbody.innerHTML = '<tr><td colspan="8" class="error-msg">Gagal memuat data.</td></tr>';
    });
}

document.getElementById('prev-month')?.addEventListener('click', function() {
  currentMonth--;
  if (currentMonth < 1) { currentMonth=12; currentYear--; }
  fetchMonthly(currentYear, currentMonth);
});
document.getElementById('next-month')?.addEventListener('click', function() {
  currentMonth++;
  if (currentMonth > 12) { currentMonth=1; currentYear++; }
  fetchMonthly(currentYear, currentMonth);
});

updateDate();
fetchToday();
fetchMonthly(currentYear, currentMonth);
setInterval(function() { if(lastTimings) renderToday(lastTimings); }, 60000);
</script>

<?php get_footer(); ?>
