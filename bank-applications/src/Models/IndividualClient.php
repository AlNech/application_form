<?php

namespace BankApplication\Models;

require_once('BaseClient.php');

class IndividualClient extends BaseClient
{
    private $fullName;
    private $birthDate;
    private $passportSeries;
    private $passportNumber;
    private $passportIssueDate;

    public function __construct($fullName, $inn, $birthDate, $passportSeries, $passportNumber, $passportIssueDate, $requisitesId = null, $id = null)
    {
        parent::__construct($inn, $requisitesId, $id);
        $this->type = 'individual';
        $this->fullName = $fullName;
        $this->birthDate = $birthDate;
        $this->passportSeries = $passportSeries;
        $this->passportNumber = $passportNumber;
        $this->passportIssueDate = $passportIssueDate;
    }

    public function getData()
    {
        return [
            'full_name' => $this->fullName,
            'inn' => $this->inn,
            'birth_date' => $this->birthDate,
            'passport_series' => $this->passportSeries,
            'passport_number' => $this->passportNumber,
            'passport_issue_date' => $this->passportIssueDate,
            'requisites_id' => $this->requisitesId
        ];
    }

    public function getClientData()
    {
        return [
            'type' => $this->type,
            'inn' => $this->inn,
            'requisites_id' => $this->requisitesId
        ];
    }
}