<?php
require __DIR__ . '/vendor/autoload.php';

$client = new Google\Client();
$client->setAuthConfig(__DIR__ . '/storage/app/oauth-credentials.json');
$client->addScope(Google\Service\Drive::DRIVE);
$client->setAccessType('offline');
$client->setPrompt('consent');

$authUrl = $client->createAuthUrl();
echo "===========================================\n";
echo "Buka URL ini di browser Anda:\n\n";
echo $authUrl . "\n\n";
echo "===========================================\n";
echo "Setelah login Google, akan muncul kode.\n";
echo "Masukkan kode di sini: ";
$code = trim(fgets(STDIN));

$token = $client->fetchAccessTokenWithAuthCode($code);

if (isset($token['error'])) {
    echo "Error: " . $token['error_description'] . "\n";
    exit;
}

$client->setAccessToken($token);
file_put_contents(__DIR__ . '/storage/app/google-token.json', json_encode($token));
echo "\n✓ Token berhasil disimpan!\n";
echo "Refresh token: " . ($token['refresh_token'] ?? 'tidak ada') . "\n";