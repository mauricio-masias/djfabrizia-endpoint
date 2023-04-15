# Dockerfile
FROM diveinteractive/php81-alpine
# Install Composer
RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer
#RUN apt-get update -y && apt-get install -y libzip-dev zip && docker-php-ext-install zip