$(document).ready(function () {
    // Функция проверки заполненности всех обязательных полей
    function checkFormValidity() {
        let isValid = true;
        const currentClientType = $('input[name="clientType"]:checked').val();

        // Проверяем поля в зависимости от типа клиента
        if (currentClientType === 'individual') {
            $('#individualClient').find('[required]').each(function () {
                if (!$(this).val()) {
                    isValid = false;
                    return false;
                }
            });
        } else {
            $('#legalClient').find('[required]').each(function () {
                if (!$(this).val()) {
                    isValid = false;
                    return false;
                }
            });
        }

        // Обновляем состояние кнопки "Далее"
        if (isValid) {
            $('#nextBtn').addClass('next-btn-active');
        } else {
            $('#nextBtn').removeClass('next-btn-active');
        }

        return isValid;
    }

    // Проверка формы при изменении полей
    $('input, select').on('input change', function () {
        checkFormValidity();
    });

    // Переключение между типами клиентов
    $('input[name="clientType"]').change(function () {
        $('.client-section').addClass('hidden');
        const selectedType = $(this).val();
        $(`#${selectedType}Client`).removeClass('hidden');
        checkFormValidity();
        $('.client-section [required]').prop('required', false);
        $('.client-section:not(.hidden) [required]').prop('required', true);
    });

    // Переключение между типами продуктов
    $('input[name="productType"]').change(function () {
        $('.product-section').addClass('hidden');
        const selectedType = $(this).val();
        $(`#${selectedType}Product`).removeClass('hidden');
        $('.product-section [required]').prop('required', false);
        $('.product-section:not(.hidden) [required]').prop('required', true);
    });

    // Переход к следующему шагу
    $('#nextBtn').click(function () {
        if (checkFormValidity()) {
            $('#step1').addClass('hidden');
            $('#step2').removeClass('hidden');
            $('.step').removeClass('active');
            $('.step').eq(1).addClass('active');
        } else {
            $('#step1')[0].reportValidity();
        }
    });

    // Возврат к предыдущему шагу
    $('#prevBtn').click(function () {
        $('#step2').addClass('hidden');
        $('#step1').removeClass('hidden');
        $('.step').removeClass('active');
        $('.step').eq(0).addClass('active');
    });

    // Первоначальная проверка формы
    checkFormValidity();
});