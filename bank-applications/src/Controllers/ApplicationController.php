<?php

namespace BankApplication\Controllers;

use BankApplication\Services\ApplicationService;

class ApplicationController
{
    private $service;

    public function __construct(ApplicationService $service)
    {
        $this->service = $service;
    }

    public function showForm()
    {
        include $_SERVER['DOCUMENT_ROOT'] . '/public/views/applications_form.php';
    }

    public function submitApplication()
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            try {
                $applicationId = $this->service->createApplication($_POST);
                header('Location: /success.php?id=' . $applicationId);
                exit;
            } catch (Exception $e) {
                die('Ошибка при создании заявки: ' . $e->getMessage());
            }
        } else {
            header('Location: /');
            exit;
        }
    }
}