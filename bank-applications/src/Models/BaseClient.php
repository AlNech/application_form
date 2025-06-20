<?php

namespace BankApplication\Models;

abstract class BaseClient
{
    protected $id;
    protected $type;
    protected $inn;
    protected $requisitesId;

    public function __construct($inn, $requisitesId, $id = null)
    {
        $this->inn = $inn;
        $this->requisitesId = $requisitesId;
        $this->id = $id;
    }

    public function getId()
    {
        return $this->id;
    }

    public function getType()
    {
        return $this->type;
    }

    public function getInn()
    {
        return $this->inn;
    }

    public function getRequisitesId()
    {
        return $this->requisitesId;
    }

    abstract public function getData();
}