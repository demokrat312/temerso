$(document).ready(function () {
    CrudEditModel.init();
});
const CrudEditModel = (function () {
    const modalId = 'edit_dialog';
    let $formEl;

    const modalTemplate = `
            <div class="modal fade" id="${modalId}" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
                <div class="modal-dialog modal-lg">
                    <div class="modal-content">
                        <div class="modal-header">
                            <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                            <h4 class="modal-title">{title}</h4>
                        </div>
                        <div class="modal-body">
                            {body}
                        </div>
                        <div class="modal-footer">
                            {button}
                        </div>
                    </div>
                </div>
            </div>
        `;

    const init = () => {
        console.info('edit init');
        $formEl = $('.sonata-ba-form form:first');
        initEvent();
        hideToggleTabButton();
        pageSizeScroll();
        initFileInput();
    };

    const initEvent = () => {
        $('.nav-tabs li a').on('click', () => hideToggleTabButton());
        $('.js-prev-tab').on('click', () => prevOrNextTabHandler('prev'));
        $('.js-next-tab').on('click', () => prevOrNextTabHandler('next'));
        $('.js-entity-edit').on('click', entityEdit);
        $('.sonata-collection-add').on('click', initFileInput);
        $formEl.on('submit', formOnSubmit);
    };

    const prevOrNextTabHandler = (prevOrNext) => {
        const $tab = $('.nav-tabs');
        const $newActiveLi = $tab.find('li.active')[prevOrNext]('li');

        if ($newActiveLi.length) {
            scrollTo($('body'));

            $newActiveLi.find('a').trigger('click');
        }
    };

    const hideToggleTabButton = () => {
        setTimeout(() => {
            const $tab = $('.nav-tabs');
            const $activeLi = $tab.find('li.active');

            const prev = $('.js-prev-tab');
            const next = $('.js-next-tab');

            prev.show();
            next.show();
            if (!$activeLi['prev']('li').length) prev.hide();
            if (!$activeLi['next']('li').length) next.hide();

        }, 300);
    };

    const modalByUrl = (url, options = {}) => {
        const defaultOptions = {
            method: 'GET',
            data: null,
            dataType: 'html',
        };
        options = {
            ...defaultOptions,
            ...options
        };

        $.ajax({
            type: options.method,
            url: url,
            data: options.data,
            dataType: options.dataType,
            processData: false,
            contentType: false,
            success: function (html) {
                if (typeof html === 'object') {
                    modal({...options, ...{close: true}});
                } else {
                    modal({...options, ...{body: html}});
                    Admin.shared_setup($('#' + modalId));
                }
            }
        });
    };

    // Все ссылки в выбранном элеменете подгружаются в модельное окно
    const modalLinkHandler = ($element, options) => {
        $element.find('[href]').each(function (index, linkElement) {
            const $link = $(linkElement);
            if ($link.attr('href').includes('/')) {
                $link.click((event) => {
                    event.preventDefault();
                    const link = event.target.getAttribute('href');
                    modalByUrl(link, options);
                })
            }
        });
        $element.find('form').each(function (index, formElement) {
            if (formElement.action.includes('/')) {
                const $form = $(formElement);
                $form.submit(function (event) {
                    event.preventDefault();
                    const link = event.target.getAttribute('action');
                    options = {
                        ...{method: 'POST', data: (new FormData($form[0])), dataType: 'json'},
                        ...options
                    }
                    modalByUrl(link, options);
                })
            }
        });
    };

    const modal = (options) => {
        const modalOptions = {
            ...{
                title: '',
                close: false,
                refreshPageOnClose: false,
                body: '',
                button: '<button type="button" class="btn btn-primary">Добавить</button>',
                showCallback: () => {
                    console.log('showCallback')
                },
                buttonCallback: () => {
                    console.log('buttonCallback')
                },
            }, ...options
        };

        // удаляем старую форму
        $('#' + modalId)
            .modal('hide') // closes all active pop ups.
            .remove();
        $('.modal-backdrop').remove(); // removes the grey overlay.
        $('body')
            .css('padding-right', '0') // При открытии добавляет, при закрытие убираеться(но если 2 форма то добавляеться еще раз)
            .removeClass('fixed')
            .removeClass('modal-open');

        if (modalOptions.close === true) {
            if (modalOptions.refreshPageOnClose) {
                $.get(location.href, (html) => {
                    $(modalOptions.refreshPageOnClose).html(html);
                    initEvent();
                });
            }
            return
        }

        const $modal = $(
            modalTemplate
                .replace('{title}', modalOptions.title)
                .replace('{body}', modalOptions.body)
                .replace('{button}', modalOptions.button)
        ).append('body');

        $modal.modal('show');

        Admin.shared_setup($modal);
        modalOptions.showCallback($modal);

        $modal.on('click', '.modal-footer', (e) => modalOptions.buttonCallback(e, $modal));
    };

    const scrollTo = ($element) => {
        $('html, body').animate({
            scrollTop: $element.offset().top
        }, 300);
    };

    /**
     * Задаем фиксированную высоту для элемента не больше чем размер экрана
     */
    const pageSizeScroll = () => {
        $('.js-max-page-height').each((index, element) => {
            const $element = $(element);
            $(element).css('height', 'calc(100vh - ' + $element.offset().top + 'px)');
        });
    };

    const entityEdit = (e) => {
        e.preventDefault();
        modalByUrl(e.target.href, {
            button: '<button data-dismiss="modal" type="button" class="btn btn-primary">Закрыть</button>',
            showCallback: ($modal) => {
                modalLinkHandler($modal, {refreshPageOnClose: '.content'});
            }
        });
    };

    const initFileInput = () => {
        setTimeout(() => {
            $('.sonata-ba-field > input.js-file-input').each((_, input) => {
                const $input = $(input);
                $input.attr('placeholder', 'Выберите изображение ...');
                $input.fileinput({
                    browseOnZoneClick: true,
                    dropZoneEnabled: false,
                    allowedFileExtensions: ["jpg", "png", "gif"],
                    showUpload: false,
                    language: 'ru',
                    msgPlaceholder: 'Выберите изображение ...'
                });

                $input.one('change', () => {
                    $input.closest('.sonata-ba-field').find('img:last').remove();
                });
            });
        }, 200);
    };


    let isFormEditValidCallback = null;
    const setIsFormEditValidCallBack = (callback) => {
        isFormEditValidCallback = callback;
    }
    let $buttonContainer = null;
    const formOnSubmit = (e) => {
        if (isFormEditValidCallback === null) return;
        e.preventDefault();
        const $buttonClicked = $(document.activeElement);
        if(!$buttonContainer) {
            $buttonContainer = $buttonClicked.closest('.form-actions');
        }
        if (isFormEditValidCallback(e)) {
            $formEl.unbind('submit', formOnSubmit);
            $formEl.trigger('submit');
        } else {
            console.error('valid false');
            setTimeout(() => {
                $buttonContainer.find('button').each((_, element) => element.removeAttribute('disabled'))
            }, 1000)
        }
    }

    /**
     * Функция для тестирования. Заполнение необходимых полей
     */
    const fillRequired = () => {
        $formEl.find('[name][required]').each((_, element) => {
            if (!element.value) {
                element.value = '111';
                $(element).trigger('change');
            }
        })
    }

    return {
        init,
        modalByUrl,
        modalLinkHandler,
        setIsFormEditValidCallBack,
        fillRequired
    }
})();