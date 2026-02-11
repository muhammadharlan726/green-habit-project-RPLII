Param()

# PowerShell import script for database/greenhabit.sql
# Usage (PowerShell):
# $env:DB_HOST='host'; $env:DB_DATABASE='db'; $env:DB_USERNAME='user'; $env:DB_PASSWORD='pass'; .\scripts\import_dump.ps1

$sqlFile = "database\greenhabit.sql"
if (-not (Test-Path $sqlFile)) {
  Write-Error "SQL file not found: $sqlFile"
  exit 1
}

if (-not $env:DB_HOST -or -not $env:DB_DATABASE -or -not $env:DB_USERNAME) {
  Write-Error "Please set DB_HOST, DB_DATABASE and DB_USERNAME environment variables before running."
  exit 1
}

$dbHost = $env:DB_HOST
$dbPort = if ($env:DB_PORT) { $env:DB_PORT } else { 3306 }
$dbName = $env:DB_DATABASE
$dbUser = $env:DB_USERNAME
$dbPass = $env:DB_PASSWORD

if (-not $dbPass) {
  $dbPass = Read-Host -AsSecureString "Enter DB password" 
  $BSTR = [Runtime.InteropServices.Marshal]::SecureStringToBSTR($dbPass)
  $dbPass = [Runtime.InteropServices.Marshal]::PtrToStringAuto($BSTR)
}

Write-Host "Importing $sqlFile into $dbName@$dbHost:$dbPort ..."
& mysql -h $dbHost -P $dbPort -u $dbUser -p$dbPass $dbName < $sqlFile
Write-Host "Import finished."
