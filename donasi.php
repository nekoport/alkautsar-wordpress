<?php
/**
 * Template Name: Halaman Donasi
 * Template Post Type: page
 */
get_header(); ?>

<div class="donasi-wrap">
  <div class="container">

    <div class="page-header-section">
      <h1>&#x1F49D; Donasi</h1>
      <p>Salurkan donasi, infaq, dan sedekah Anda untuk 
      kemakmuran Masjid Al-Kautsar</p>
      <div class="header-divider"></div>
    </div>

    <?php
    $bank = get_theme_mod('alk_bank_name', 'Bank Muamalat');
    $rek  = get_theme_mod('alk_rekening', '3010 235 692 (147)');
    $an   = get_theme_mod('alk_atas_nama', 'Masjid Al-Kautsar Green Jagakarsa');
    $qris = get_theme_mod('alk_qris_image', '');
    ?>

    <div class="donasi-layout">
      
      <!-- Transfer Bank -->
      <div class="donasi-bank-card">
        <div class="donasi-card-header">
          <span class="donasi-card-icon">&#x1F3E6;</span>
          <h2>Transfer Bank</h2>
        </div>
        <div class="bank-detail">
          <div class="bank-name-row">
            <span class="bank-label">Bank</span>
            <strong class="bank-value">
              <?php echo esc_html($bank); ?>
            </strong>
          </div>
          <div class="rekening-display">
            <span class="rek-label">Nomor Rekening</span>
            <div class="rek-number-box">
              <span id="rek-number">
                <?php echo esc_html($rek); ?>
              </span>
              <button onclick="copyRekening()" class="copy-btn" id="copy-btn">
                &#x1F4CB; Salin
              </button>
            </div>
          </div>
          <div class="bank-an-row">
            <span class="bank-label">Atas Nama</span>
            <strong class="bank-value">
              <?php echo esc_html($an); ?>
            </strong>
          </div>
        </div>
        <div class="donasi-note">
          <p>&#x1F4A1; Setelah transfer, konfirmasi donasi Anda via WhatsApp 
          untuk pencatatan yang akurat.</p>
          <a href="https://wa.me/<?php echo get_theme_mod('alk_whatsapp', '6282123232071'); ?>" 
             target="_blank" class="btn-wa">
            &#x1F4F1; Konfirmasi via WhatsApp
          </a>
        </div>
      </div>

      <!-- QRIS -->
      <?php if ($qris): ?>
      <div class="donasi-qris-card">
        <div class="donasi-card-header">
          <span class="donasi-card-icon">&#x1F4F1;</span>
          <h2>Scan QRIS</h2>
        </div>
        <div class="qris-display">
          <img src="<?php echo esc_url($qris); ?>" 
               alt="QRIS Masjid Al-Kautsar"
               style="max-width:none; width:250px; height:250px; object-fit:contain;">
          <p class="qris-info">
            Scan dengan aplikasi apapun:<br>
            GoPay &middot; OVO &middot; Dana &middot; LinkAja &middot; ShopeePay &middot; 
            m-Banking &middot; dan lainnya
          </p>
        </div>
      </div>
      <?php endif; ?>

    </div>

    <!-- Jenis Donasi -->
    <div class="jenis-donasi-section">
      <h2>&#x1F9F2; Jenis Donasi yang Diterima</h2>
      <div class="jenis-grid">
        <div class="jenis-card">
          <span>&#x1F4B0;</span>
          <h3>Infaq</h3>
          <p>Sumbangan sukarela untuk operasional dan 
          program masjid</p>
        </div>
        <div class="jenis-card">
          <span>&#x2B50;</span>
          <h3>Sedekah</h3>
          <p>Sedekah untuk program sosial dan 
          penerima manfaat</p>
        </div>
        <div class="jenis-card">
          <span>&#x1F54C;</span>
          <h3>Wakaf</h3>
          <p>Wakaf untuk pembangunan dan 
          pengembangan fasilitas masjid</p>
        </div>
        <div class="jenis-card">
          <span>&#x1F4DA;</span>
          <h3>Zakat</h3>
          <p>Zakat mal dan zakat fitrah untuk 
          mustahiq yang tepat sasaran</p>
        </div>
      </div>
    </div>

    <!-- Transparansi Link -->
    <div class="transparansi-cta">
      <p>&#x1F4CA; Seluruh donasi dicatat dan dilaporkan secara transparan</p>
      <a href="<?php echo esc_url(home_url('/transparansi')); ?>" 
         class="btn-transparansi">
        Lihat Laporan Keuangan &rarr;
      </a>
    </div>

  </div>
</div>

<script>
function copyRekening() {
  const rek = document.getElementById('rek-number').textContent.trim();
  navigator.clipboard.writeText(rek).then(function() {
    const btn = document.getElementById('copy-btn');
    btn.textContent = '\u2705 Tersalin!';
    setTimeout(function() { btn.textContent = '\uD83D\uDCCB Salin'; }, 2000);
  });
}
</script>

<?php get_footer(); ?>
