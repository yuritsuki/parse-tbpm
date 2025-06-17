# app/Dockerfile
FROM php:8.2-cli

# Install system dependencies
RUN apt-get update && apt-get install -y \
    libzip-dev \
    libxml2-dev \
    libpng-dev \
    libonig-dev \
    libjpeg-dev \
    libfreetype6-dev \
    zip \
    unzip \
    curl \
    git \
    mariadb-client \
    sshpass  \
    procps \
    telnet \
    iproute2 \
    iputils-ping \
    && export EXTRA_CFLAGS="-I/usr/src/php" \
    && docker-php-ext-configure gd --with-freetype --with-jpeg \
    && docker-php-ext-install \
      mbstring  \
      pdo_mysql \
      zip \
      dom \
      xml \
      gd \
      iconv \
      simplexml \
      xmlreader

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
