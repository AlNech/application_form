# Используем официальный образ PHP как базу
FROM php:8.1-fpm

# Устанавливаем необходимые расширения PHP
RUN docker-php-ext-install mysqli pdo pdo_mysql

# Проект будет здесь
WORKDIR /var/www/html