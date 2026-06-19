<?php
if (!function_exists('acf_add_local_field_group')) {
    return;
}

acf_add_local_field_group(array(
    'key'    => 'group_alk_program',
    'title'  => __('Detail Program', 'alkautsar'),
    'fields' => array(
        array(
            'key'   => 'field_alk_program_schedule',
            'label' => __('Jadwal Pelaksanaan', 'alkautsar'),
            'name'  => 'program_schedule',
            'type'  => 'text',
            'instructions' => __('Contoh: "Setiap Hari Ahad, 08:00-10:00"', 'alkautsar'),
            'placeholder' => 'Setiap Hari Ahad, 08:00-10:00',
        ),
        array(
            'key'   => 'field_alk_program_status',
            'label' => __('Status', 'alkautsar'),
            'name'  => 'program_status',
            'type'  => 'select',
            'choices' => array(
                'aktif'    => __('Aktif', 'alkautsar'),
                'nonaktif' => __('Nonaktif', 'alkautsar'),
            ),
            'default_value' => 'aktif',
        ),
    ),
    'location' => array(
        array(
            array(
                'param'    => 'post_type',
                'operator' => '==',
                'value'    => 'program',
            ),
        ),
    ),
));

acf_add_local_field_group(array(
    'key'    => 'group_alk_kegiatan',
    'title'  => __('Detail Kegiatan', 'alkautsar'),
    'fields' => array(
        array(
            'key'   => 'field_alk_kegiatan_date',
            'label' => __('Tanggal', 'alkautsar'),
            'name'  => 'kegiatan_date',
            'type'  => 'date_picker',
            'display_format' => 'd F Y',
            'return_format'  => 'Y-m-d',
        ),
        array(
            'key'   => 'field_alk_kegiatan_time',
            'label' => __('Waktu', 'alkautsar'),
            'name'  => 'kegiatan_time',
            'type'  => 'text',
            'instructions' => __('Format jam, contoh: 08:00 - 10:00', 'alkautsar'),
            'placeholder' => '08:00 - 10:00',
        ),
        array(
            'key'   => 'field_alk_kegiatan_location',
            'label' => __('Lokasi', 'alkautsar'),
            'name'  => 'kegiatan_location',
            'type'  => 'text',
            'placeholder' => 'Masjid Al-Kautsar / Aula Serbaguna',
        ),
    ),
    'location' => array(
        array(
            array(
                'param'    => 'post_type',
                'operator' => '==',
                'value'    => 'kegiatan',
            ),
        ),
    ),
));

acf_add_local_field_group(array(
    'key'    => 'group_alk_laporan_keuangan',
    'title'  => __('Detail Laporan Keuangan', 'alkautsar'),
    'fields' => array(
        array(
            'key'   => 'field_alk_keuangan_amount',
            'label' => __('Jumlah (Rp)', 'alkautsar'),
            'name'  => 'keuangan_amount',
            'type'  => 'number',
            'min'   => 0,
            'placeholder' => '100000',
        ),
        array(
            'key'   => 'field_alk_keuangan_type',
            'label' => __('Tipe', 'alkautsar'),
            'name'  => 'keuangan_type',
            'type'  => 'select',
            'choices' => array(
                'masuk'  => __('MASUK', 'alkautsar'),
                'keluar' => __('KELUAR', 'alkautsar'),
            ),
        ),
        array(
            'key'   => 'field_alk_keuangan_date',
            'label' => __('Tanggal Transaksi', 'alkautsar'),
            'name'  => 'keuangan_date',
            'type'  => 'date_picker',
            'display_format' => 'd F Y',
            'return_format'  => 'Y-m-d',
        ),
    ),
    'location' => array(
        array(
            array(
                'param'    => 'post_type',
                'operator' => '==',
                'value'    => 'laporan_keuangan',
            ),
        ),
    ),
));

acf_add_local_field_group(array(
    'key'    => 'group_alk_beneficiary',
    'title'  => __('Detail Penerima Manfaat', 'alkautsar'),
    'fields' => array(
        array(
            'key'   => 'field_alk_beneficiary_count',
            'label' => __('Jumlah Penerima', 'alkautsar'),
            'name'  => 'beneficiary_count',
            'type'  => 'number',
            'min'   => 0,
            'placeholder' => '0',
        ),
    ),
    'location' => array(
        array(
            array(
                'param'    => 'post_type',
                'operator' => '==',
                'value'    => 'beneficiary',
            ),
        ),
    ),
));
