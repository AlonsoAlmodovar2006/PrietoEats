#!/bin/sh
set -e

cd /var/www/html

echo "==> PrietoEats - Starting deployment..."

# Generate APP_KEY if not set
if [ -z "$APP_KEY" ]; then
    echo "==> Generating application key..."
    php artisan key:generate --force
fi

# Create .env from environment variables (Laravel reads env vars directly,
# but some commands need the .env file)
if [ ! -f .env ]; then
    echo "==> Creating .env from environment..."
    env | grep -E '^(APP_|DB_|SESSION_|CACHE_|QUEUE_|LOG_|MAIL_|FILESYSTEM_|REDIS_|BROADCAST_)' > .env 2>/dev/null || true
fi

# Wait for database to be ready
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

# Run migrations
echo "==> Running database migrations..."
php artisan migrate --force

# Seed database (only if products table is empty)
echo "==> Checking if seeding is needed..."
php artisan tinker --execute="exit(App\Models\Product::count() > 0 ? 0 : 1);" 2>/dev/null
if [ $? -ne 0 ]; then
    echo "==> Seeding database..."
    php artisan db:seed --force
fi

# Create storage symlink
echo "==> Creating storage link..."
php artisan storage:link --force 2>/dev/null || true

# Cache configuration for production
echo "==> Caching configuration..."
php artisan config:cache
php artisan route:cache
php artisan view:cache

# Fix permissions
chown -R www-data:www-data storage bootstrap/cache

echo "==> PrietoEats ready! Starting services..."

exec "$@"
