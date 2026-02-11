# PowerShell script to backup and drop a MySQL database.
# Usage (PowerShell):
#   $env:DB_HOST='host'; $env:DB_DATABASE='db'; $env:DB_USERNAME='user'; $env:DB_PASSWORD='pass'; ./scripts/drop_remote_db.ps1

if (-not $env:DB_HOST -or -not $env:DB_DATABASE -or -not $env:DB_USERNAME) {
  Write-Error "Please set DB_HOST, DB_DATABASE and DB_USERNAME environment variables before running."
  exit 1
}

$DB_HOST = $env:DB_HOST
$DB_DATABASE = $env:DB_DATABASE
$DB_USERNAME = $env:DB_USERNAME
$DB_PASSWORD = $env:DB_PASSWORD
$DB_PORT = if ($env:DB_PORT) { $env:DB_PORT } else { 3306 }

if (-not $DB_PASSWORD) {
  $DB_PASSWORD = Read-Host -AsSecureString "Enter DB password"
  $BSTR = [Runtime.InteropServices.Marshal]::SecureStringToBSTR($DB_PASSWORD)
  $DB_PASSWORD = [Runtime.InteropServices.Marshal]::PtrToStringAuto($BSTR)
}

$confirm = Read-Host "Are you sure you want to DROP database '$DB_DATABASE' on host '$DB_HOST'? Type 'YES' to continue"
if ($confirm -ne 'YES') {
  Write-Host "Aborted by user. No changes made."
  exit 0
}

$timestamp = Get-Date -Format yyyyMMddHHmmss
$backupFile = "${DB_DATABASE}_backup_${timestamp}.sql"
Write-Host "Creating backup to $backupFile..."
& mysqldump -h $DB_HOST -P $DB_PORT -u $DB_USERNAME -p$DB_PASSWORD --single-transaction --quick --default-character-set=utf8mb4 $DB_DATABASE > $backupFile
Write-Host "Backup complete."

Write-Host "Dropping and recreating database '$DB_DATABASE'..."
$dropCmd = "DROP DATABASE IF EXISTS \`$DB_DATABASE\`; CREATE DATABASE \`$DB_DATABASE\` CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;"
& mysql -h $DB_HOST -P $DB_PORT -u $DB_USERNAME -p$DB_PASSWORD -e $dropCmd
Write-Host "Done. Database has been dropped and recreated (empty)."
Write-Host "You can now import a dump or run migrations. Restore backup with: mysql -h $DB_HOST -P $DB_PORT -u $DB_USERNAME -p < $backupFile"
