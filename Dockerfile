# Image officielle PHP 8.2 avec Apache
FROM php:8.2-apache

# Installer les dépendances système et PHP nécessaires
RUN apt-get update && apt-get install -y \
    libzip-dev \
    unzip \
    git \
    && docker-php-ext-install zip pdo pdo_mysql

# Installer Composer
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

# Copier tous les fichiers du projet dans le dossier web d'Apache
COPY . /var/www/html

WORKDIR /var/www/html

# Installer les dépendances Laravel sans les packages dev, optimisé
RUN composer install --no-dev --optimize-autoloader

# Donner les droits à Apache sur storage et bootstrap cache
RUN chown -R www-data:www-data storage bootstrap/cache

# Exposer le port 80 (Apache)
EXPOSE 80

# Démarrer Apache en premier plan (mode standard)
CMD ["apache2-foreground"]
