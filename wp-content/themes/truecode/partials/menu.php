<header class="header">
    <div class="container header__container" id="main-menu">
        <div class="header__left">
        <?php if ( function_exists( 'the_custom_logo' ) ): ?>
            <div class="header__logo">
                <a href="<?php echo esc_url(home_url('/')); ?>"><?php the_custom_logo(); ?></a>
            </div>
        <?php endif; ?>
            <div class="header__burger" onclick="toggleMenu()">
                <div></div>
                <div></div>
                <div></div>
            </div>
        </div>

        <div class="header__right">
            <?php if ($phone = get_theme_mod('header_phone')) : ?>
                <div id="header-phone" class="header__phone" data-customize-partial-id="header_section_partial">
                    <a href="tel:<?php echo esc_attr(preg_replace('/[^0-9+]/', '', $phone)); ?>">
                        <?php echo esc_html($phone); ?>
                    </a>
                </div>
            <?php endif; ?>        

            <nav class="header__navigation">
                <?php
                wp_nav_menu(
                    array(
                        'theme_location' => 'header-menu',
                        'menu_class'     => 'header-menu',
                        'container'      => false,
                        'fallback_cb'    => false
                    )
                );
                ?>
            </nav>
        
            <div class="header__button">
                <a href="/#request" class="button">Подать заявку</a>
            </div>
        </div>

    </div><!-- /container -->
    <div class="header__mobile">
        <div class="header__mobile-container">
            <nav class="header__navigation">
                <?php
                wp_nav_menu(
                    array(
                        'theme_location' => 'header-menu',
                        'menu_class'     => 'header-menu',
                        'container'      => false,
                        'fallback_cb'    => false
                    )
                );
                ?>
            </nav>
            <div class="header__button">
                <a href="/#request" class="button">Подать заявку</a>
            </div>
            <?php if ($phone = get_theme_mod('header_phone')) : ?>
                <div id="header-phone" class="header__phone" data-customize-partial-id="header_section_partial">
                    <a href="tel:<?php echo esc_attr(preg_replace('/[^0-9+]/', '', $phone)); ?>">
                        <?php echo esc_html($phone); ?>
                    </a>
                </div>
            <?php endif; ?> 
            <?php
            $socials = wp_get_global_settings()['custom']['social-icons'];
            if ($socials):
            ?>
                <div class="footer__social">
                <?php
                foreach ($socials as $network => $image) {
                    $url = get_theme_mod("theme_social_$network");
                    if ($url) {
                        echo '<a href="' . esc_url($url) . '" target="_blank" rel="noopener noreferrer">';
                        echo '<span class="footer__social-item footer__social-item--' . $network . '"></span>';
                        echo '</a>';
                    }
                }
                ?>
                </div>
            <?php endif; ?>
        </div>
    </div>
</header>