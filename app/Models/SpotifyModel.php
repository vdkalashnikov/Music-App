<?php

namespace App\Models;

use CodeIgniter\Model;

class SpotifyModel extends Model
{
    private $client_id;
    private $client_secret;
    private $access_token;

    public function __construct()
    {
        $this->client_id = 'ea0026f18ed44bd4aea8652c78d428d9';
        $this->client_secret = '8f706e81a34146e499eb68ff48c7cb91';
        $this->access_token = $this->getAccessToken();
    }

    private function getAccessToken()
    {
        // Implementasi untuk mendapatkan access token dari Spotify API
    }

    public function getAlbum($album_id)
    {
        // Implementasi untuk mendapatkan data album dari Spotify API
    }

    public function getAlbumTracks($album_id)
    {
        // Implementasi untuk mendapatkan data lagu-lagu dari Spotify API
    }
}
