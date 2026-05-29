FROM php:8.3-apache

RUN apt-get update && apt-get install -y \
    libpq-dev nodejs npm \
    && docker-php-ext-install pdo pdo_pgsql \
    && a2enmod rewrite

COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

WORKDIR /var/www/html
COPY . .

RUN composer install --no-dev --optimize-autoloader \
    && npm install \
    && npm run build \
    && chmod -R 775 storage bootstrap/cache \
    && chown -R www-data:www-data storage bootstrap/cache

ENV APACHE_DOCUMENT_ROOT /var/www/html/public

RUN sed -i 's!/var/www/html!/var/www/html/public!g' /etc/apache2/sites-available/000-default.conf

EXPOSE 80

CMD sh -c "php artisan config:clear && php artisan migrate --force && php artisan storage:link && apache2-foreground"