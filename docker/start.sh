#!/bin/sh
# NEW: Startup script — dijalankan setiap kali container Render start/restart
set -e

cd /var/www/html

echo "==> Caching konfigurasi Laravel..."
php artisan config:cache
php artisan route:cache
php artisan view:cache

echo "==> Menjalankan migration database (aman dijalankan berulang kali)..."
php artisan migrate --force

echo "==> Membuat symlink storage (untuk avatar/file publik, kalau ada)..."
php artisan storage:link || true

echo "==> Semua siap. Menyalakan Nginx + PHP-FPM..."
exec supervisord -c /etc/supervisor/conf.d/supervisord.conf
