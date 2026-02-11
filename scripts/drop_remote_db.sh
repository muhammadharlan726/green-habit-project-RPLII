#!/usr/bin/env bash
set -euo pipefail

# Usage: set env vars then run: ./scripts/drop_remote_db.sh
# Required env vars: DB_HOST, DB_DATABASE, DB_USERNAME
# Optional: DB_PORT (default 3306), DB_PASSWORD (prompted if empty)

if [ -z "${DB_HOST:-}" ] || [ -z "${DB_DATABASE:-}" ] || [ -z "${DB_USERNAME:-}" ]; then
  echo "Please set DB_HOST, DB_DATABASE and DB_USERNAME environment variables before running."
  echo "Example: DB_HOST=host DB_DATABASE=db DB_USERNAME=user DB_PASSWORD=pass ./scripts/drop_remote_db.sh"
  exit 1
fi

DB_PORT=${DB_PORT:-3306}

if [ -z "${DB_PASSWORD:-}" ]; then
  read -s -p "Enter DB password for $DB_USERNAME: " DB_PASSWORD
  echo
fi

read -p "Are you sure you want to DROP database '$DB_DATABASE' on host '$DB_HOST'? Type 'YES' to continue: " CONFIRM
if [ "$CONFIRM" != "YES" ]; then
  echo "Aborted by user. No changes made."
  exit 0
fi

BACKUP_FILE="${DB_DATABASE}_backup_$(date +%Y%m%d%H%M%S).sql"
echo "Creating backup to $BACKUP_FILE..."
mysqldump -h "$DB_HOST" -P "$DB_PORT" -u "$DB_USERNAME" -p"$DB_PASSWORD" --single-transaction --quick --default-character-set=utf8mb4 "$DB_DATABASE" > "$BACKUP_FILE"
echo "Backup complete."

echo "Dropping and recreating database '$DB_DATABASE'..."
mysql -h "$DB_HOST" -P "$DB_PORT" -u "$DB_USERNAME" -p"$DB_PASSWORD" -e "DROP DATABASE IF EXISTS \`$DB_DATABASE\`; CREATE DATABASE \`$DB_DATABASE\` CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;"
echo "Done. Database has been dropped and recreated (empty)."

echo "You can now import a dump or run migrations. Restore backup with: mysql -h $DB_HOST -P $DB_PORT -u $DB_USERNAME -p < $BACKUP_FILE"
