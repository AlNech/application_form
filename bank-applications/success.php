<?php
$config = require __DIR__ . '/src/config/database.php';

include __DIR__ . '/src/Database/Database.php';
include __DIR__ . '/src/repositories/ApplicationRepository.php';
include __DIR__ . '/src/services/ApplicationService.php';

use BankApplication\Database\Database;
use BankApplication\Repositories\ApplicationRepository;
use BankApplication\Services\ApplicationService;


$db = Database::getInstance($config['db']);
$repository = new ApplicationRepository($db);
$service = new ApplicationService($repository);

$applicationId = isset($_GET['id']) ? $_GET['id'] : null;

if (!$applicationId) {
    header('Location: /');
    exit;
}

try {
    $applicationData = $service->getApplicationById($applicationId);

    if (!$applicationData) {
        header('Location: /');
        exit;
    }
    $clientType = $applicationData['client']['type'];
    $productType = $applicationData['application']['product_type'];

    // Формируем данные для отображения
    $clientName = $clientType === 'individual'
        ? $applicationData['client']['full_name']
        : $applicationData['client']['company_name'];

    $productInfo = $productType === 'credit'
        ? "Кредит на сумму " . $applicationData['product']['amount'] . " руб."
        : "Вклад под " . $applicationData['product']['interest_rate'] . "%";

} catch (Exception $e) {
    die("Ошибка при получении данных заявки: " . $e->getMessage());
}
?>

<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Заявка успешно создана</title>
    <link rel="stylesheet" href="/public/assets/css/style.css">
</head>
<body>
<div class="container">
    <h1>Заявка успешно создана</h1>

    <div class="form-section">
        <h2>Информация о заявке</h2>

        <div class="form-group">
            <label>Номер заявки:</label>
            <p><?= htmlspecialchars($applicationId) ?></p>
        </div>

        <div class="form-group">
            <label>Тип клиента:</label>
            <p><?= $clientType === 'individual' ? 'Физическое лицо' : 'Юридическое лицо' ?></p>
        </div>

        <div class="form-group">
            <label>Клиент:</label>
            <p><?= htmlspecialchars($clientName) ?></p>
        </div>

        <div class="form-group">
            <label>Продукт:</label>
            <p><?= htmlspecialchars($productInfo) ?></p>
        </div>

        <div class="form-group">
            <label>Дата создания:</label>
            <p><?= htmlspecialchars($applicationData['application']['application_created_at']) ?></p>
        </div>
    </div>

    <div class="button-group">
        <a href="/" class="button">Вернуться на главную</a>
    </div>
</div>
</body>
</html>