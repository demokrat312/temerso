(function ($) {
    $(document).ready(function () {
        ArrivalModel.init();
    });

    const ArrivalModel = (function () {
        const separator = ';';
        const fieldsForCheckAmount = ['groupPipeSerialNumber', 'groupSerialNoOfNipple', 'groupCouplingSerialNumber', 'groupPipeLength', 'groupWeightOfPipe'];

        const init = () => {
            console.info('ArrivalModel init');
            initEvent();
        };

        const initEvent = () => {
            addValidateAmount();
        };

        const addValidateAmount = () => {
            for (const fieldName of fieldsForCheckAmount) {
                $('[name$="[' + fieldName + ']"]').on('change', (event) => validateAmount(event));
            }
        };

        const validateAmount = (event) => {
            const errorMessageTemplate = `Необходимо ввести {require}, вы ввели {enter}`;
            const requireAmount = $('[name$="[amountCard]"]').val() || 0;
            const $field = $(event.target);

            let fieldValue = $field.val().trim().split(separator);
            const fieldValueFixed = fixFieldValue(fieldValue);
            $field.val(fieldValueFixed.join(separator));

            // const last = [...fieldValue].pop();
            // // Убираем последний пустой элемент
            // if(fieldValue.length && last === '') {
            //     fieldValue.splice(-1);
            //     $field.val(fieldValue.join(separator))
            // }

            const enterAmount = fieldValueFixed.length;

            if (+requireAmount !== +enterAmount) {
                const errorMessage = errorMessageTemplate
                    .replace('{require}', requireAmount)
                    .replace('{enter}', enterAmount);
                validateAmountErrorToggle($field, true, errorMessage);
            } else {
                validateAmountErrorToggle($field, false);
            }
        };

        const validateAmountErrorToggle = ($field, isShow, errorMessage = '') => {
            const errorElement = `<div class="alert alert-danger" role="alert"> </div>`;

            const $formGroup = $field.closest('.form-group');

            $formGroup.find('.alert-danger').remove();
            if (isShow) {
                $formGroup.addClass('has-error');
                $errorElement = $(errorElement).text(errorMessage);
                $formGroup.find('label').after($errorElement)
            } else {
                $formGroup.removeClass('has-error');
            }
        };

        const fixFieldValue = (fieldValues) => {
            // Удаляем пустые значения
            fieldValues = fieldValues.filter(fieldValue => fieldValue.trim());
            // Заменяем , на .
            fieldValues = fieldValues.map(fieldValue => {
                const fieldValueString = ('' + fieldValue).replace(/,/g, '.');
                // return parseFloat(fieldValueString);
                return fieldValueString
            });

            return fieldValues;
        };

        return {
            init
        }
    })();
})(jQuery);