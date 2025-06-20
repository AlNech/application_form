<?php

namespace BankApplication\Models;

require_once('BaseProduct.php');

class CreditProduct extends BaseProduct
{
    private $paymentSchedule;
    private $amount;

    public function __construct($openDate, $closeDate, $term, $paymentSchedule, $amount)
    {
        parent::__construct($openDate, $closeDate, $term);
        $this->type = 'credit';
        $this->paymentSchedule = $paymentSchedule;
        $this->amount = $amount;
    }

    public function getData()
    {
        return [
            'open_date' => $this->openDate,
            'close_date' => $this->closeDate,
            'term' => $this->term,
            'payment_schedule' => $this->paymentSchedule,
            'amount' => $this->amount
        ];
    }
}