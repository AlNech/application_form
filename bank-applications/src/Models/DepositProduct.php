<?php

namespace BankApplication\Models;

class DepositProduct extends BaseProduct
{
    private $interestRate;
    private $capitalization;

    public function __construct($openDate, $closeDate, $term, $interestRate, $capitalization)
    {
        parent::__construct($openDate, $closeDate, $term);
        $this->type = 'deposit';
        $this->interestRate = $interestRate;
        $this->capitalization = $capitalization;
    }

    public function getData()
    {
        return [
            'open_date' => $this->openDate,
            'close_date' => $this->closeDate,
            'term' => $this->term,
            'interest_rate' => $this->interestRate,
            'capitalization' => $this->capitalization
        ];
    }
}