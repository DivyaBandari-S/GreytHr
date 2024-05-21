<?php

namespace App\Services;

use Google\Client;
use Google\Service\Drive;
use Exception;
use Google\Service\Drive\DriveFile;
use Illuminate\Support\Facades\Auth;
class GoogleDriveService
{
    protected $client;
    protected $drive;

    public function __construct()
    {
        $this->client = new Client();
        $this->setupClient();
        $this->drive = new Drive($this->client);
    }

    private function setupClient()
    {
        $this->client->setClientId('356158765864-5vco9p8sheimcomubcq2as37131qri40.apps.googleusercontent.com');
        $this->client->setClientSecret('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');
        $this->client->setRedirectUri('https://s6.payg-india.com/google-callback');
        $this->client->addScope(Drive::DRIVE);
        $this->client->setAccessType('offline');
        $this->client->setPrompt('select_account consent');
    }

    public function redirectToGoogleOAuth()
    {
        $authUrl = $this->client->createAuthUrl();
        return redirect()->away($authUrl); // Use `redirect()->away()` for external URLs in Laravel
    }


    public function handleGoogleOAuthCallback()
    {
        if (!isset($_GET['code'])) {
            throw new Exception("Authorization code not provided");
        }
        $token = $this->client->fetchAccessTokenWithAuthCode($_GET['code']);
        if (isset($token['error'])) {
            throw new Exception("Error retrieving access token: " . $token['error']);
        }
        $this->saveAccessToken($token);
        $this->client->setAccessToken($token);
    }

    public function saveAccessToken($accessToken)
    {
        file_put_contents('token.json', json_encode($accessToken));
        if (isset($accessToken['refresh_token'])) {
            $this->saveRefreshToken($accessToken['refresh_token']);
        }
    }

    public function refreshAccessToken()
    {
        $refreshToken = $this->getRefreshToken();
        if (!$refreshToken) {
            throw new Exception("No refresh token available. Please re-authorize.");
            // Redirect user to re-authorize
            return $this->redirectToGoogleOAuth();
        }
        $accessToken = $this->client->fetchAccessTokenWithRefreshToken($refreshToken);
        if (isset($accessToken['error'])) {
            throw new Exception("Failed to refresh access token: " . $accessToken['error']);
        }
        $this->saveAccessToken($accessToken);
    }

    public function uploadFile($filePath, $fileName, $mimeType, $folderName) {
        $this->loadAccessToken();
        try {
            $folderId = $this->findOrCreateFolder($folderName);
            $filesInFolder = $this->listFilesInFolder($folderId);
    
            if (!empty($filesInFolder)) {
                $fileId = $filesInFolder[0]->id;  // Assumes the first file is the target
                $file = new DriveFile();
                $file->setName($fileName);
                $file->setMimeType($mimeType);
    
                $result = $this->drive->files->update($fileId, $file, [
                    'data' => file_get_contents($filePath),
                    'uploadType' => 'multipart',
                    'fields' => 'id'
                ]);
            } else {
                // Folder is empty, create new file
                $file = new DriveFile();
                $file->setName($fileName);
                $file->setParents([$folderId]);
                $file->setMimeType($mimeType);
    
                $result = $this->drive->files->create($file, [
                    'data' => file_get_contents($filePath),
                    'uploadType' => 'multipart',
                    'fields' => 'id'
                ]);
            }
    
            return $result->id;
        } catch (Exception $e) {
            throw new Exception("Error managing file: " . $e->getMessage());
        }
    }
    
    private function findOrCreateFolder($folderName) {
        $this->loadAccessToken();
        $query = "mimeType='application/vnd.google-apps.folder' and name='" . $folderName . "' and trashed=false";
        $response = $this->drive->files->listFiles([
            'q' => $query,
            'spaces' => 'drive',
            'fields' => 'files(id, name)'
        ]);

        if (count($response->files) > 0) {
            return $response->files[0]->id;
        } else {
            $folderMetadata = new DriveFile([
                'name' => $folderName,
                'mimeType' => 'application/vnd.google-apps.folder'
            ]);
            $folder = $this->drive->files->create($folderMetadata, ['fields' => 'id']);
            return $folder->id;
        }
    }

    private function listFilesInFolder($folderId) {
        $query = "'" . $folderId . "' in parents and trashed=false";
        $response = $this->drive->files->listFiles([
            'q' => $query,
            'spaces' => 'drive',
            'fields' => 'files(id, name)'
        ]);
        return $response->files;
    }
    public function loadAccessToken()
    {
        if (file_exists('token.json')) {
            $accessToken = json_decode(file_get_contents('token.json'), true);
            $this->client->setAccessToken($accessToken);
        }

        if ($this->client->isAccessTokenExpired()) {
            $this->refreshAccessToken();
        }
    }

    private function saveRefreshToken($refreshToken)
    {
        file_put_contents('refresh_token.json', json_encode(['refresh_token' => $refreshToken]));
    }

    private function getRefreshToken()
    {
        if (file_exists('refresh_token.json')) {
            $data = json_decode(file_get_contents('refresh_token.json'), true);
            return $data['refresh_token'] ?? null;
        }
        return null;
    }

    public function getImageUrlOrContent() {
        $empId = Auth::guard('emp')->user()->emp_id;
        $folderName = 'auth_' . $empId; 
        $this->loadAccessToken();
        $folderId = $this->findOrCreateFolder($folderName);
        $filesInFolder = $this->listFilesInFolder($folderId);
    
        if (!empty($filesInFolder)) {
            $fileId = $filesInFolder[0]->id;  // Assumes the first file is the target
            $response = $this->drive->files->get($fileId, ['alt' => 'media']);
            return $response->getBody()->getContents();
        }
    
        return null;  // No image found
    }
    
}