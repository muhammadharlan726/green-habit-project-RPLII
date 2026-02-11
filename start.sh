#!/bin/bash
# Start script for Render / Railway

# Don't exit immediately; handle failures gracefully so container doesn't crash
echo "Start script: waiting for services and running optional setup..."

# Try migrations with a few retries (useful if DB isn't ready yet)
MAX_ATTEMPTS=10
ATTEMPT=1
while [ $ATTEMPT -le $MAX_ATTEMPTS ]; do
	echo "Attempting migrations (try $ATTEMPT/$MAX_ATTEMPTS)..."
	php artisan migrate --force --no-interaction && break
	echo "Migration attempt $ATTEMPT failed; retrying in 5s..."
	ATTEMPT=$((ATTEMPT+1))
	sleep 5
done

if [ $ATTEMPT -gt $MAX_ATTEMPTS ]; then
	echo "Migrations failed after $MAX_ATTEMPTS attempts — continuing without completing migrations."
fi

echo "Caching configuration (non-fatal)..."
php artisan config:cache || echo "config:cache failed, continuing"
php artisan route:cache || echo "route:cache failed, continuing"
php artisan view:cache || echo "view:cache failed, continuing"

echo "Creating storage link (non-fatal)..."
php artisan storage:link || echo "storage link failed, continuing"

echo "Starting application (exec)..."
# Use exec so the server becomes PID 1 and receives signals correctly
exec php artisan serve --host=0.0.0.0 --port=${PORT:-8080}
