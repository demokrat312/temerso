(function ($) {
    $(document).ready(function () {
        ReturnFromRepairModel.init();
    });

     window.ReturnFromRepairModel = (function () {
        let $cardList = null;

        const init = () => {
            console.info('ReturnFromRepairModel init');
            $cardList = $('.js-repair-card-list');

            initEvent();
            // loadCardList($cardList.data('card_url'), $cardList)
        };

        const initEvent = () => {
            $('.js-on-change-repair').on('change',onChangeRepair);
        };

        const loadCardList = (url, $element) => {
            $.get(url, (html) => {
                const $table = $(html).find('.sonata-ba-list');
                if($table.length) {
                    // Удаляем последний столбец
                    $table.find('tr').each(function(index, tr) {
                        $(tr).find('td:last').remove();
                    });

                    $element.html($table.parent().html());

                    const options = {
                        button: '<button data-dismiss="modal" type="button" class="btn btn-primary">Закрыть</button>',
                        showCallback: ($modal) => {
                            $modal.find('.box-title').remove();
                            CrudEditModel.modalLinkHandler($modal, options);
                        }
                    };
                    CrudEditModel.modalLinkHandler($element, options);
                } else {
                    $element.html(html);
                }
            });
        };

        const onChangeRepair = (event) => {
            $cardList.html('Загрузка...');
            loadCardList($cardList.data('card_url') + event.target.value, $cardList)
        };

        return {
            init,
            loadCardList
        }
    })();
})(jQuery);