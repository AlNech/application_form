<?php

namespace BankApplication\Models;

class LegalClient extends BaseClient
{
    private $directorFullName;
    private $directorInn;
    private $companyName;
    private $companyAddress;
    private $ogrn;
    private $companyInn;
    private $kpp;

    public function __construct($directorFullName, $directorInn, $companyName, $companyAddress, $ogrn, $companyInn, $kpp, $requisitesId = null, $id = null)
    {
        parent::__construct($companyInn, $requisitesId, $id);
        $this->type = 'legal';
        $this->directorFullName = $directorFullName;
        $this->directorInn = $directorInn;
        $this->companyName = $companyName;
        $this->companyAddress = $companyAddress;
        $this->ogrn = $ogrn;
        $this->companyInn = $companyInn;
        $this->kpp = $kpp;
    }

    public function getData()
    {
        return [
            'director_full_name' => $this->directorFullName,
            'director_inn' => $this->directorInn,
            'company_name' => $this->companyName,
            'company_address' => $this->companyAddress,
            'ogrn' => $this->ogrn,
            'company_inn' => $this->companyInn,
            'kpp' => $this->kpp,
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