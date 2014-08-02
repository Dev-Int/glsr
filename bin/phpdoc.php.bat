@ECHO OFF
SET BIN_TARGET=%~dp0/../vendor/phpdocumentor/phpdocumentor/bin/phpdoc.php
php "%BIN_TARGET%" %*
