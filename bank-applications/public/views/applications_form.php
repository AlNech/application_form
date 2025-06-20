<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Заявка на банковский продукт</title>
    <link rel="stylesheet" href="/public/assets/css/style.css">
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
</head>
<body>
<div class="container">
    <h1>Заявка на банковский продукт</h1>

    <div class="step-indicator">
        <div class="step active">1</div>
        <div class="step">2</div>
    </div>

    <form id="bankApplicationForm" method="POST" action="/submit.php">
        <!-- Шаг 1: Информация о клиенте -->
        <div id="step1" class="form-step">
            <!-- Выбор типа клиента -->
            <div class="form-section">
                <h2>Тип клиента</h2>
                <div class="radio-group">
                    <label class="radio-option">
                        <input type="radio" name="clientType" value="individual" checked> Физическое лицо
                    </label>
                    <label class="radio-option">
                        <input type="radio" name="clientType" value="legal"> Юридическое лицо
                    </label>
                </div>
            </div>

            <!-- Блок для физического лица -->
            <div id="individualClient" class="form-section client-section">
                <h2>Данные физического лица</h2>

                <div class="form-group">
                    <label for="individualFullName" class="required">ФИО</label>
                    <input type="text" id="individualFullName" name="individualFullName" required>
                </div>

                <div class="row">
                    <div class="form-group">
                        <label for="individualInn" class="required">ИНН</label>
                        <input type="number" maxlength="20" id="individualInn" name="individualInn" required>
                    </div>
                    <div class="form-group">
                        <label for="individualBirthDate" class="required">Дата рождения</label>
                        <input type="date" id="individualBirthDate" name="individualBirthDate" required>
                    </div>
                </div>

                <h3>Паспортные данные</h3>
                <div class="row">
                    <div class="form-group">
                        <label for="passportSeries" class="required">Серия</label>
                        <input type="number" maxlength="4" id="passportSeries" name="passportSeries" required>
                    </div>
                    <div class="form-group">
                        <label for="passportNumber" class="required">Номер</label>
                        <input type="number" maxlength="6" id="passportNumber" name="passportNumber" required>
                    </div>
                    <div class="form-group">
                        <label for="passportIssueDate" class="required">Дата выдачи</label>
                        <input type="date" id="passportIssueDate" name="passportIssueDate" required>
                    </div>
                </div>
            </div>

            <!-- Блок для юридического лица -->
            <div id="legalClient" class="form-section client-section">
                <h2>Данные руководителя</h2>

                <div class="row">
                    <div class="form-group">
                        <label for="directorFullName" class="required">ФИО</label>
                        <input type="text" maxlength="255" id="directorFullName" name="directorFullName">
                    </div>
                    <div class="form-group">
                        <label for="directorInn" class="required">ИНН</label>
                        <input type="number" maxlength="20" id="directorInn" name="directorInn">
                    </div>
                </div>

                <h2>Данные организации</h2>

                <div class="form-group">
                    <label for="companyName" class="required">Наименование</label>
                    <input type="text" maxlength="255" id="companyName" name="companyName">
                </div>

                <div class="form-group">
                    <label for="companyAddress" class="required">Адрес</label>
                    <input type="text" id="companyAddress" name="companyAddress">
                </div>

                <div class="row">
                    <div class="form-group">
                        <label for="ogrn" class="required">ОГРН</label>
                        <input type="number" maxlength="13" id="ogrn" name="ogrn">
                    </div>
                    <div class="form-group">
                        <label for="companyInn" class="required">ИНН</label>
                        <input type="number" maxlength="10" id="companyInn" name="companyInn">
                    </div>
                    <div class="form-group">
                        <label for="kpp" class="required">КПП</label>
                        <input type="number" maxlength="9" id="kpp" name="kpp">
                    </div>
                </div>
            </div>

            <div class="button-group">
                <button type="button" id="nextBtn">Далее</button>
            </div>
        </div>

        <!-- Шаг 2: Выбор продукта -->
        <div id="step2" class="form-step hidden">
            <div class="form-section">
                <h2>Выберите тип продукта</h2>
                <div class="radio-group">
                    <label class="radio-option">
                        <input type="radio" name="productType" value="credit" checked> Кредит
                    </label>
                    <label class="radio-option">
                        <input type="radio" name="productType" value="deposit"> Вклад
                    </label>
                </div>
            </div>

            <!-- Блок для кредита -->
            <div id="creditProduct" class="form-section product-section">
                <h2>Параметры кредита</h2>

                <div class="row">
                    <div class="form-group">
                        <label for="creditOpenDate" class="required">Дата открытия</label>
                        <input type="date" id="creditOpenDate" name="creditOpenDate" required>
                    </div>
                    <div class="form-group">
                        <label for="creditCloseDate" class="required">Дата закрытия</label>
                        <input type="date" id="creditCloseDate" name="creditCloseDate" required>
                    </div>
                </div>

                <div class="form-group">
                    <label for="creditTerm" class="required">Срок (в месяцах)</label>
                    <input type="number" id="creditTerm" name="creditTerm" required>
                </div>

                <div class="form-group">
                    <label for="paymentSchedule" class="required">График платежей</label>
                    <select id="paymentSchedule" name="paymentSchedule" required>
                        <option value="annuity">Аннуитетный</option>
                        <option value="differentiated">Дифференцированный</option>
                    </select>
                </div>

                <div class="form-group">
                    <label for="creditAmount" class="required">Сумма кредита</label>
                    <input type="number" id="creditAmount" name="creditAmount" required>
                </div>
            </div>

            <!-- Блок для вклада -->
            <div id="depositProduct" class="form-section product-section hidden">
                <h2>Параметры вклада</h2>

                <div class="row">
                    <div class="form-group">
                        <label for="depositOpenDate" class="required">Дата открытия</label>
                        <input type="date" id="depositOpenDate" name="depositOpenDate">
                    </div>
                    <div class="form-group">
                        <label for="depositCloseDate" class="required">Дата закрытия</label>
                        <input type="date" id="depositCloseDate" name="depositCloseDate">
                    </div>
                </div>

                <div class="form-group">
                    <label for="depositTerm" class="required">Срок (в месяцах)</label>
                    <input type="number" id="depositTerm" name="depositTerm">
                </div>

                <div class="form-group">
                    <label for="interestRate" class="required">Процентная ставка (%)</label>
                    <input type="number" step="0.01" id="interestRate" name="interestRate">
                </div>

                <div class="form-group">
                    <label for="capitalization" class="required">Периодичность капитализации</label>
                    <select id="capitalization" name="capitalization">
                        <option value="end">В конце срока</option>
                        <option value="monthly">Ежемесячно</option>
                    </select>
                </div>
            </div>

            <div class="button-group">
                <button type="button" id="prevBtn">Назад</button>
                <button type="submit">Отправить заявку</button>
            </div>
        </div>
    </form>
</div>

<script src="/public/assets/js/script.js"></script>
</body>
</html>