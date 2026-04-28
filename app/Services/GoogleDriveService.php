<?php

namespace App\Services;

use Google\Client;
use Google\Service\Drive;
use Google\Service\Drive\DriveFile;

class GoogleDriveService
{
    protected $service;
    protected $folderId;

    public function __construct()
    {
        $credentialsPath = base_path(env('GOOGLE_DRIVE_CREDENTIALS'));
        $this->folderId  = env('GOOGLE_DRIVE_FOLDER_ID');

        $client = new Client();
        $client->setAuthConfig($credentialsPath);
        $client->addScope(Drive::DRIVE);
        $client->setHttpClient(new \GuzzleHttp\Client([
            'verify' => false
        ]));

        $this->service = new Drive($client);
    }

    public function upload($filePath, $fileName, $mimeType = null)
    {
        $fileMetadata = new DriveFile([
            'name'    => $fileName,
            'parents' => [$this->folderId]
        ]);

        $content = file_get_contents($filePath);

        if (!$mimeType) {
            $mimeType = mime_content_type($filePath);
        }

        $file = $this->service->files->create($fileMetadata, [
            'data'               => $content,
            'mimeType'           => $mimeType,
            'uploadType'         => 'multipart',
            'fields'             => 'id, name, webViewLink',
            'supportsAllDrives'  => true,
            'supportsTeamDrives' => true,
        ]);

        return $file;
    }

    public function delete($fileId)
    {
        try {
            $this->service->files->delete($fileId, [
                'supportsAllDrives'  => true,
                'supportsTeamDrives' => true,
            ]);
            return true;
        } catch (\Exception $e) {
            return false;
        }
    }

    public function getFile($fileId)
    {
        return $this->service->files->get($fileId, [
            'alt'                => 'media',
            'supportsAllDrives'  => true,
            'supportsTeamDrives' => true,
        ]);
    }

    public function getWebViewLink($fileId)
    {
        $file = $this->service->files->get($fileId, [
            'fields'             => 'webViewLink, webContentLink',
            'supportsAllDrives'  => true,
            'supportsTeamDrives' => true,
        ]);
        return $file->getWebViewLink();
    }
}