<?php
/**
 * Разрешить загрузку SVG файлов
 */
function cc_mime_types($mimes) {
    $mimes['svg'] = 'image/svg+xml';
    return $mimes;
}
add_filter('upload_mimes', 'cc_mime_types');

function fix_svg_thumb_display() {
    echo '<style>
        td.media-icon img[src$=".svg"], 
            img[src$=".svg"].attachment-post-thumbnail {
            width: 100% !important;
            height: auto !important;
        }
    </style>';
}
add_action('admin_head', 'fix_svg_thumb_display');

function sanitize_svg($file) {
    if ($file['type'] == 'image/svg+xml') {
        $svg_content = file_get_contents($file['tmp_name']);
        if (strpos($svg_content, '<script') !== false) {
            $file['error'] = 'SVG содержит скрипты - загрузка запрещена';
         }
    }
    return $file;
}
add_filter('wp_handle_upload_prefilter', 'sanitize_svg');