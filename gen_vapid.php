<?php
// Apuntar OpenSSL a su cnf en Laragon
$cnfPath = 'C:\\laragon\\bin\\php\\php-8.3.30-Win32-vs16-x64\\extras\\ssl\\openssl.cnf';
putenv('OPENSSL_CONF=' . $cnfPath);
$_ENV['OPENSSL_CONF'] = $cnfPath;

require 'vendor/autoload.php';

// Test openssl primero
$test = openssl_pkey_new([
    'curve_name' => 'prime256v1',
    'private_key_type' => OPENSSL_KEYTYPE_EC,
    'config' => $cnfPath,
]);

if (!$test) {
    while ($err = openssl_error_string()) {
        echo 'SSL Error: ' . $err . PHP_EOL;
    }
    die('OpenSSL fallo.' . PHP_EOL);
}

echo 'OpenSSL OK, generando claves VAPID...' . PHP_EOL;

// Usar la funcion de la libreria pero inyectando el config
$keys = \Minishlink\WebPush\VAPID::createVapidKeys();
echo 'VAPID_PUBLIC_KEY=' . $keys['publicKey'] . PHP_EOL;
echo 'VAPID_PRIVATE_KEY=' . $keys['privateKey'] . PHP_EOL;
