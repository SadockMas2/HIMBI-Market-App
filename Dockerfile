# Base PHP avec Apache
FROM php:8.2-apache

# Installe Node.js (v18), npm, extensions PHP nécessaires
RUN apt-get update && apt-get install -y \
    curl \
    git \
    unzip \
    libzip-dev \
    gnupg \
    && docker-php-ext-install zip pdo pdo_mysql \
    && curl -fsSL https://deb.nodesource.com/setup_18.x | bash - \
    && apt-get install -y nodejs

# Installer Composer
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

# Activer mod_rewrite pour Laravel
RUN a2enmod rewrite

# Définir le dossier de travail
WORKDIR /var/www/html

# Copier les fichiers du projet
COPY . .

# Définir le bon DocumentRoot vers le dossier /public
RUN sed -i 's|DocumentRoot /var/www/html|DocumentRoot /var/www/html/public|g' /etc/apache2/sites-available/000-default.conf

# Installer les dépendances Laravel
RUN composer install --no-dev --optimize-autoloader

# Compiler les assets Vite
RUN npm install && npm run build

# Fixer les permissions
RUN chown -R www-data:www-data /var/www/html \
    && chmod -R 755 /var/www/html/storage \
    && chmod -R 755 /var/www/html/bootstrap/cache

# Exposer le port web
EXPOSE 80

# Démarrer Apache
CMD ["apache2-foreground"]
