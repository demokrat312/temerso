(function ($) {
    $(document).ready(function () {
        UserModel.init();
    });

    const UserModel = (function () {
        let $firstNameInput, $lastNameInput, $usernameInput;

        const init = () => {
            console.log('UserModel');
            eventInit();
        };

        const eventInit = () => {
            if (!isEditMode()) {
                setUserNameInputs();
                $($firstNameInput).add($lastNameInput).on('change', updateUserName);
            }
            ;
        };

        const getInputByName = (name) => {
            return $('[name$="[' + name + ']"]');
        };

        const updateUserName = () => {
            if ($firstNameInput.val() && $lastNameInput.val()) {
                const firstNameLat = rusToLatin($firstNameInput.val());
                const lastNameLat = rusToLatin($lastNameInput.val());

                const userNameLat = lastNameLat.toLowerCase() + firstNameLat[0].toUpperCase();
                $usernameInput.val(userNameLat);
            }
        };

        const rusToLatin = (str) => {
            const ru = {
                'а': 'a', 'б': 'b', 'в': 'v', 'г': 'g', 'д': 'd',
                'е': 'e', 'ё': 'e', 'ж': 'j', 'з': 'z', 'и': 'i',
                'к': 'k', 'л': 'l', 'м': 'm', 'н': 'n', 'о': 'o',
                'п': 'p', 'р': 'r', 'с': 's', 'т': 't', 'у': 'u',
                'ф': 'f', 'х': 'h', 'ц': 'c', 'ч': 'ch', 'ш': 'sh',
                'щ': 'shch', 'ы': 'y', 'э': 'e', 'ю': 'u', 'я': 'ya'
            }, n_str = [];

            str = str.replace(/[ъь]+/g, '').replace(/й/g, 'i');

            for (let i = 0; i < str.length; ++i) {
                n_str.push(
                    ru[str[i]]
                    || ru[str[i].toLowerCase()] == undefined && str[i]
                    || ru[str[i].toLowerCase()].replace(/^(.)/, function (match) {
                        return match.toUpperCase()
                    })
                );
            }

            return n_str.join('');
        };

        const setUserNameInputs = () => {
            $firstNameInput = getInputByName('firstname');
            $lastNameInput = getInputByName('lastname');
            $usernameInput = getInputByName('username');
        };

        /**
         * Редактирование пользователя?
         *
         * @returns {boolean}
         */
        const isEditMode = () => {
            return location.href.includes('/edit');
        };


        return {
            init
        }
    })();
})(jQuery);