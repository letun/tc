<?php
function form_shortcode() {
    return '
    <section class="container">
        <div class="row">
            <div class="col-12 col-md-10 offset-md-1 col-lg-8 offset-lg-2 col-xl-6 offset-xl-3">
            <h2 class="h3 form__title">Заявка</h2>
            <form class="form__container">
                <input class="form__input" type="text" id="name" name="name" placeholder="Имя:" />
                
                <input class="form__input" type="text" id="contact" name="contact" placeholder="Телефон/email:" />
                
                <input class="form__input" type="text" id="internship" name="internship" placeholder="Направление стажировки:" />
                
                <input class="form__input" type="url" id="portfolio" name="portfolio" placeholder="Ссылка на портфолио:" />
                
                <span class="form__or">или</span>
                
                <label class="form__file-label">
                    <input class="form__file" type="file" name="portfolio-file">
                    <span class="form__file-text">Прикрепить файл портфолио</span>
                </label>
                
                <textarea class="form__textarea" id="about" name="about" placeholder="Расскажите о себе:" style="resize:none"></textarea>
                
                <label class="form__checkbox-label">
                    <input class="form__checkbox" type="checkbox" name="agreement">
                    <span class="form__checkbox-text">Отправляя заявку, я подтверждаю свое согласие с политикой конфиденциальности.</span>
                </label>
                
                <div class="form__action">
                    <button class="button " type="submit">Пройти стажировку</button>
                </div>
            </form>
            </div>
        </div>
    </section>
    ';
}
add_shortcode('form', 'form_shortcode');