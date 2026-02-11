#!/bin/bash
# Start script for Render / Railway

# Don't exit immediately; handle failures gracefully so container doesn't crash
echo "Start script: waiting for services and running optional setup..."

# DEBUG: print DB env vars and attempt simple TCP connectivity test before migrations
echo "ENV CHECK: DB_CONNECTION=${DB_CONNECTION:-not set} DB_URL=${DB_URL:-not set} DATABASE_URL=${DATABASE_URL:-not set} DB_HOST=${DB_HOST:-not set} DB_PORT=${DB_PORT:-not set} DB_DATABASE=${DB_DATABASE:-not set} DB_USERNAME=${DB_USERNAME:-not set}"
php -r '
	$dbHost = getenv("DB_HOST");
	$dbPort = getenv("DB_PORT") ?: 3306;
	$databaseUrl = getenv("DATABASE_URL") ?: getenv("DB_URL");
	if ($databaseUrl && !$dbHost) {
		$parts = parse_url($databaseUrl);
		if ($parts !== false) {
			$dbHost = $parts["host"] ?? $dbHost;
			$dbPort = $parts["port"] ?? $dbPort;
		}
	}
	echo "Resolved DB host: " . ($dbHost ?: 'none') . " port: " . ($dbPort ?: 'none') . "\n";
	if ($dbHost) {
		$fp = @fsockopen($dbHost, (int)$dbPort, $errno, $errstr, 5);
		echo "TCP Test to {$dbHost}:{$dbPort}: " . ($fp ? "OK" : "FAILED ({$errno} {$errstr})") . "\n";
		if ($fp) fclose($fp);
	} else {
		echo "No DB host available to test.\n";
	}
' || true

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
