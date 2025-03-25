<?php
/**
 * Добавляем место для Главного меню и футера
 */
function tc_register_menus() {
    register_nav_menus(
        array(
            'header-menu' => 'Меню в шапке',
            'footer-social-links' => 'Социальные сети в подвале'
        )
    );
}
add_action('init', 'tc_register_menus');

// Получаем доступные иконки из theme.json -> custom -> social-icons
function get_menu_icon_by_item_id($item_id) {
    $_menu_id = wp_get_object_terms($item_id, 'nav_menu', ['fields' => 'ids'])[0] ?? null;
    $_footer_menu_id = get_nav_menu_locations()['footer-social-links'] ?? null;

    if (!$_menu_id || !$_footer_menu_id || $_menu_id !== $_footer_menu_id) return '';

    $_icon = get_post_meta($item_id, '_menu_item_icon', true);
    if (empty($_icon)) return '';

    $_icon_data = wp_get_global_settings()['custom']['social-icons'][$_icon] ?? [];

    if (empty($_icon_data)) return '';

    if (!preg_match('/^[a-z0-9\-_]+.svg$/i', $_icon_data['filename'])) {
        return '';
    }

    $_file_path = get_theme_file_path("/assets/svg/" . $_icon_data['filename']);

    if (!file_exists($_file_path)) {
        //error_log("SVG not found: {$filename}.svg");
        return '';
    }

    $_svg_content = file_get_contents($_file_path);

    return $_svg_content ?: "";
}

class Custom_Menu_Walker extends Walker_Nav_Menu {
    function start_el(&$output, $item, $depth = 0, $args = null, $id = 0) {
        $iconSVG = get_menu_icon_by_item_id($item->ID);

        $output .= '<li class="menu-item">';
        $output .= '<a href="' . $item->url . '">';
        $output .= $iconSVG ?? $item->title;
        $output .= '</a>';
    }
}

add_filter('wp_nav_menu_item_custom_fields', 'add_custom_menu_field', 10, 4);
function add_custom_menu_field($item_id, $item, $depth, $args) {
    $_menu_id = wp_get_object_terms($item_id, 'nav_menu', ['fields' => 'ids'])[0] ?? null;
    $_footer_menu_id = get_nav_menu_locations()['footer-social-links'] ?? null;

    if (!$_menu_id || !$_footer_menu_id || $_menu_id !== $_footer_menu_id) return;

    $_icon = get_post_meta($item_id, '_menu_item_icon', true);
    $_icons = wp_get_global_settings()['custom']['social-icons'] ?? [];
    ?>
    <p class="field-icon description description-wide">
        <label for="edit-menu-item-icon-<?php echo $item_id; ?>">
            Иконка "Социальные сети"<br>
            <select name="menu_item_icon[<?php echo $item_id; ?>]"
                id="edit-menu-item-icon-<?php echo $item_id; ?>">
                <option>Нет иконки</option>
                <?php
                foreach ($_icons as $k => $v) {
                    echo "<option value={$k}" . ($k === $_icon ? " selected" : "") . ">{$v['title']}</option>";
                }
                ?>
            </select>
        </label>
    </p>
    <?php
}

add_action('wp_update_nav_menu_item', 'save_custom_menu_field', 10, 3);
function save_custom_menu_field($menu_id, $menu_item_db_id, $args) {
    if (isset($_POST['menu_item_icon'][$menu_item_db_id])) {
        update_post_meta($menu_item_db_id, '_menu_item_icon', sanitize_text_field($_POST['menu_item_icon'][$menu_item_db_id]));
    }
}