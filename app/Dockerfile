FROM php:8.2-cli

# Установим зависимости, в т.ч. для MSSQL
RUN apt-get update && apt-get install -y \
    gnupg2 \
    unixodbc-dev \
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
    sshpass \
    procps \
    telnet \
    iproute2 \
    iputils-ping \
    && export EXTRA_CFLAGS="-I/usr/src/php" \
    && docker-php-ext-configure gd --with-freetype --with-jpeg \
    && docker-php-ext-install \
      mbstring \
      pdo_mysql \
      zip \
      dom \
      xml \
      gd \
      iconv \
      simplexml \
      xmlreader

# Установка драйверов sqlsrv и pdo_sqlsrv
RUN pecl install pdo_sqlsrv sqlsrv \
    && docker-php-ext-enable pdo_sqlsrv sqlsrv

# Удалим конфликтующие пакеты
RUN apt-get remove -y libodbc2 libodbcinst2 unixodbc-common
# Установка Microsoft ODBC Driver for SQL Server
RUN curl https://packages.microsoft.com/keys/microsoft.asc | apt-key add - && \
    curl https://packages.microsoft.com/config/debian/11/prod.list > /etc/apt/sources.list.d/mssql-release.list && \
    apt-get update && ACCEPT_EULA=Y apt-get install -y msodbcsql17
# Установка Composer
COPY --from=composer:2 /usr/bin/composer /usr/bin/composer

# Рабочая директория
WORKDIR /app

# Копирование файлов приложения
COPY . .

# Установка зависимостей проекта
RUN composer install

# Права на artisan (если нужно)
RUN chmod +x ./artisan

# Команда по умолчанию
CMD ["php", "./application"]
