(function ($) {
    $(document).ready(function () {
        ArrivalModel.init();
    });

    const ArrivalModel = (function () {
        const fieldsForCheckAmount = ['groupPipeSerialNumber', 'groupSerialNoOfNipple', 'groupCouplingSerialNumber', 'groupPipeLength', 'groupWeightOfPipe'];

        const init = () => {
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
            console.log('change validateAmount');
            const errorMessageTemplate = `Необходимо ввести {require}, вы ввели {enter}`;
            const requireAmount = $('[name$="[amountCard]"]').val();
            const $field = $(event.target);

            const enterAmount = $field.val().split(',').length;

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

        return {
            init
        }
    })();
})(jQuery);