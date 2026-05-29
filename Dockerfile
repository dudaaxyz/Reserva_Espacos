FROM php:8.3-fpm-alpine

WORKDIR /var/www

RUN apk add --no-cache \
    git unzip curl zip \
    libpq-dev \
    nodejs npm \
    nginx \
    supervisor

RUN docker-php-ext-install pdo pdo_pgsql

COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

COPY . .

RUN composer install --no-dev --optimize-autoloader

RUN npm install && npm run build && ls -la /var/www/public/build/assets/

RUN chown -R www-data:www-data /var/www/storage /var/www/bootstrap/cache \
    && chmod -R 775 /var/www/storage /var/www/bootstrap/cache

RUN cp .env.example .env && php artisan key:generate --force

COPY docker/nginx.conf /etc/nginx/http.d/default.conf
COPY docker/supervisord.conf /etc/supervisord.conf

EXPOSE 80

CMD ["/usr/bin/supervisord", "-c", "/etc/supervisord.conf"]