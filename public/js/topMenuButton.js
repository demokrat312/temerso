(function ($) {
    $(document).ready(function () {
        TopMenuButtonModel.init();
    });

    const TopMenuButtonModel = (function () {
        let $btnReviewError;

        const init = () => {
            console.log('TopMenuButtonModel');
            $btnReviewError = $('#top-menu-btn_review_error');
            initEvent();
        };

        const initEvent = () => {
            if ($btnReviewError.length) {
                $btnReviewError.on('click', addComment);
            }
        };

        const addComment = (event) => {
            debugger;
            event.preventDefault();

            $url = $btnReviewError.attr('href');

            $commentInput = $('<textarea class="form-control" placeholder="Введите комментарий"></textarea>');
            BootstrapDialog.show({
                title: $btnReviewError.text().trim(),
                message: $commentInput,
                buttons: [{
                    label: 'Отправить',
                    cssClass: 'btn-primary',
                    hotkey: 13, // Enter.
                    action: function () {
                        alert($commentInput.val());
                        $paramPrefix = $url.includes('?') ? '&' : '?';
                        location.href = $url + $paramPrefix + 'comment=' + $commentInput.val();
                    }
                }]
            });
        };

        return {
            init
        }
    })();
})(jQuery);