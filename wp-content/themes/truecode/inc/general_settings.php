<?php
/**
 * Добавляем поле "Телефон" в настройки сайта
 */
function tc_add_phone_setting() {
    register_setting('general', 'site_phone', 'sanitize_text_field');

    add_settings_field(
        'site_phone',
        'Телефон сайта',
        'tc_phone_setting_callback',
        'general'
    );
}
add_action('admin_init', 'tc_add_phone_setting');

function tc_phone_setting_callback() {
    $phone = get_option('site_phone');
    echo '<input type="text" name="site_phone" id="site_phone" value="' . esc_attr($phone) . '" class="regular-text" placeholder="+7 (XXX) XXX-XX-XX">';
    echo '<p class="description">Укажите телефон для связи (будет использоваться в шапке, подвале и т.д.)</p>';
}

function tc_customize_register($wp_customize) {
    $wp_customize->add_section('tc_contact_info', array(
        'title'    => 'Контактная информация',
        'priority' => 30,
    ));

    $wp_customize->add_setting('tc_phone_number', array(
        'default'   => '',
        'transport' => 'refresh',
        'sanitize_callback' => 'sanitize_text_field'
    ));

    $wp_customize->add_control('tc_phone_number', array(
        'label'    => 'Телефон',
        'section'  => 'tc_contact_info',
        'type'     => 'text',
    ));
}
add_action('customize_register', 'tc_customize_register');

function tc_social_customizer($wp_customize) {
    $wp_customize->add_section('theme_social_section', array(
        'title'    => __('Социальные сети', 'text-domain'),
        'capability' => 'edit_theme_options',
        'priority' => 120,
    ));

    // Массив социальных сетей
    $social_networks = array(
        'vk' => 'VK',
        'fb' => 'Facebook',
        'in' => 'Instagram'
    );

    // Добавляем поля для каждой сети
    foreach ($social_networks as $slug => $name) {
        $wp_customize->add_setting("theme_social_$slug", array(
            'default'   => '',
            'transport' => 'refresh',
            'sanitize_callback' => 'esc_url_raw'
        ));

        $wp_customize->add_control("theme_social_$slug", array(
            'label'    => sprintf(__('%s URL', 'text-domain'), $name),
            'section'  => 'theme_social_section',
            'type'     => 'url',
        ));
    }
}
add_action('customize_register', 'tc_social_customizer');

function tc_customizer_settings($wp_customize) {
    $wp_customize->add_section('theme_header_section', [
        'title'       => 'Шапка сайта', 'text-domain',
        'priority'    => 30,
        'description' => 'Настройки верхней части сайта',
    ]);
    
    $wp_customize->add_setting('header_phone', [
        'default'           => '',
        'transport'         => 'postMessage',
        'sanitize_callback' => 'sanitize_text_field'
    ]);
    
    $wp_customize->add_control('header_phone', [
        'label'   => 'Телефон',
        'section' => 'tc_header_section',
        'type'    => 'text'
    ]);
    
    $wp_customize->selective_refresh->add_partial('header_section_partial', [
        'selector'            => '.site-header',
        'settings'            => ['header_phone'],
        'render_callback'     => 'tc_render_header',
        'container_inclusive' => true,
        'fallback_refresh'    => false
    ]);
}
add_action('customize_register', 'tc_customizer_settings');

// function tc_render_header() {
//     get_template_part('template-parts/header');
// }

add_theme_support( 'custom-logo' );
function tc_custom_logo_setup() {
	$defaults = array(
		'height'               => 100,
		'width'                => 400,
		'flex-height'          => true,
		'flex-width'           => true,
		'header-text'          => array( 'site-title', 'site-description' ),
		'unlink-homepage-logo' => true, 
	);
	add_theme_support( 'custom-logo', $defaults );
}
add_action( 'after_setup_theme', 'tc_custom_logo_setup' );