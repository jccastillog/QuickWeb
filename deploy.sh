#!/usr/bin/env bash
# Pasos posteriores a traer el código al servidor (Cloudways: Deployment via Git → Pull).
# Uso, desde la carpeta de la aplicación:  bash deploy.sh
set -euo pipefail

cd "$(dirname "$0")"

echo "→ Modo mantenimiento"
php artisan down --retry=15 || true

# Si algo falla, la tienda no debe quedar en mantenimiento
trap 'echo "✗ Falló el despliegue"; php artisan up' ERR

echo "→ Dependencias"
composer install --no-dev --optimize-autoloader --no-interaction

echo "→ Migraciones"
php artisan migrate --force

echo "→ Enlace de archivos públicos"
php artisan storage:link 2>/dev/null || true

echo "→ Cachés"
php artisan config:cache
php artisan route:cache
php artisan view:cache

php artisan up
echo "✓ Despliegue terminado"
