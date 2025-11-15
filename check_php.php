<?php
header('Content-Type: text/plain');
echo "SAPI: " . php_sapi_name() . PHP_EOL;
echo "PHP version: " . PHP_VERSION . PHP_EOL;
echo "Loaded php.ini: " . (php_ini_loaded_file() ?: 'none') . PHP_EOL;
echo "mysqli loaded: " . (extension_loaded('mysqli') ? 'yes' : 'no') . PHP_EOL;
echo "pdo_mysql loaded: " . (extension_loaded('pdo_mysql') ? 'yes' : 'no') . PHP_EOL;
