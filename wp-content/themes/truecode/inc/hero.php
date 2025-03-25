<?php
function hero_shortcode() {
    return '
    <section class="container hero">
        <div class="row">
            <div class="col-12 col-lg-6">
                <div class="hero__text">
                    <h1 class="h3">Мы открываем набор на наши огненные стажировки!</h1>
                    <p>Присоединяйся к нашей дружной команде и начни свой путь в мире digital.</p>
                </div>
            </div>
            <div class="col-6 hero__images d-none d-lg-block">
                <div class="hero__image1"><img src="/wp-content/themes/truecode/assets/images/hero1.png" /></div>
                <div class="hero__image2"><img src="/wp-content/themes/truecode/assets/images/hero2.gif" /></div>
            </div>
        </div>
    </section>
    ';
}
add_shortcode('hero', 'hero_shortcode');