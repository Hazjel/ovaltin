FROM php:8.2-cli

# System deps
RUN apt-get update && apt-get install -y \
    git unzip curl \
    libpng-dev libjpeg-dev libfreetype6-dev \
    libonig-dev libzip-dev \
    && docker-php-ext-configure gd --with-freetype --with-jpeg \
    && docker-php-ext-install gd pdo pdo_mysql mbstring zip \
    && rm -rf /var/lib/apt/lists/*

# Node.js + npm
RUN curl -fsSL https://deb.nodesource.com/setup_20.x | bash - \
    && apt-get update && apt-get install -y nodejs \
    && rm -rf /var/lib/apt/lists/*

# Composer
COPY --from=composer:2 /usr/bin/composer /usr/bin/composer

WORKDIR /app
COPY . .

# pastikan hot ga ikut
RUN rm -f public/hot || true

# PHP deps
RUN composer install --no-interaction --optimize-autoloader --no-dev

RUN php artisan storage:link || true

# Frontend build (manifest.json dibuat)
RUN npm ci && npm run build

EXPOSE 8080

# ✅ runtime init (Railway suka "reset" folder tertentu)
CMD ["sh", "-lc", "\
  mkdir -p storage/framework/{cache,sessions,views} storage/logs bootstrap/cache public/build && \
  chmod -R 775 storage bootstrap/cache || true && \
  php artisan optimize:clear || true && \
  php -S 0.0.0.0:8080 -t public \
"]
