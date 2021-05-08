(function ($) {
    $(document).ready(function () {
        ArrivalModel.init();
    });

    const ArrivalModel = (function () {
        const separator = new RegExp('[;\n]', 'g');
        const separatorJoin = ';';
        const fieldsForCheckAmount = ['groupPipeSerialNumber', 'groupSerialNoOfNipple', 'groupCouplingSerialNumber', 'groupPipeLength', 'groupWeightOfPipe'];
        const fieldsForCheckAmountList = new Map();
        let $requiredAmountInput;

        const init = () => {
            console.info('ArrivalModel init');
            $requiredAmountInput = $('[name$="[amountCard]"]')
            CrudEditModel.setIsFormEditValidCallBack(isFormValid);
            initEvent();
        };

        const initEvent = () => {
            initValidateAmount();
            $requiredAmountInput.on('change', requiredAmountInputChange)
        };

        const initValidateAmount = () => {
            for (const fieldName of fieldsForCheckAmount) {
                const $input = $('[name$="[' + fieldName + ']"]');
                $input.on('change', (event) => validateAmountOnChange(event));
                fieldsForCheckAmountList.set(fieldName, $input);
            }
        };

        const validateAmountOnChange = (event) => {
            const errorMessageTemplate = `Необходимо ввести {require}, вы ввели {enter}`;
            const requireAmount = $requiredAmountInput.val() || 0;
            const $field = $(event.target);

            // Правим значения из поля и перезаписываем
            let fieldValue = $field.val().trim().split(separator);
            const fieldValueFixed = fixFieldValue(fieldValue);
            $field.val(fieldValueFixed.join(separatorJoin));

            const enteredAmount = fieldValueFixed.length;

            // Проверям и выводим ошибку
            if (+requireAmount !== +enteredAmount) {
                const errorMessage = errorMessageTemplate
                    .replace('{require}', requireAmount)
                    .replace('{enter}', enteredAmount);
                validateAmountErrorToggle($field, true, errorMessage);
            } else {
                validateAmountErrorToggle($field, false);
            }
        };

        // Отображаем/Прячем ошибку
        const validateAmountErrorToggle = ($field, isShow, errorMessage = '') => {
            // Переменные
            const errorTemplate = `<div class="alert alert-danger" role="alert"> </div>`;
            const $errorContainer = $field.closest('.form-group');

            // Вспомогательные функции
            const
                removeError = ($container) => {
                    $container
                        .find('[name]').removeAttr('error').end()
                        .find('.alert-danger').remove().end()
                        .removeClass('has-error')
                    ;
                },
                addError = ($container) => {
                    removeError($container);
                    const $errorElement = $(errorTemplate).text(errorMessage);
                    $container
                        .find('[name]').attr('error', true).end()
                        .find('label').after($errorElement).end()
                        .addClass('has-error')
                    ;
                }

            // Отображаем/Прячем ошибку
            if (isShow) {
                addError($errorContainer);
            } else {
                removeError($errorContainer);
            }
        };

        const fixFieldValue = (fieldValues) => {
            // Удаляем пустые значения
            fieldValues = fieldValues.filter(fieldValue => fieldValue.trim());
            // Заменяем , на .
            fieldValues = fieldValues.map(fieldValue => {
                return ('' + fieldValue).replace(/,/g, '.')
            });

            return fieldValues;
        };

        const isFormValid = function () {
            let inputLabel = '';
            const hasError = [...fieldsForCheckAmountList.values()].some($input => {
                if ($input.is('[error]')) {
                    inputLabel = $input.closest('.form-group').find('label').text().trim();
                    return true;
                }
            });
            if (hasError) {
                alert(`В поле "${inputLabel}" ошибка`);
                return false;
            }
            return true;
        }

        const requiredAmountInputChange = () => {
            fieldsForCheckAmountList.forEach($input => {
                if($input.val())$input.trigger('change');
            })
        }

        return {
            init
        }
    })();
})(jQuery);