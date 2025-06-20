<?php

namespace BankApplication\Repositories;

use PDO;
use BankApplication\Models\Application;
use BankApplication\Models\IndividualClient;
use BankApplication\Models\LegalClient;

class ApplicationRepository
{
    private $db;

    public function __construct(PDO $db)
    {
        $this->db = $db;
    }

    public function save(Application $application)
    {

        $client = $application->getClient();
        $product = $application->getProduct();

        try {
            $this->db->beginTransaction();

            // Сохраняем реквизиты клиента
            if ($client->getType() === 'individual') {
                $stmt = $this->db->prepare("
                    INSERT INTO individual_requisites 
                    (full_name, birth_date, passport_series, passport_number, passport_issue_date) 
                    VALUES (?, ?, ?, ?, ?)
                ");
                $stmt->execute([
                    $client->getData()['full_name'],
                    $client->getData()['birth_date'],
                    $client->getData()['passport_series'],
                    $client->getData()['passport_number'],
                    $client->getData()['passport_issue_date']
                ]);
                $requisitesId = $this->db->lastInsertId();

                // Обновляем requisites_id в объекте клиента
                $client = new IndividualClient(
                    $client->getData()['full_name'],
                    $client->getInn(),
                    $client->getData()['birth_date'],
                    $client->getData()['passport_series'],
                    $client->getData()['passport_number'],
                    $client->getData()['passport_issue_date'],
                    $requisitesId
                );
            } else {
                $stmt = $this->db->prepare("
                    INSERT INTO legal_requisites 
                    (director_full_name, director_inn, company_name, company_address, ogrn, company_inn, kpp) 
                    VALUES (?, ?, ?, ?, ?, ?, ?)
                ");
                $stmt->execute([
                    $client->getData()['director_full_name'],
                    $client->getData()['director_inn'],
                    $client->getData()['company_name'],
                    $client->getData()['company_address'],
                    $client->getData()['ogrn'],
                    $client->getData()['company_inn'],
                    $client->getData()['kpp']
                ]);
                $requisitesId = $this->db->lastInsertId();

                // Обновляем requisites_id в объекте клиента
                $client = new LegalClient(
                    $client->getData()['director_full_name'],
                    $client->getData()['director_inn'],
                    $client->getData()['company_name'],
                    $client->getData()['company_address'],
                    $client->getData()['ogrn'],
                    $client->getData()['company_inn'],
                    $client->getData()['kpp'],
                    $requisitesId
                );
            }

            // Сохраняем клиента
            $stmt = $this->db->prepare("
                INSERT INTO clients 
                (type, inn, requisites_id, created_at) 
                VALUES (?, ?, ?, ?)
            ");
            $stmt->execute([
                $client->getType(),
                $client->getInn(),
                $client->getRequisitesId(),
                $application->getCreatedAt()
            ]);
            $clientId = $this->db->lastInsertId();

            // Сохраняем продукт
            if ($product->getType() === 'credit') {
                $stmt = $this->db->prepare("
                    INSERT INTO credit_products 
                    (open_date, close_date, term, payment_schedule, amount, created_at) 
                    VALUES (?, ?, ?, ?, ?, ?)
                ");
                $stmt->execute([
                    $product->getData()['open_date'],
                    $product->getData()['close_date'],
                    $product->getData()['term'],
                    $product->getData()['payment_schedule'],
                    $product->getData()['amount'],
                    $application->getCreatedAt()
                ]);
                $productId = $this->db->lastInsertId();
            } else {
                $stmt = $this->db->prepare("
                    INSERT INTO deposit_products 
                    (open_date, close_date, term, interest_rate, capitalization, created_at) 
                    VALUES (?, ?, ?, ?, ?, ?)
                ");
                $stmt->execute([
                    $product->getData()['open_date'],
                    $product->getData()['close_date'],
                    $product->getData()['term'],
                    $product->getData()['interest_rate'],
                    $product->getData()['capitalization'],
                    $application->getCreatedAt()
                ]);
                $productId = $this->db->lastInsertId();
            }

            // Сохраняем заявку
            $stmt = $this->db->prepare("
                INSERT INTO applications 
                (client_id, product_type, product_id, created_at) 
                VALUES (?, ?, ?, ?)
            ");
            $stmt->execute([
                $clientId,
                $product->getType(),
                $productId,
                $application->getCreatedAt()
            ]);

            $app_id = $this->db->lastInsertId('client_id');
            $this->db->commit();

            return $app_id;
        } catch (Exception $e) {
            $this->db->rollBack();
            throw $e;
        }
    }

    public function findApplicationById($id)
    {
        try {
            $stmt = $this->db->prepare("
                SELECT 
                    a.id as application_id,
                    a.created_at as application_created_at,
                    c.id as client_id,
                    c.type as client_type,
                    c.inn as client_inn,
                    p.type as product_type,
                    p.id as product_id,
                    p.created_at as product_created_at
                FROM applications a
                JOIN clients c ON a.client_id = c.id
                JOIN (
                    SELECT id, 'credit' as type, created_at FROM credit_products
                    UNION ALL
                    SELECT id, 'deposit' as type, created_at FROM deposit_products
                ) p ON a.product_id = p.id AND a.product_type = p.type
                WHERE a.id = ?
            ");
            $stmt->execute([$id]);
            $application = $stmt->fetch(PDO::FETCH_ASSOC);

            if (!$application) {
                return null;
            }

            // Получаем данные клиента
            if ($application['client_type'] === 'individual') {
                $stmt = $this->db->prepare("
                    SELECT c.*, ir.* 
                    FROM clients c
                    JOIN individual_requisites ir ON c.requisites_id = ir.id
                    WHERE c.id = ?
                ");
            } else {
                $stmt = $this->db->prepare("
                    SELECT c.*, lr.* 
                    FROM clients c
                    JOIN legal_requisites lr ON c.requisites_id = lr.id
                    WHERE c.id = ?
                ");
            }
            $stmt->execute([$application['client_id']]);
            $clientData = $stmt->fetch(PDO::FETCH_ASSOC);

            // Получаем данные продукта
            if ($application['product_type'] === 'credit') {
                $stmt = $this->db->prepare("SELECT * FROM credit_products WHERE id = ?");
            } else {
                $stmt = $this->db->prepare("SELECT * FROM deposit_products WHERE id = ?");
            }
            $stmt->execute([$application['product_id']]);
            $productData = $stmt->fetch(PDO::FETCH_ASSOC);

            return [
                'application' => $application,
                'client' => $clientData,
                'product' => $productData
            ];
        } catch (Exception $e) {
            throw $e;
        }
    }
}