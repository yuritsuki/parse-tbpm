# app/Dockerfile
FROM php:8.2-cli

# Install system dependencies
RUN apt-get update && apt-get install -y \
    libzip-dev \
    unzip \
    libpng-dev \
    libonig-dev \
    libxml2-dev \
    zip \
    curl \
    git \
    mariadb-client \
    sshpass  \
    procps \
    telnet \
    iproute2 \
    iputils-ping \
    && docker-php-ext-install pdo_mysql

# Install Composer
COPY --from=composer:2 /usr/bin/composer /usr/bin/composer

# Set working directory
WORKDIR /app

# Copy app files
COPY . .

# Установка зависимостей проекта
RUN composer install

# Set permissions (optional)
RUN chmod +x ./artisan

CMD ["php", "./application"]
