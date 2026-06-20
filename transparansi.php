<?php
/**
 * Template Name: Transparansi
 * Template Post Type: page
 */
get_header(); ?>

<div class="transparansi-wrap">
  <div class="container">

    <div class="page-header-section">
      <h1><?php _e('Transparansi Umat', 'alkautsar'); ?></h1>
      <p><?php _e('Laporan data sebaran penerima manfaat dan keuangan sebagai bentuk pertanggungjawaban amanah donasi, infaq dan sedekah.', 'alkautsar'); ?></p>
      <div class="header-divider"></div>
    </div>

    <!-- Prinsip Akuntabilitas -->
    <div class="akuntabilitas-card">
      <div class="akuntabilitas-icon">&#x1F4CA;</div>
      <div class="akuntabilitas-content">
        <h3><?php _e('Prinsip Akuntabilitas & Keterbukaan', 'alkautsar'); ?></h3>
        <p><?php _e('Seluruh data penerima bantuan dan keuangan diverifikasi secara berkala oleh Bendahara dan Humas DKM Masjid Al-Kautsar untuk memastikan keadilan distribusi zakat, infaq, dan sedekah tepat sasaran bagi warga Rusunawa Green Jagakarsa.', 'alkautsar'); ?></p>
      </div>
    </div>

    <!-- Data Penerima Manfaat -->
    <div class="section-block">
      <h2 class="section-title-left">&#x1F465; <?php _e('Data Penerima Manfaat', 'alkautsar'); ?></h2>
      <?php
      $beneficiaries = new WP_Query(array(
        'post_type'      => 'beneficiary',
        'posts_per_page' => -1,
        'post_status'    => 'publish',
        'orderby'        => 'title',
        'order'          => 'ASC',
      ));
      if ($beneficiaries->have_posts()):
        $total = 0;
        $items = array();
        while ($beneficiaries->have_posts()): $beneficiaries->the_post();
          $count = get_field('beneficiary_count') ?: 0;
          $total += intval($count);
          $items[] = array('name' => get_the_title(), 'count' => intval($count));
        endwhile;
        wp_reset_postdata();
      ?>
      <div class="beneficiary-stats-grid">
        <?php foreach ($items as $item): ?>
        <div class="beneficiary-card">
          <div class="beneficiary-circle">
            <span class="beneficiary-number"><?php echo $item['count']; ?></span>
          </div>
          <div class="beneficiary-name"><?php echo esc_html($item['name']); ?></div>
        </div>
        <?php endforeach; ?>
      </div>
      <div class="beneficiary-total">
        <?php _e('Total Penerima Manfaat:', 'alkautsar'); ?> <strong><?php echo $total; ?> <?php _e('orang', 'alkautsar'); ?></strong>
      </div>
      <?php else: ?>
      <p class="no-data"><?php _e('Belum ada data penerima manfaat.', 'alkautsar'); ?></p>
      <?php endif; ?>
    </div>

    <!-- Laporan Keuangan -->
    <div class="section-block">
      <h2 class="section-title-left">&#x1F4B0; <?php _e('Laporan Keuangan', 'alkautsar'); ?></h2>

      <?php
      $keuangan = new WP_Query(array(
        'post_type'      => 'laporan_keuangan',
        'posts_per_page' => -1,
        'post_status'    => 'publish',
        'meta_key'       => 'keuangan_date',
        'orderby'        => 'meta_value',
        'order'          => 'DESC',
      ));

      $total_masuk  = 0;
      $total_keluar = 0;
      $transaksi    = array();

      if ($keuangan->have_posts()):
        while ($keuangan->have_posts()): $keuangan->the_post();
          $amount = floatval(get_field('keuangan_amount') ?: 0);
          $type   = get_field('keuangan_type');
          $date   = get_field('keuangan_date');
          if ($type === 'masuk') $total_masuk  += $amount;
          else                   $total_keluar += $amount;
          $transaksi[] = array(
            'title'  => get_the_title(),
            'amount' => $amount,
            'type'   => $type,
            'date'   => $date,
          );
        endwhile;
        wp_reset_postdata();
      endif;

      $saldo = $total_masuk - $total_keluar;
      ?>

      <div class="keuangan-summary">
        <div class="keuangan-card masuk">
          <div class="keuangan-label"><?php _e('TOTAL DANA MASUK', 'alkautsar'); ?></div>
          <div class="keuangan-amount">Rp <?php echo number_format($total_masuk, 0, ',', '.'); ?></div>
        </div>
        <div class="keuangan-card keluar">
          <div class="keuangan-label"><?php _e('TOTAL DANA KELUAR', 'alkautsar'); ?></div>
          <div class="keuangan-amount">Rp <?php echo number_format($total_keluar, 0, ',', '.'); ?></div>
        </div>
        <div class="keuangan-card saldo">
          <div class="keuangan-label"><?php _e('SALDO SAAT INI', 'alkautsar'); ?></div>
          <div class="keuangan-amount">Rp <?php echo number_format($saldo, 0, ',', '.'); ?></div>
        </div>
      </div>

      <?php if (!empty($transaksi)): ?>
      <div class="transaksi-table-wrap">
        <h3><?php _e('Riwayat Transaksi', 'alkautsar'); ?></h3>
        <div class="table-responsive">
          <table class="transaksi-table">
            <thead>
              <tr>
                <th><?php _e('Tanggal', 'alkautsar'); ?></th>
                <th><?php _e('Deskripsi', 'alkautsar'); ?></th>
                <th><?php _e('Tipe', 'alkautsar'); ?></th>
                <th class="text-right"><?php _e('Jumlah', 'alkautsar'); ?></th>
              </tr>
            </thead>
            <tbody>
              <?php foreach ($transaksi as $t):
                $bulan = array('01'=>'Jan','02'=>'Feb','03'=>'Mar','04'=>'Apr','05'=>'Mei','06'=>'Jun','07'=>'Jul','08'=>'Agu','09'=>'Sep','10'=>'Okt','11'=>'Nov','12'=>'Des');
                $parts = explode('-', $t['date']);
                $tgl   = isset($parts[2]) ? $parts[2] : '';
                $bln   = isset($parts[1]) ? ($bulan[$parts[1]] ?? '') : '';
                $thn   = isset($parts[0]) ? substr($parts[0], 2) : '';
                $tgl_str = $tgl . ' ' . $bln . ' ' . $thn;
              ?>
              <tr>
                <td class="tgl-cell"><?php echo $tgl_str; ?></td>
                <td><?php echo esc_html($t['title']); ?></td>
                <td><span class="tipe-badge <?php echo $t['type']; ?>"><?php echo strtoupper($t['type']); ?></span></td>
                <td class="jumlah-cell <?php echo $t['type']; ?>">Rp <?php echo number_format($t['amount'], 0, ',', '.'); ?></td>
              </tr>
              <?php endforeach; ?>
            </tbody>
          </table>
        </div>
      </div>
      <?php endif; ?>
    </div>

    <!-- Banner Donasi -->
    <div style="background:var(--color-gold); border-radius:16px; padding:1.5rem 2rem; text-align:center; margin-top:1.5rem;">
      <p style="color:#ffffff; font-size:1rem; margin:0 0 0.25rem; font-weight:600;">
        &#x1F9F2; Salurkan Donasi Anda
      </p>
      <p style="color:rgba(255,255,255,0.9); font-size:0.875rem; margin:0 0 1rem;">
        <?php echo esc_html(get_theme_mod('alk_bank_name', 'Bank Muamalat')); ?> · 
        <?php echo esc_html(get_theme_mod('alk_rekening', '3010 235 692 (147)')); ?> · 
        a.n. <?php echo esc_html(get_theme_mod('alk_atas_nama', 'Masjid Al-Kautsar Green Jagakarsa')); ?>
      </p>
      <a href="<?php echo esc_url(home_url('/donasi')); ?>" 
         style="display:inline-block; background:#ffffff; color:var(--color-gold); padding:0.6rem 2rem; border-radius:8px; font-weight:700; text-decoration:none;">
        Donasi Sekarang
      </a>
    </div>
    <!-- End Banner Donasi -->

  </div>
</div>

<?php get_footer(); ?>
