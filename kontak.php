<?php
/**
 * Template Name: Kontak
 * Template Post Type: page
 */
get_header(); ?>

<div class="kontak-wrap">
  <div class="container">

    <div class="page-header-section">
      <h1>&#x1F4DE; Kontak</h1>
      <p>Hubungi kami untuk informasi lebih lanjut</p>
      <div class="header-divider"></div>
    </div>

    <div class="kontak-layout">

      <!-- Info Kontak -->
      <div class="kontak-info-section">
        
        <div class="kontak-card">
          <h2>&#x1F4CD; Alamat</h2>
          <p><?php echo esc_html(get_theme_mod('alk_address', 
            'Jl. Margasatwa Raya No.V, Jagakarsa, Kec. Jagakarsa, Kota Jakarta Selatan, Daerah Khusus Ibukota Jakarta 12450')); ?>
          </p>
        </div>

        <div class="kontak-items">
          <div class="kontak-item">
            <span class="kontak-icon">&#x1F4F1;</span>
            <div>
              <div class="kontak-label">WhatsApp / Telepon</div>
              <a href="tel:<?php echo get_theme_mod('alk_phone', '082123232071'); ?>" 
                 class="kontak-value">
                <?php echo get_theme_mod('alk_phone', '082123232071'); ?>
              </a>
            </div>
          </div>
          <div class="kontak-item">
            <span class="kontak-icon">&#x2709;&#xFE0F;</span>
            <div>
              <div class="kontak-label">Email</div>
              <a href="mailto:info@masjid-alkautsar.my.id" 
                 class="kontak-value">
                info@masjid-alkautsar.my.id
              </a>
            </div>
          </div>
          <div class="kontak-item">
            <span class="kontak-icon">&#x1F550;</span>
            <div>
              <div class="kontak-label">Jam Operasional</div>
              <span class="kontak-value">
                Setiap hari, 05:00 - 22:00 WIB
              </span>
            </div>
          </div>
        </div>

        <!-- Sosial Media -->
        <div class="sosmed-section">
          <h3>Ikuti Kami</h3>
          <div class="sosmed-grid">
            <a href="#" class="sosmed-btn fb">&#x1F4D8; Facebook</a>
            <a href="#" class="sosmed-btn ig">&#x1F4F8; Instagram</a>
            <a href="#" class="sosmed-btn yt">&#x25B6;&#xFE0F; YouTube</a>
            <a href="https://wa.me/6282123232071" 
               target="_blank" class="sosmed-btn wa">
              &#x1F4AC; WhatsApp
            </a>
          </div>
        </div>

      </div>

      <!-- Google Maps -->
      <div class="kontak-maps-section">
        <h2>&#x1F5FA;&#xFE0F; Lokasi</h2>
        <div class="maps-embed">
          <iframe 
            src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3965.4!2d106.8223!3d-6.3646!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x0%3A0x0!2zNsKwMjEnNTIuNiJTIDEwNsKwNDknMjAuMyJF!5e0!3m2!1sen!2sid!4v1234567890"
            width="100%" 
            height="400" 
            style="border:0; border-radius:12px;" 
            allowfullscreen="" 
            loading="lazy">
          </iframe>
        </div>
        <a href="https://maps.google.com/?q=-6.3646,106.8223" 
           target="_blank" class="btn-maps">
          &#x1F5FA;&#xFE0F; Buka di Google Maps
        </a>
      </div>

    </div>

  </div>
</div>

<?php get_footer(); ?>
