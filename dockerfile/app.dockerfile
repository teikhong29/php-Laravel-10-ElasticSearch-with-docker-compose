FROM php:8.2.13-fpm

# RUN apt-get update -y && apt-get install -y openssl zip unzip git
# RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer
# RUN docker-php-ext-install pdo_mysql
# WORKDIR /app
# COPY . /app
# RUN composer install

# CMD php artisan serve --host=0.0.0.0 --port=8181
# EXPOSE 8181

RUN apt-get update && apt-get install -y  \
    libfreetype6-dev \
    libjpeg-dev \
    libpng-dev \
    libwebp-dev \
    --no-install-recommends \
    && docker-php-ext-configure gd --with-freetype --with-jpeg \
    && docker-php-ext-install pdo_mysql -j$(nproc) gd
