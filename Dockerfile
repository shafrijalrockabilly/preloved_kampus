FROM bitnami/laravel:11

WORKDIR /app
COPY . .

RUN composer install --no-dev --optimize-autoloader
RUN npm install && npm run build

CMD ["php", "artisan", "serve", "--host=0.0.0.0", "--port=10000"]