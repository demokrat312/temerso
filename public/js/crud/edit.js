$(document).ready(function () {
    CrudEditModel.init();
});
const CrudEditModel = (function () {

    const modalTemplate = `
            <div class="modal fade" id="edit_dialog" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
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
        console.log('edit init');
        initEvent();
    };

    const initEvent = () => {
        $('.js-prev-tab').on('click', () => prevOrNextTabHandler('prev'));
        $('.js-next-tab').on('click', () => prevOrNextTabHandler('next'));
    };

    const prevOrNextTabHandler = (prevOrNext) => {
        const $tab = $('.nav-tabs');
        const $newActiveLi = $tab.find('li.active')[prevOrNext]('li');

        if ($newActiveLi.length) {
            scrollTo($('body'));

            $newActiveLi.find('a').trigger('click');
        }

    };

    const modalByUrl = (url, options = {}) => {
        $.ajax({
            type: 'GET',
            url: url,
            dataType: 'html',
            success: function (html) {
                modal({...options, ...{body: html}});
            }
        });
    };

    const modal = (options) => {
        const modalOptions = {
            ...{
                title: '',
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
        $('#edit_dialog').remove();

        $modal = $(
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

    return {
        init,
        modalByUrl
    }
})();