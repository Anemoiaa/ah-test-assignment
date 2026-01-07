FROM php:8.1-fpm

ARG UID=1000
ARG GID=1000

RUN apt-get update && apt-get install -y \
    git \
    curl \
    zip \
    unzip \
    libicu-dev \
    libzip-dev \
    libgmp-dev \
    libonig-dev \
    && rm -rf /var/lib/apt/lists/*

RUN docker-php-ext-configure intl \
 && docker-php-ext-install \
    pdo \
    pdo_mysql \
    mbstring \
    intl \
    zip \
    gmp

RUN groupadd -g ${GID} appuser \
 && useradd -u ${UID} -g appuser -m appuser

COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

WORKDIR /var/www/html

COPY . .

RUN chown -R appuser:appuser /var/www/html

RUN composer install --no-dev --optimize-autoloader

USER appuser

EXPOSE 9000

CMD ["php-fpm"]