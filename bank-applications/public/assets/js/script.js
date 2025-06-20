$(document).ready(function () {
    // Функция проверки заполненности всех обязательных полей
    function checkFormValidity() {
        let isValid = true;
        const currentClientType = $('input[name="clientType"]:checked').val();

        // Сначала удаляем required у всех полей неактивного клиента
        if (currentClientType === 'individual') {
            $('#legalClient').find('input').prop('required', false);
            $('#individualClient').find('input').prop('required', true);
        } else {
            $('#individualClient').find('input').prop('required', false);
            $('#legalClient').find('input').prop('required', true);
        }

        // Проверяем только активные поля
        $(`.client-section:not(.hidden) [required]`).each(function () {
            if (!$(this).val()) {
                isValid = false;
                return false; // прерываем цикл при первой же ошибке
            }
        });

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
            // Удаляем required у полей неактивного клиента перед переходом
            const currentClientType = $('input[name="clientType"]:checked').val();
            if (currentClientType === 'individual') {
                $('#legalClient').find('[required]').prop('required', false);
            } else {
                $('#individualClient').find('[required]').prop('required', false);
            }

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