FROM php:8.2-fpm

RUN apt-get update \
    && apt-get install -y \
        libpq-dev \
        nano \
        git \
        curl \
        zlib1g-dev \
        libzip-dev \
        unzip \
        postgresql-client \
    && docker-php-ext-install pdo pdo_pgsql zip \
    && pecl install apcu \
    && docker-php-ext-enable apcu

# Set the COMPOSER_ALLOW_SUPERUSER environment variable
ENV COMPOSER_ALLOW_SUPERUSER 1

# Copy Composer from the official Composer image
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

# Create and use the same UID and GID as the host user
ARG UID
ARG GID
RUN groupadd -g ${GID} appgroup && \
    useradd -u ${UID} -g appgroup -m appuser

# Set the working directory
WORKDIR /app

# Copy the application files and set the correct ownership
COPY --chown=appuser:appgroup . /app

# Switch to the new user created with the same UID and GID as the host
USER appuser

# Command to run PHP-FPM
CMD ["php-fpm"]
