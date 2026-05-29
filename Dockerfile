FROM php:8.3-fpm-alpine

WORKDIR /var/www

# Instala dependências do sistema
RUN apk add --no-cache \
    git unzip curl zip \
    libpq-dev \
    nodejs npm \
    nginx \
    supervisor

# Instala extensões PHP
RUN docker-php-ext-install pdo pdo_pgsql

# Instala Composer
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

# Copia o projeto
COPY . .

# Instala dependências PHP
RUN composer install --no-dev --optimize-autoloader

# Instala dependências JS e compila os assets
RUN npm install && npm run build

# Permissões do Laravel
RUN chown -R www-data:www-data /var/www/storage /var/www/bootstrap/cache
RUN chmod -R 775 /var/www/storage /var/www/bootstrap/cache

# Gera APP_KEY (necessário para funcionar)
RUN php artisan key:generate --force

# Configuração do Nginx
RUN echo 'server {
    listen 80;
    root /var/www/public;
    index index.php;
    location / {
        try_files $uri $uri/ /index.php?$query_string;
    }
    location ~ \.php$ {
        fastcgi_pass 127.0.0.1:9000;
        fastcgi_index index.php;
        include fastcgi_params;
        fastcgi_param SCRIPT_FILENAME $document_root$fastcgi_script_name;
    }
}' > /etc/nginx/http.d/default.conf

# Supervisor para rodar Nginx + PHP-FPM juntos
RUN echo '[supervisord]
nodaemon=true
[program:php-fpm]
command=php-fpm
[program:nginx]
command=nginx -g "daemon off;"' > /etc/supervisord.conf

EXPOSE 80

CMD ["/usr/bin/supervisord", "-c", "/etc/supervisord.conf"]