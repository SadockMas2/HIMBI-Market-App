# Image officielle PHP 8.2 avec Apache
FROM php:8.2-apache

# Installer les extensions PHP nécessaires
RUN apt-get update && apt-get install -y \
    libzip-dev \
    unzip \
    git \
    && docker-php-ext-install zip pdo pdo_mysql

# Installer Composer
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

# Activer mod_rewrite pour Laravel (routes propres)
RUN a2enmod rewrite

# Définir le dossier Laravel /public comme racine Apache
WORKDIR /var/www/html

COPY . /var/www/html

# Définir le bon DocumentRoot dans Apache
RUN sed -i 's|DocumentRoot /var/www/html|DocumentRoot /var/www/html/public|g' /etc/apache2/sites-available/000-default.conf

# Droits corrects sur les dossiers Laravel
RUN chown -R www-data:www-data /var/www/html \
    && chmod -R 755 /var/www/html/storage \
    && chmod -R 755 /var/www/html/bootstrap/cache

# Installer les dépendances Laravel
RUN composer install --no-dev --optimize-autoloader

# Exposer le port 80
EXPOSE 80

# Compilation des assets Vite
RUN npm install && npm run build


# Lancer Apache
CMD ["apache2-foreground"]
