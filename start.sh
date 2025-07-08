 
#!/usr/bin/env bash

# Donne les permissions nécessaires
chmod -R 775 storage bootstrap/cache

# Migration automatique (optionnel)
php artisan migrate --force

# Cache la config, routes, vues
php artisan config:cache
php artisan route:cache
php artisan view:cache

# Démarre le serveur Laravel sur le port requis par Render
php artisan serve --host=0.0.0.0 --port=10000
