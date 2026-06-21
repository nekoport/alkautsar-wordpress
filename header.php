<!DOCTYPE html>
<html <?php language_attributes(); ?>>
<head>
    <meta charset="<?php bloginfo('charset'); ?>">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <?php wp_head(); ?>
</head>
<body <?php body_class(); ?>>
<?php wp_body_open(); ?>

<div id="page" class="site">

    <header id="masthead" class="site-header">
        <div class="header-inner">
            <div class="site-branding">
                <div class="site-logo">
                    <?php if (has_custom_logo()) : ?>
                        <?php the_custom_logo(); ?>
                    <?php else : ?>
                        <img src="<?php echo ALK_THEME_URI; ?>/assets/images/logo-placeholder.svg" alt="<?php bloginfo('name'); ?>">
                    <?php endif; ?>
                </div>
                <div class="site-title">
                    <a href="<?php echo esc_url(home_url('/')); ?>" rel="home">
                        <?php bloginfo('name'); ?>
                        <span><?php echo esc_html(get_theme_mod('alk_subtitle', __('Masjid Al-Kautsar', 'alkautsar'))); ?></span>
                    </a>
                </div>
            </div>

            <nav id="site-navigation" class="main-navigation">
                <?php
                wp_nav_menu(array(
                    'theme_location' => 'primary',
                    'container'      => false,
                    'menu_class'     => 'primary-menu',
                    'fallback_cb'    => 'alk_fallback_menu',
                    'depth'          => 2,
                ));
                ?>

                <div class="nav-actions">
                    <button class="search-toggle" aria-label="Search" onclick="toggleSearch()">
                        &#128269;
                    </button>
                    <button class="dark-mode-toggle" aria-label="Toggle Dark Mode" onclick="toggleDarkMode()">
                        <span class="dark-icon">&#9790;</span>
                        <span class="light-icon" style="display:none;">&#9728;</span>
                    </button>
                </div>
            </nav>

            <button class="menu-toggle" onclick="toggleMenu()" aria-label="Toggle Menu">
                <span></span>
                <span></span>
                <span></span>
            </button>
        </div>

        <?php
        $bank = get_theme_mod('alk_bank_name', 'Bank Muamalat');
        $rek = get_theme_mod('alk_rekening', '010 235 692 (147)');
        $an = get_theme_mod('alk_atas_nama', 'Masjid Al-Kautsar Green Jagakarsa');
        ?>
        <div class="donation-banner">
            <div class="container">
                <div class="donation-banner-inner">
                    <span class="donation-banner-icon">&#x1F932;</span>
                    <div class="donation-banner-text">
                        <strong><?php _e('Salurkan Donasi', 'alkautsar'); ?></strong>
                        <span><?php echo esc_html($bank); ?> &middot; <?php echo esc_html($rek); ?> &middot; a.n. <?php echo esc_html($an); ?></span>
                    </div>
                    <a href="<?php echo esc_url(home_url('/donasi')); ?>" class="btn btn-white-outline"><?php _e('Donasi Sekarang', 'alkautsar'); ?></a>
                </div>
            </div>
        </div>
    </header>

    <div class="search-overlay" id="searchOverlay">
        <button class="search-close" onclick="toggleSearch()">&times;</button>
        <div class="search-overlay-inner">
            <form role="search" method="get" action="<?php echo esc_url(home_url('/')); ?>">
                <input type="search" placeholder="<?php esc_attr_e('Cari berita, program, atau konten...', 'alkautsar'); ?>" value="<?php echo esc_attr(get_search_query()); ?>" name="s" />
                <button type="submit"><?php _e('Cari', 'alkautsar'); ?></button>
            </form>
        </div>
    </div>

    <div id="content" class="site-content">
