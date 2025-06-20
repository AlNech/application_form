<?php

namespace BankApplication\Models;

require_once('BaseClient.php');
require_once('BaseProduct.php');

class Application
{
    private $client;
    private $product;
    private $createdAt;

    public function __construct(BaseClient $client, BaseProduct $product)
    {
        $this->client = $client;
        $this->product = $product;
        $this->createdAt = date('Y-m-d H:i:s');
    }

    public function getClient()
    {
        return $this->client;
    }

    public function getProduct()
    {
        return $this->product;
    }

    public function getCreatedAt()
    {
        return $this->createdAt;
    }

    public function getData()
    {
        return [
            'client_type' => $this->client->getType(),
            'client_data' => $this->client->getData(),
            'product_type' => $this->product->getType(),
            'product_data' => $this->product->getData(),
            'created_at' => $this->createdAt
        ];
    }
}