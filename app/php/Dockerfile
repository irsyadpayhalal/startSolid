# Use the official PHP 8.3-alpine image
FROM php:8.3-fpm-alpine

# Install system dependencies required for PHP extensions
RUN apk update && apk add --no-cache \
    oniguruma-dev \
    libpng-dev \
    libzip-dev \
    curl-dev \
    libxml2-dev \
    imap-dev \
    g++ \
    autoconf \
    make \
    freetype-dev \
    libjpeg-turbo-dev \
    libxpm-dev \
    libwebp-dev \
    icu-dev

# Install Memcached
RUN apk add --no-cache libmemcached-dev zlib-dev && \
    pecl install memcached && \
    docker-php-ext-enable memcached

RUN apk add --no-cache linux-headers

# Install PHP extensions
RUN docker-php-ext-configure gd --with-freetype --with-jpeg --with-webp && \
    docker-php-ext-install -j$(nproc) \
    pdo_mysql \
    mysqli \
    xml \
    curl \
    gd \
    imap \
    mbstring \
    opcache \
    soap \
    zip \
    intl \
    sockets

# Allow Composer to run as super user
ENV COMPOSER_ALLOW_SUPERUSER=1

# Install Composer
RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer

# Set the working directory
WORKDIR /var/www/html

# Copy the banking location code into the container
COPY . /var/www/html

# Copy the php-fpm configuration files
COPY php/php-fpm.conf /usr/local/etc/php-fpm.conf
COPY php/www.conf /usr/local/etc/php-fpm.d/www.conf

# Copy the startup script from the current directory
COPY php/startup.sh /usr/local/bin/startup.sh
RUN chmod +x /usr/local/bin/startup.sh

# Expose port 9000
EXPOSE 9000

# Set the entry point to the startup script
ENTRYPOINT ["sh", "/usr/local/bin/startup.sh"]
