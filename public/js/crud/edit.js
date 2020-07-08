(function ($) {
    $(document).ready(function () {
        CrudEditModel.init();
    });
    const CrudEditModel = (function () {
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

        const scrollTo = ($element) => {
            $('html, body').animate({
                scrollTop: $element.offset().top
            }, 300);
        };

        return {
            init
        }
    })();
})(jQuery);