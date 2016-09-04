@ECHO OFF
setlocal DISABLEDELAYEDEXPANSION
SET BIN_TARGET=%~dp0/../vendor/phpunit/dbunit/dbunit
php "%BIN_TARGET%" %*
