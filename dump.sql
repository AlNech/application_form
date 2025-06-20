CREATE DATABASE IF NOT EXISTS applications;
USE applications;

-- Основная таблица клиентов
CREATE TABLE IF NOT EXISTS clients (
    id INT AUTO_INCREMENT PRIMARY KEY,
    type ENUM('individual', 'legal') NOT NULL,
    inn VARCHAR(20) NOT NULL,
    requisites_id INT NOT NULL COMMENT 'ID в соответствующей таблице реквизитов',
    created_at DATETIME NOT NULL,
    UNIQUE KEY (inn)
);

-- Таблица реквизитов для физических лиц
CREATE TABLE IF NOT EXISTS individual_requisites (
    id INT AUTO_INCREMENT PRIMARY KEY,
    full_name VARCHAR(255) NOT NULL,
    birth_date DATE NOT NULL,
    passport_series VARCHAR(4) NOT NULL,
    passport_number VARCHAR(6) NOT NULL,
    passport_issue_date DATE NOT NULL
);

-- Таблица реквизитов для юридических лиц
CREATE TABLE IF NOT EXISTS legal_requisites (
    id INT AUTO_INCREMENT PRIMARY KEY,
    director_full_name VARCHAR(255) NOT NULL,
    director_inn VARCHAR(20) NOT NULL,
    company_name VARCHAR(255) NOT NULL,
    company_address TEXT NOT NULL,
    ogrn VARCHAR(13) NOT NULL,
    company_inn VARCHAR(10) NOT NULL,
    kpp VARCHAR(9) NOT NULL
);

-- Таблица для кредитных продуктов
CREATE TABLE IF NOT EXISTS credit_products (
    id INT AUTO_INCREMENT PRIMARY KEY,
    open_date DATE NOT NULL,
    close_date DATE NOT NULL,
    term INT NOT NULL,
    payment_schedule ENUM('annuity', 'differentiated') NOT NULL,
    amount DECIMAL(15,2) NOT NULL,
    created_at DATETIME NOT NULL
);

-- Таблица для депозитных продуктов
CREATE TABLE IF NOT EXISTS deposit_products (
    id INT AUTO_INCREMENT PRIMARY KEY,
    open_date DATE NOT NULL,
    close_date DATE NOT NULL,
    term INT NOT NULL,
    interest_rate DECIMAL(5,2) NOT NULL,
    capitalization ENUM('end', 'monthly') NOT NULL,
    created_at DATETIME NOT NULL
);

-- Таблица заявок
CREATE TABLE IF NOT EXISTS applications (
    id INT AUTO_INCREMENT PRIMARY KEY,
    client_id INT NOT NULL,
    product_type ENUM('credit', 'deposit') NOT NULL,
    product_id INT NOT NULL,
    created_at DATETIME NOT NULL,
    FOREIGN KEY (client_id) REFERENCES clients(id)
);