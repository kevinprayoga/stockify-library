FROM php:8.1-apache

WORKDIR /var/www/html

# Install required system dependencies and intl PHP extension
RUN apt-get update && apt-get install -y \
    libicu-dev \
    libpng-dev \
    zlib1g-dev \
    libxml2-dev \
    libzip-dev \
    libonig-dev \
    zip \
    curl \
    unzip \
    && docker-php-ext-configure gd \
    && docker-php-ext-install -j$(nproc) intl \
    && docker-php-ext-configure gd \
    && docker-php-ext-install -j$(nproc) gd \
    && docker-php-ext-install pdo_mysql \
    && docker-php-ext-install mysqli \
    && docker-php-ext-install zip \
    && docker-php-source delete

# Install Node.js and npm with nvm, and link them globally
RUN curl -o- https://raw.githubusercontent.com/nvm-sh/nvm/v0.35.3/install.sh | bash \
    && export NVM_DIR="$HOME/.nvm" \
    && . "$NVM_DIR/nvm.sh" \
    && nvm install --lts \
    && nvm use --lts \
    && ln -s $NVM_DIR/versions/node/$(nvm version)/bin/node /usr/local/bin/node \
    && ln -s $NVM_DIR/versions/node/$(nvm version)/bin/npm /usr/local/bin/npm \
    && ln -s $NVM_DIR/versions/node/$(nvm version)/bin/npx /usr/local/bin/npx

# Copy the project files
COPY . .

# Enable Apache mod_rewrite
RUN a2enmod rewrite

# Set permissions for the writable directory
RUN chown -R www-data:www-data /var/www/html/writable \
    && chmod -R 775 /var/www/html/writable

# Install Node modules before running Laravel Mix
RUN npm install

# Run Laravel Mix
RUN npx mix

# Install composer
RUN curl -sS https://getcomposer.org/installer | php \
    && mv composer.phar /usr/local/bin/composer \
    && chmod +x /usr/local/bin/composer \
    && composer self-update

COPY ./vhost.conf /etc/apache2/sites-available/000-default.conf

# Expose port 80 for Apache
EXPOSE 80

# Use Apache to serve the application
CMD ["apache2-foreground"]