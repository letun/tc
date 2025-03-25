<footer class="footer">
    <div class="container">
        <div class="footer__container">
            <div class="footer__left">
                <?php if ( function_exists( 'the_custom_logo' ) ): ?>
                <div class="footer__logo">
                    <a href="<?php echo esc_url(home_url('/')); ?>"><?php the_custom_logo(); ?></a>
                </div>
                <?php endif; ?>
            </div>
            <div class="footer__right">
                <div class="footer__contact-info">
                    <?php if ($phone = get_theme_mod('theme_phone_number')) : ?>
                        <div class="footer__phone" data-customize-partial-id="header_section_partial">
                            <a href="tel:<?php echo esc_attr(preg_replace('/[^0-9+ ]/', '', $phone)); ?>">
                                <?php echo get_theme_mod('theme_phone_number'); ?>
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
                <div class="footer__button">
                    <a href="/#request" class="button">Подать заявку</a>
                </div>
            </div>
            <small class="footer__copyright">&copy; <?php echo date('Y'); ?></small>
        </div>
    </div>
</footer>