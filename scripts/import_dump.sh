#!/usr/bin/env bash
set -euo pipefail

# Import local SQL dump (database/greenhabit.sql) into remote MySQL using env vars.
# Usage: export DB_HOST=... DB_DATABASE=... DB_USERNAME=... DB_PASSWORD=...; ./scripts/import_dump.sh

SQL_FILE="database/greenhabit.sql"
if [ ! -f "$SQL_FILE" ]; then
  echo "SQL file not found: $SQL_FILE"
  exit 1
fi

if [ -z "${DB_HOST:-}" ] || [ -z "${DB_DATABASE:-}" ] || [ -z "${DB_USERNAME:-}" ]; then
  echo "Please set DB_HOST, DB_DATABASE and DB_USERNAME environment variables before running."
  exit 1
fi

DB_PORT=${DB_PORT:-3306}

if [ -z "${DB_PASSWORD:-}" ]; then
  read -s -p "Enter DB password for $DB_USERNAME: " DB_PASSWORD
  echo
fi

echo "Importing $SQL_FILE into $DB_DATABASE@$DB_HOST:$DB_PORT ..."
gunzip -c "$SQL_FILE" 2>/dev/null || cat "$SQL_FILE" | mysql -h "$DB_HOST" -P "$DB_PORT" -u "$DB_USERNAME" -p"$DB_PASSWORD" "$DB_DATABASE"

echo "Import finished."
