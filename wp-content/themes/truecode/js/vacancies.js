jQuery(document).ready(function($) {
    const container = $('#cards-container');
    const slider = container.find('.cards');
    const prevBtn = container.find('.cards__control-prev');
    const nextBtn = container.find('.cards__control-next');
    let currentPage = 1;
    let totalPages = 1;

    // Загрузка постов
    function loadPosts(page) {
        $.ajax({
            url: slider_vars.rest_url,
            method: 'GET',
            data: {
                per_page: 3,
                page: page,
                _embed: true
            },
            beforeSend: function(xhr) {
                xhr.setRequestHeader('X-WP-Nonce', slider_vars.nonce);
                slider.html('<div class="loading">Загрузка...</div>');
            },
            success: function(posts) {
                if (posts.length === 0) {
                    slider.html('<div class="no-posts">Нет статей для отображения</div>');
                    return;
                }

                let html = '';
                posts.forEach(function(post) {
                    let image = '';
                    if (post._embedded && post._embedded['wp:featuredmedia']) {
                        image = `<img src="${post._embedded['wp:featuredmedia'][0].source_url}" alt="${post.title.rendered}">`;
                    }

                    html += `
                        <div class="col-12 col-md-8 offset-md-2 col-lg-4 offset-lg-0">
                            <div class="card">
                                <div class="card__data">
                                    <div class="card__image">${image}</div>
                                    <h4 class="card__title">${post.title.rendered}</h3>
                                </div>
                                <div class="card__actions">
                                    <a class="button">Подробнее</a>
                                    <a class="button button--dark">Подать заявку</a>
                                </div>
                            </div>
                        </div>
                    `;
                });

                slider.html(html);
                currentPage = page;
                updateButtons();
            },
            error: function() {
                slider.html('<div class="error">Ошибка загрузки вакансий</div>');
            }
        });
    }

    // Обновление состояния кнопок
    function updateButtons() {
        prevBtn.prop('disabled', currentPage <= 1);
        nextBtn.prop('disabled', currentPage >= totalPages);
    }

    // Инициализация
    loadPosts(1);

    // Получаем общее количество страниц
    $.ajax({
        url: slider_vars.rest_url,
        method: 'GET',
        data: {
            per_page: 3,
            _fields: 'id'
        },
        beforeSend: function(xhr) {
            xhr.setRequestHeader('X-WP-Nonce', slider_vars.nonce);
        },
        success: function(data, status, xhr) {
            totalPages = parseInt(xhr.getResponseHeader('X-WP-TotalPages')) || 1;
            updateButtons();
        }
    });

    // Обработчики кнопок
    prevBtn.on('click', function() {
        if (currentPage > 1) {
            loadPosts(currentPage - 1);
        }
    });

    nextBtn.on('click', function() {
        if (currentPage < totalPages) {
            loadPosts(currentPage + 1);
        }
    });
});