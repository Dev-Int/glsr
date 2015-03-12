@ECHO OFF
SET BIN_TARGET=%~dp0/../vendor/h4cc/wkhtmltopdf-i386/bin/wkhtmltopdf-i386
php "%BIN_TARGET%" %*
