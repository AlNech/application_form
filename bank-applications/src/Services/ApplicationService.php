<?php

namespace BankApplication\Services;

use BankApplication\Models\IndividualClient;
use BankApplication\Models\LegalClient;
use BankApplication\Models\CreditProduct;
use BankApplication\Models\DepositProduct;
use BankApplication\Models\Application;
use BankApplication\Repositories\ApplicationRepository;


class ApplicationService
{
    private $repository;

    public function __construct(ApplicationRepository $repository)
    {
        $this->repository = $repository;
    }

    public function createApplication(array $data)
    {
        $data = array_map("htmlspecialchars", $data);
        // Создаем клиента
        if ($data['clientType'] === 'individual') {
            $client = new IndividualClient(
                $data['individualFullName'],
                $data['individualInn'],
                $data['individualBirthDate'],
                $data['passportSeries'],
                $data['passportNumber'],
                $data['passportIssueDate']
            );
        } else {
            $client = new LegalClient(
                $data['directorFullName'],
                $data['directorInn'],
                $data['companyName'],
                $data['companyAddress'],
                $data['ogrn'],
                $data['companyInn'],
                $data['kpp']
            );
        }

        // Создаем продукт
        if ($data['productType'] === 'credit') {
            $product = new CreditProduct(
                $data['creditOpenDate'],
                $data['creditCloseDate'],
                $data['creditTerm'],
                $data['paymentSchedule'],
                $data['creditAmount']
            );
        } else {
            $product = new DepositProduct(
                $data['depositOpenDate'],
                $data['depositCloseDate'],
                $data['depositTerm'],
                $data['interestRate'],
                $data['capitalization']
            );
        }

        // Создаем и сохраняем заявку
        $application = new Application($client, $product);
        return $this->repository->save($application);
    }

    public function getApplicationById($id)
    {
        return $this->repository->findApplicationById($id);
    }
}
