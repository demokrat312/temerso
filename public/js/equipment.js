(function ($) {
    $(document).ready(function () {
        // EquipmentModel.init();
    });

    const EquipmentModel = (function () {
        let $formEdit, $formEditParent, $formErrorAlert,
            // Каталог - добавляем карточки или характеристики
            $withKitInput = null,
            // Тип комплекта
            $kitTypeInput = null
        ;
        const errorTemplate = `
            <div id="form-alert-danger" class="alert alert-danger" role="alert">
              {message}
            </div>
        `;

        const init = () => {
            console.info('EquipmentModel init');
            $formEditParent = $('.sonata-ba-form');
            $formEdit = $formEditParent.find('form:first');
            $kitTypeInput = $('[name$="[kitType]"]'); // Выбрать тип комплекта
            $withKitInput = $('[name$="[withKit]"]'); // Каталог

            initEvent();
        };

        const initEvent = () => {
            $formEdit.on('submit', onFormEditSubmit);
        };

        const onFormEditSubmit = function (e) {
            e.preventDefault();
            console.log('submit');

            // С выборкой из каталога
            if ($withKitInput.val() === 'withCatalog') {
                if ($kitTypeInput.val() === 'single') {
                    console.log('выбираем карточки. Количество комплектов ' + 1 + ' количество карточек ' + getInput('cardCount').val())
                } else {
                    console.log('выбираем карточки. Количество комплектов ' + getInput('kitCount').val() + ' количество карточек ' + getInput('kitCardCount').val())
                }
            } else {
                console.log('Указываем технические характеристики');
            }

            showError($formEditParent, 'ошибка');
        };

        const showError = ($element, message) => {
            hideError();
            $formErrorAlert = $(errorTemplate.replace('{message}', message));
            $element.prepend($formErrorAlert);
            $formErrorAlert[0].scrollIntoView({block: "center", behavior: "smooth"});
        };

        const hideError = () => {
            $formErrorAlert && $formErrorAlert.remove();
        };

        const getInput = (name) => {
            return $formEdit.find('[name$="[' + name + ']"]');
        };

        const getFormData = ($form) => {
            const formArray = $form.serializeArray();
            var returnArray = {};
            for (var i = 0; i < formArray.length; i++) {
                const formName = formArray[i]['name'].replace(/.*\[(\w+)\].*/, '$1');
                returnArray[formName] = formArray[i]['value'];
            }
            return returnArray;
        };


        return {
            init
        }
    })();
})(jQuery);