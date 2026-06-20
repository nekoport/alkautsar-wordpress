<?php
/**
 * Template Name: Profil
 * Template Post Type: page
 */
get_header(); ?>

<div class="profil-wrap">
  <div class="container">

    <div class="page-header-section">
      <h1>Profil Masjid Al-Kautsar</h1>
      <p>Rusunawa Green Jagakarsa, Jakarta Selatan</p>
      <div class="header-divider"></div>
    </div>

    <!-- Tabs Navigasi -->
    <div class="profil-tabs">
      <button class="tab-btn active" data-tab="sejarah">&#x1F4DC; Sejarah</button>
      <button class="tab-btn" data-tab="visi-misi">&#x1F3AF; Visi & Misi</button>
      <button class="tab-btn" data-tab="pengurus">&#x1F465; Pengurus DKM</button>
    </div>

    <!-- Tab Sejarah -->
    <div class="tab-content active" id="tab-sejarah">
      <div class="profil-content-card">
        <h2>&#x1F4DC; Sejarah Masjid</h2>
        <div class="profil-text">
          <p>Masjid Al-Kautsar berdiri di lingkungan Rusunawa Green Jagakarsa, 
          Jakarta Selatan. Masjid ini menjadi pusat ibadah, pendidikan, dan 
          pemberdayaan masyarakat bagi warga rusunawa dan sekitarnya.</p>
          <p>Sejak berdiri, Masjid Al-Kautsar telah aktif menyelenggarakan 
          berbagai program keislaman, sosial, dan pendidikan untuk membangun 
          komunitas yang berkah, modern, dan bermanfaat bagi semua kalangan.</p>
        </div>
      </div>
    </div>

    <!-- Tab Visi Misi -->
    <div class="tab-content" id="tab-visi-misi">
      <div class="profil-content-card">
        <div class="visi-misi-grid">
          <div class="visi-card">
            <div class="vm-icon">&#x1F31F;</div>
            <h3>Visi</h3>
            <p>Menjadi masjid yang memakmurkan umat, pusat pendidikan Islam, 
            dan pemberdayaan masyarakat Rusunawa Green Jagakarsa yang 
            berkah, modern, dan bermanfaat untuk semua.</p>
          </div>
          <div class="misi-card">
            <div class="vm-icon">&#x1F3AF;</div>
            <h3>Misi</h3>
            <ul>
              <li>Menyelenggarakan ibadah yang tertib dan khusyuk</li>
              <li>Mengelola program pendidikan Islam yang berkualitas</li>
              <li>Mewujudkan transparansi pengelolaan donasi dan zakat</li>
              <li>Membangun silaturahmi antar jamaah dan warga sekitar</li>
              <li>Memberdayakan ekonomi umat melalui program sosial</li>
            </ul>
          </div>
        </div>
      </div>
    </div>

    <!-- Tab Pengurus -->
    <div class="tab-content" id="tab-pengurus">
      <div class="profil-content-card">
        <h2>&#x1F465; Struktur Pengurus DKM</h2>
        <div class="pengurus-grid">
          <?php
          $pengurus = array(
            array('jabatan'=>'Ketua DKM', 'nama'=>'H. Ahmad Fauzi', 'icon'=>'&#x1F468;&#x200D;&#x1F4BC;'),
            array('jabatan'=>'Wakil Ketua', 'nama'=>'Ustadz Mahmud', 'icon'=>'&#x1F468;&#x200D;&#x1F4BC;'),
            array('jabatan'=>'Sekretaris', 'nama'=>'Budi Santoso', 'icon'=>'&#x1F468;&#x200D;&#x1F4BC;'),
            array('jabatan'=>'Bendahara', 'nama'=>'Hj. Fatimah', 'icon'=>'&#x1F469;&#x200D;&#x1F4BC;'),
            array('jabatan'=>'Humas', 'nama'=>'Reza Pratama', 'icon'=>'&#x1F468;&#x200D;&#x1F4BC;'),
            array('jabatan'=>'Seksi Ibadah', 'nama'=>'Ustadz Rahman', 'icon'=>'&#x1F468;&#x200D;&#x1F4BC;'),
          );
          foreach ($pengurus as $p): ?>
          <div class="pengurus-card">
            <div class="pengurus-avatar">
              <span><?php echo $p['icon']; ?></span>
            </div>
            <div class="pengurus-info">
              <div class="pengurus-jabatan"><?php echo $p['jabatan']; ?></div>
              <div class="pengurus-nama"><?php echo $p['nama']; ?></div>
            </div>
          </div>
          <?php endforeach; ?>
        </div>
        <p class="pengurus-note">
          * Data pengurus dapat diperbarui oleh admin melalui panel administrasi
        </p>
      </div>
    </div>

  </div>
</div>

<script>
document.querySelectorAll('.tab-btn').forEach(btn => {
  btn.addEventListener('click', function() {
    document.querySelectorAll('.tab-btn').forEach(b => b.classList.remove('active'));
    document.querySelectorAll('.tab-content').forEach(c => c.classList.remove('active'));
    this.classList.add('active');
    document.getElementById('tab-' + this.dataset.tab).classList.add('active');
  });
});
</script>

<?php get_footer(); ?>
