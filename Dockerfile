FROM php:8.3-cli

WORKDIR /var/www

RUN apt-get update && apt-get install -y \
    git \
    unzip \
    curl \
    libpq-dev \
    zip \
    nodejs \
    npm

RUN docker-php-ext-install pdo pdo_pgsql

COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

COPY . .

RUN composer install --no-dev --optimize-autoloader

RUN npm install && npm run build

CMD php artisan serve --host=0.0.0.0 --port=$PORT