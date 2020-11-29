(function ($) {
    $(document).ready(function () {
        EquipmentModel.init();
    });

    const EquipmentModel = (function () {
        let $formEdit, $formEditParent, $formErrorAlert
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

            initEvent();
        };

        const initEvent = () => {
            $formEdit.on('submit', onFormEditSubmit);
        };

        const onFormEditSubmit = function (e) {
            if (typeof AdminEquipmentKitModel === 'undefined') {
                return true;
            }
            // Кнопка на которую нажали
            const $buttonClick = $(document.activeElement);
            e.preventDefault();
            let hasError = false;

            /** @type {{
             * kitType: "single"|"multi",
             * withKit: "withCatalog"|"withoutCatalog",
             * cardCount: number,
             * kitCount: number,
             * kitCardCount: string,
             * }}
             * */
            const formData = getFormData($formEdit);


            // С выборкой из каталога
            if (formData.withKit === 'withCatalog') {
                /** @type {{title: string: cardsAmount: Number[]}[]} */
                    // Количество комплектов и карточек в комплекте
                const amountOfKitCards = AdminEquipmentKitModel.getAmountOfKitCards();

                //<editor-fold desc="Проверяем на загаловок">
                const hasTitle = function(amountOfKitCards) {
                    const withTitle = amountOfKitCards.filter(item => !!item.title);

                    return withTitle.length === amountOfKitCards.length
                }(amountOfKitCards);
                if(!hasTitle) {
                    showError('Ошибка: Необходимо задать название для комплекта ');
                    hasError = true;
                }
                //</editor-fold>

                // Единичный комплект
                if (formData.kitType === 'single') {
                    if (amountOfKitCards.length !== 1) {
                        showError('Ошибка: Нужно создать 1 комплект, создано ' + amountOfKitCards.length);
                        hasError = true;
                    } else if (+formData.cardCount !== amountOfKitCards[0].cardsAmount) {
                        showError('Ошибка: В поле "Укажите количество единиц оборудования" указано ' + formData.cardCount
                            + '. Выбрано из справочника ' + amountOfKitCards[0].cardsAmount);
                        hasError = true;
                    }
                    // Множественный
                } else if (formData.kitType === 'multi') {
                    const kitCardCountArray = formData.kitCardCount.split(',');
                    if (amountOfKitCards.length !== +formData.kitCount || amountOfKitCards.length !== kitCardCountArray.length) {
                        showError('Ошибка: Выбранное количество комплектов не совпадает с добавленными комплектами ');
                        hasError = true;
                    } else {
                        for (let i = 0; i < amountOfKitCards.length; i++) {
                            if (+kitCardCountArray[i] !== amountOfKitCards[i].cardsAmount) {
                                showError(`Ошибка: В комплекте ${amountOfKitCards[i].title} выбрано 
                             ${amountOfKitCards[i].cardsAmount} нужно выбрать ${kitCardCountArray[i]}
                             `);
                                hasError = true;
                            }
                        }
                    }
                }
                // без выборки из каталога
            } else {
                /** @type {{title: string: cardsAmount: Number[]}[]} */
                const amountOfKitSpecification = AdminEquipmentKitModel.getAmountOfKitSpecification();
                if (amountOfKitSpecification.length === 0 || amountOfKitSpecification[0].cardsAmount === 0) {
                    showError('Ошибка: Укажите технические характеристики');
                    hasError = true;
                } else if (amountOfKitSpecification[0].title === '') {
                    showError('Ошибка: Укажите название комплекта');
                    hasError = true;
                }
            }

            if (hasError) {
                setTimeout(() => {
                    $formEdit.find('button').each((index, button) => {
                        $(button).removeAttr('disabled')
                    })
                }, 1000);
            } else {
                hideError();
                $formEdit.unbind('submit');
                if ($buttonClick.length) {
                    setTimeout(() => {
                        $buttonClick.removeAttr('disabled');
                        $buttonClick.trigger('click');
                    }, 1000);
                } else {
                    $formEdit.submit();
                }
            }
        };

        const showError = (message, $element = $formEditParent,) => {
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