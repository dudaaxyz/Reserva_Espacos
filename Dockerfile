FROM php:8.2-fpm-alpine

RUN apk add --no-cache nginx nodejs npm postgresql-dev \
    && docker-php-ext-install pdo pdo_pgsql

COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

WORKDIR /app
COPY . .

RUN composer install --no-dev --optimize-autoloader \
    && npm install \
    && npm run build \
    && chmod -R 775 storage bootstrap/cache

COPY nginx-render.conf /etc/nginx/http.d/default.conf

EXPOSE 8080

CMD sh -c "php artisan config:clear && php artisan migrate --force && php artisan storage:link && php-fpm -D && nginx -g 'daemon off;'"