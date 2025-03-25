<?php
/**
 * Создаем custom post type для Вакансий
 */
function create_vacancy_post_type() {
    register_post_type('vacancy',
        array(
            'labels'      => array(
                'name'          => 'Вакансии',
                'singular_name' => 'Вакансия',
                'add_new'       => 'Добавить вакансию',
                'add_new_item'  => 'Добавить новую вакансию',
                'edit_item'     => 'Редактировать вакансию',
            ),
            'public'            => true,
            'has_archive'       => true,
            'rewrite'           => array('slug' => 'vacancies'),
            'supports'          => array('title', 'editor', 'thumbnail'),
            'show_in_rest'      => true,
            'rest_base'         => 'vacancy',
            'rest_controller_class' => 'WP_REST_Posts_Controller',
            'menu_icon'         => 'dashicons-businessperson',
        )
    );
}
add_action('init', 'create_vacancy_post_type');

function register_vacancies_block() {
    register_block_type('tc/vacancies', array(
        'api_version' => 2,
        'editor_script' => 'vacancies-block-editor',
        'editor_style' => 'vacancies-block-editor',
        'style' => 'vacancies-block-frontend',
        'render_callback' => 'render_vacancies_block',
        'attributes' => array()
    ));
}
add_action('init', 'register_vacancies_block');

function render_vacancies_block($attributes) {
    $args = array(
        'post_type' => 'vacancy',
        'posts_per_page' => 3,
        'orderby' => 'date',
        'order' => 'DESC'
    );
    
    $query = new WP_Query($args);
    
    if (!$query->have_posts()) {
        return '<p>Нет доступных вакансий</p>';
    }
    
    $class = 'vacancies-block-' . esc_attr($attributes['layout']);
    $show_salary = $attributes['showSalary'];
    $show_image = $attributes['showImage'];
    
    ob_start();
    ?>
    <section class="container" id="cards-container">
        <div class="row cards">
            <?php while ($query->have_posts()) : $query->the_post(); ?>
            <div class="col-12 col-md-8 offset-md-2 col-lg-4 offset-lg-0">
                <div class="card">
                    <div class="card__data">
                        <div class="card__image"><?php the_post_thumbnail('medium'); ?></div>
                        <h4 class="card__title"><?php the_title(); ?></h3>
                    </div>
                    <div class="card__actions">
                        <a class="button">Подробнее</a>
                        <a class="button button--dark">Подать заявку</a>
                    </div>
                </div>
            </div>
            <?php endwhile; wp_reset_postdata(); ?>
        </div>
        <div class="row">
            <div class="col-12">
                <div class="cards__controls">
                    <button class="cards__control cards__control-prev" disabled>&lt;</button>
                    <button class="cards__control cards__control-next">&gt;</button>
                </div>
            </div>
        </div>
    </section>
    <?php
    return ob_get_clean();
}

function enqueue_vacancies_block() {
    wp_register_script(
        'vacancies-block-editor',
        get_template_directory_uri() . '/blocks/build/index.js',
        array('wp-blocks', 'wp-element', 'wp-editor', 'wp-components', 'wp-i18n'),
        filemtime(get_template_directory() . '/blocks/build/index.js')
    );

    register_block_type('tc/vacancies', array(
        'editor_script' => 'vacancies-block-editor',
        'render_callback' => 'render_vacancies_block'
    ));
}
add_action('init', 'enqueue_vacancies_block');

function enqueue_slider_scripts() {
    wp_enqueue_script(
        'posts-slider',
        get_template_directory_uri() . '/js/vacancies.js',
        array('jquery'),
        filemtime(get_template_directory() . '/js/vacancies.js'),
        true
    );
    
    wp_localize_script('posts-slider', 'slider_vars', array(
        'rest_url' => rest_url('wp/v2/vacancy'),
        'nonce' => wp_create_nonce('wp_rest')
    ));
}
add_action('wp_enqueue_scripts', 'enqueue_slider_scripts');