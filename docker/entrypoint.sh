#!/bin/sh
set -e

cd /var/www/html

echo "==> PrietoEats - Starting deployment..."

# 1. Create .env FIRST (artisan commands need it)
if [ ! -f .env ]; then
    echo "==> Creating .env from environment..."
    env | grep -E '^(APP_|DB_|SESSION_|CACHE_|QUEUE_|LOG_|MAIL_|FILESYSTEM_|REDIS_|BROADCAST_)' > .env 2>/dev/null || true
fi

# 2. Generate APP_KEY if not set (now .env exists to write into)
if [ -z "$APP_KEY" ] || [ "$APP_KEY" = "" ]; then
    echo "==> Generating application key..."
    php artisan key:generate --force
    export APP_KEY=$(grep '^APP_KEY=' .env | cut -d'=' -f2-)
fi

# 3. Wait for database to be ready
echo "==> Waiting for database connection..."
max_retries=30
counter=0
until php artisan db:monitor --databases=mysql > /dev/null 2>&1 || [ $counter -eq $max_retries ]; do
    echo "    Waiting for MySQL... ($counter/$max_retries)"
    counter=$((counter + 1))
    sleep 2
done

if [ $counter -eq $max_retries ]; then
    echo "WARNING: Could not verify database connection, proceeding anyway..."
fi

# 4. Run migrations
echo "==> Running database migrations..."
php artisan migrate --force

# 5. Seed database (only if products table is empty)
#    The "if !" prevents set -e from killing the script on non-zero exit code
echo "==> Checking if seeding is needed..."
if ! php artisan tinker --execute="exit(App\Models\Product::count() > 0 ? 0 : 1);" 2>/dev/null; then
    echo "==> Seeding database..."
    php artisan db:seed --force
fi

# 6. Create storage symlink
echo "==> Creating storage link..."
php artisan storage:link --force 2>/dev/null || true

# 7. Cache configuration for production
echo "==> Caching configuration..."
php artisan config:cache
php artisan route:cache
php artisan view:cache

# 8. Fix permissions
chown -R www-data:www-data storage bootstrap/cache

echo "==> PrietoEats ready! Starting services..."

exec "$@"
