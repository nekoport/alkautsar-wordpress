<?php
function alk_tanggal_indo() {
    $bulan = array(
        '01'=>'Januari','02'=>'Februari','03'=>'Maret','04'=>'April','05'=>'Mei','06'=>'Juni',
        '07'=>'Juli','08'=>'Agustus','09'=>'September','10'=>'Oktober','11'=>'November','12'=>'Desember'
    );
    return get_the_date('d') . ' ' . $bulan[get_the_date('m')] . ' ' . get_the_date('Y');
}

function alk_tanggal_acf_indo($date_string) {
    if (!$date_string) return '';
    $bulan = array(
        '01'=>'Januari','02'=>'Februari','03'=>'Maret','04'=>'April','05'=>'Mei','06'=>'Juni',
        '07'=>'Juli','08'=>'Agustus','09'=>'September','10'=>'Oktober','11'=>'November','12'=>'Desember'
    );
    $parts = explode('-', $date_string);
    if (count($parts) !== 3) return $date_string;
    return $parts[2] . ' ' . $bulan[$parts[1]] . ' ' . $parts[0];
}

function alk_get_upcoming_events($count = 3) {
    $events = array();
    $query = new WP_Query(array(
        'post_type'      => 'kegiatan',
        'posts_per_page' => $count,
        'meta_key'       => 'kegiatan_date',
        'orderby'        => 'meta_value',
        'order'          => 'ASC',
        'meta_query'     => array(
            array(
                'key'     => 'kegiatan_date',
                'value'   => current_time('Y-m-d'),
                'compare' => '>=',
                'type'    => 'DATE',
            ),
        ),
    ));

    if ($query->have_posts()) {
        while ($query->have_posts()) {
            $query->the_post();
            $date = get_field('kegiatan_date');
            $events[] = array(
                'title' => get_the_title(),
                'date'  => alk_tanggal_acf_indo($date),
                'desc'  => get_the_excerpt(),
            );
        }
        wp_reset_postdata();
    }

    return $events;
}

function alk_breadcrumb() {
    if (is_front_page()) return;
    echo '<nav class="breadcrumb" style="margin-bottom:20px;font-size:0.85rem;color:var(--color-text-light);">';
    echo '<a href="' . esc_url(home_url('/')) . '" style="color:var(--color-gold);">' . __('Beranda', 'alkautsar') . '</a>';

    if (is_single()) {
        echo ' <span style="margin:0 8px;">/</span> ';
        $categories = get_the_category();
        if (!empty($categories)) {
            echo '<a href="' . esc_url(get_category_link($categories[0]->term_id)) . '" style="color:var(--color-gold);">' . esc_html($categories[0]->name) . '</a>';
        }
        echo ' <span style="margin:0 8px;">/</span> ';
        the_title('<span>', '</span>');
    } elseif (is_page()) {
        echo ' <span style="margin:0 8px;">/</span> ';
        the_title('<span>', '</span>');
    } elseif (is_category()) {
        echo ' <span style="margin:0 8px;">/</span> ';
        single_cat_title('<span>', '</span>');
    } elseif (is_search()) {
        echo ' <span style="margin:0 8px;">/</span> ';
        echo '<span>' . sprintf(__('Hasil Pencarian: %s', 'alkautsar'), get_search_query()) . '</span>';
    } elseif (is_archive()) {
        echo ' <span style="margin:0 8px;">/</span> ';
        the_archive_title('<span>', '</span>');
    }

    echo '</nav>';
}
