FROM php:7.4-fpm

#Arguments defined in docker-composer.yml
ARG user
ARG uid

#Install system dependencies
RUN apt-get update && apt-get install -y \
    iproute2 \
    curl \
    libpng-dev \
    libonig-dev \
    libxml2-dev \
    zip \
    unzip \
    libsodium-dev \
    libzip-dev \
    --no-install-recommends


#Clear cache
RUN apt-get clean && rm -rf /var/lib/apt/lists/*

#Install php extensions
RUN docker-php-ext-install pdo_mysql mbstring exif bcmath gd sodium zip

#Allow nginx to update files - Shit workaround to allow access to storage only develop
COPY . /var/www
#COPY --chmod='-R ug+rw'
COPY --chown=www-data:www-data ./storage/ /var/www/storage/
#Create system user to run Composer and Artisan Commands
RUN useradd -G www-data,root -u $uid -d /home/$user $user -l
RUN mkdir -p /home/$user/.composer && \
    chown -R $user:$user /home/$user
#Set working directory
WORKDIR /var/www

COPY --from=composer:latest /usr/bin/composer /usr/bin/composer
RUN composer install

USER $user



