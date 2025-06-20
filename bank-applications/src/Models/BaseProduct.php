<?php

namespace BankApplication\Models;

abstract class BaseProduct
{
    protected $type;
    protected $openDate;
    protected $closeDate;
    protected $term;

    public function __construct($openDate, $closeDate, $term)
    {
        $this->openDate = $openDate;
        $this->closeDate = $closeDate;
        $this->term = $term;
    }

    public function getType()
    {
        return $this->type;
    }

    abstract public function getData();
}