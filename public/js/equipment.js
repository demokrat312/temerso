(function ($) {
    $(document).ready(function () {
        EquipmentModel.init();
    });

    const EquipmentModel = (function () {
        let $formEdit, $formEditParent;
        const errorTemplate = `
            <div id="form-alert-danger" class="alert alert-danger" role="alert">
              {message}
            </div>
        `;

        const init = () => {
            console.info('EquipmentModel init');
            $formEditParent = $('.sonata-ba-form');
            $formEdit = $formEditParent.find('form:first');

            initEvent();
        };

        const initEvent = () => {
            $formEdit.on('submit', onFormEditSubmit )
        };

        const onFormEditSubmit = function(e) {
            e.preventDefault();

            console.log('submit');
            showError($formEditParent, 'ошибка')
        };

        const showError = ($element, message) =>  {
            $element.prepend($(errorTemplate.replace('{message}', message)));
        };

        return {
            init
        }
    })();
})(jQuery);