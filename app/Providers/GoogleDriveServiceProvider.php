<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Storage;
use League\Flysystem\Filesystem;
use Masbug\Flysystem\GoogleDriveAdapter;
use Google\Client;
use Google\Service\Drive;

class GoogleDriveServiceProvider extends ServiceProvider
{
    public function boot(): void
    {
        Storage::extend('google', function($app, $config) {
            $credentials = json_decode(
                file_get_contents(base_path($config['credentialsPath'])), true
            );

            $client = new Client();
            $client->setAuthConfig($credentials);
            $client->addScope(Drive::DRIVE);

            $service = new Drive($client);
            $adapter = new GoogleDriveAdapter($service, $config['folder']);

            return new Filesystem($adapter);
        });
    }
}