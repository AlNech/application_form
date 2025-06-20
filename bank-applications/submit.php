<?php
$config = require __DIR__ . '/src/config/database.php';

require_once __DIR__ . '/src/Database/Database.php';
require_once __DIR__ . '/src/repositories/ApplicationRepository.php';
require_once __DIR__ . '/src/services/ApplicationService.php';
require_once __DIR__ . '/src/controllers/ApplicationController.php';
require_once __DIR__ . '/src/models/IndividualClient.php';
require_once __DIR__ . '/src/models/LegalClient.php';
require_once __DIR__ . '/src/models/CreditProduct.php';
require_once __DIR__ . '/src/models/DepositProduct.php';
require_once __DIR__ . '/src/models/Application.php';

use BankApplication\Database\Database;
use BankApplication\Repositories\ApplicationRepository;
use BankApplication\Services\ApplicationService;
use BankApplication\Controllers\ApplicationController;


$db = Database::getInstance($config['db']);
$repository = new ApplicationRepository($db);
$service = new ApplicationService($repository);
$controller = new ApplicationController($service);

$controller->submitApplication();