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
            $('.js-next-tab').on('click', nextTabHandler);
            addValidateAmount();
        };

        const nextTabHandler = () => {
            const $tab = $('.nav-tabs');

            scrollTo($('body'));
            $tab.find('li.active').next('li').find('a').trigger('click');

        };

        const scrollTo = ($element) => {
            $('html, body').animate({
                scrollTop: $element.offset().top
            }, 300);
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