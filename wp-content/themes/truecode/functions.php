<?php

require_once get_template_directory() . "/inc/general_settings.php";
require_once get_template_directory() . "/inc/svg_upload.php";
require_once get_template_directory() . "/inc/menu.php";
require_once get_template_directory() . "/inc/hero.php";
require_once get_template_directory() . "/inc/vacancy.php";
require_once get_template_directory() . "/inc/form.php";

function tc_setup() {
    add_theme_support('title-tag');
    add_theme_support('post-thumbnails');
}
add_action('after_setup_theme', 'tc_setup');


function tc_scripts() {
    wp_enqueue_style('tc-style', get_stylesheet_uri());
}
add_action('wp_enqueue_scripts', 'tc_scripts');