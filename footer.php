    </div>

    <footer id="colophon" class="site-footer">
        <div class="container">
            <div class="footer-grid">
                <div class="footer-col">
                    <h4><?php bloginfo('name'); ?></h4>
                    <p><?php echo esc_html(get_theme_mod('alk_footer_desc', __('Masjid Al-Kautsar Rusunawa Green Jagakarsa. Menjadi pusat ibadah, pendidikan, dan pemberdayaan masyarakat yang islami, modern, dan berkah.', 'alkautsar'))); ?></p>
                    <div class="footer-social">
                        <a href="#" aria-label="Facebook">FB</a>
                        <a href="#" aria-label="Instagram">IG</a>
                        <a href="#" aria-label="YouTube">YT</a>
                        <a href="#" aria-label="WhatsApp">WA</a>
                    </div>
                </div>

                <div class="footer-col">
                    <h4><?php _e('Menu', 'alkautsar'); ?></h4>
                    <?php
                    wp_nav_menu(array(
                        'theme_location' => 'footer',
                        'container'      => false,
                        'depth'          => 1,
                        'fallback_cb'    => false,
                    ));
                    ?>
                </div>

                <div class="footer-col">
                    <h4><?php _e('Program Masjid', 'alkautsar'); ?></h4>
                    <ul>
                        <li><a href="#"><?php _e('Pengajian Rutin', 'alkautsar'); ?></a></li>
                        <li><a href="#"><?php _e('TPQ / TPA', 'alkautsar'); ?></a></li>
                        <li><a href="#"><?php _e('Sosial & Zakat', 'alkautsar'); ?></a></li>
                        <li><a href="#"><?php _e('Kajian Fiqih', 'alkautsar'); ?></a></li>
                        <li><a href="#"><?php _e('Majelis Taklim', 'alkautsar'); ?></a></li>
                    </ul>
                </div>

                <div class="footer-col">
                    <h4><?php _e('Kontak', 'alkautsar'); ?></h4>
                    <div class="footer-contact-item">
                        <span class="icon">&#128205;</span>
                        <span><?php echo esc_html(get_theme_mod('alk_address', __('Rusunawa Green Jagakarsa, Jakarta Selatan', 'alkautsar'))); ?></span>
                    </div>
                    <div class="footer-contact-item">
                        <span class="icon">&#128222;</span>
                        <span><?php echo esc_html(get_theme_mod('alk_phone', __('021-12345678', 'alkautsar'))); ?></span>
                    </div>
                    <div class="footer-contact-item">
                        <span class="icon">&#9993;</span>
                        <span><?php echo esc_html(get_theme_mod('alk_email', __('info@masjid-alkautsar.my.id', 'alkautsar'))); ?></span>
                    </div>
                </div>
            </div>

            <div class="footer-bottom">
                <span>&copy; <?php echo date('Y'); ?> <?php bloginfo('name'); ?>. <?php _e('All rights reserved.', 'alkautsar'); ?></span>
                <span><?php _e('Dikembangkan dengan oleh Pengurus Masjid', 'alkautsar'); ?></span>
            </div>
        </div>
    </footer>

</div>

<?php wp_footer(); ?>
</body>
</html>
