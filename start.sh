#!/bin/bash
set -e

# Instalar dependencias de PHP
composer install --no-dev --optimize-autoloader

# Generar la clave de la app (si no existe)
php artisan key:generate --force

# Ejecutar migraciones (si tienes base de datos configurada)
# php artisan migrate --force

# Iniciar el servidor en el puerto que Railway espera (8080)
php artisan serve --host 0.0.0.0 --port 8000
