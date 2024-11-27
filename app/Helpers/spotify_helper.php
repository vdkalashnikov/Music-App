<?php

if (!function_exists('getSpotifyAccessToken')) {
    function getSpotifyAccessToken()
    {
        $clientId = env('client.id.spotify');
        $clientSecret = env('client.secret.key');
        $url = 'https://accounts.spotify.com/api/token';

        $headers = [
            'Authorization: Basic ' . base64_encode($clientId . ':' . $clientSecret),
            'Content-Type: application/x-www-form-urlencoded'
        ];
        $data = 'grant_type=client_credentials';

        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_POST, 1);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $data);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
        $result = curl_exec($ch);
        curl_close($ch);

        $response = json_decode($result, true);
        return $response['access_token'] ?? null;
    }
}

if (!function_exists('fetchSpotifyTracks')) {
    function fetchSpotifyTracks($accessToken, $query, $limit = 6)
    {
        $url = 'https://api.spotify.com/v1/search?q=' . urlencode($query) . '&type=track&limit=' . $limit;

        $headers = [
            'Authorization: Bearer ' . $accessToken,
        ];

        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
        $result = curl_exec($ch);
        curl_close($ch);

        return json_decode($result, true);
    }
}


if (!function_exists('getSpotifyAlbumTracks')) {
    function getSpotifyAlbumTracks($accessToken, $albumId)
    {
        $url = 'https://api.spotify.com/v1/albums/' . $albumId;

        $headers = [
            'Authorization: Bearer ' . $accessToken,
        ];

        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
        $result = curl_exec($ch);
        curl_close($ch);

        return json_decode($result, true);
    }
}

if (!function_exists('fetchSpotifyArtists')) {
    function fetchSpotifyArtists($accessToken, $query, $limit = 6)
    {
        $url = 'https://api.spotify.com/v1/search?q=' . urlencode($query) . '&type=artist&limit=' . $limit;

        $headers = [
            'Authorization: Bearer ' . $accessToken,
        ];

        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
        $result = curl_exec($ch);
        curl_close($ch);
        

        return json_decode($result, true);
    }
}

if (!function_exists('fetchSpotifySomeArtists')) {
    function fetchSpotifySomeArtists($accessToken, $queries, $limit = 1)
    {
        $artists = [];
        foreach ($queries as $query) {
            $url = 'https://api.spotify.com/v1/search?q=' . urlencode($query) . '&type=artist&limit=' . $limit;

            $headers = [
                'Authorization: Bearer ' . $accessToken,
            ];

            $ch = curl_init();
            curl_setopt($ch, CURLOPT_URL, $url);
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
            curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
            $result = curl_exec($ch);
            curl_close($ch);

            $decodedResult = json_decode($result, true);
            if (isset($decodedResult['artists']['items'])) {
                $artists = array_merge($artists, $decodedResult['artists']['items']);
            }
        }

        return $artists;
    }
}
if (!function_exists('fetchSpotifySomeAlbums')) {
    function fetchSpotifySomeAlbums($accessToken, $queries, $limit = 1)
    {
        $albums = [];
        foreach ($queries as $query) {
            $url = 'https://api.spotify.com/v1/search?q=' . urlencode($query) . '&type=album&limit=' . $limit;

            $headers = [
                'Authorization: Bearer ' . $accessToken,
            ];

            $ch = curl_init();
            curl_setopt($ch, CURLOPT_URL, $url);
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
            curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
            $result = curl_exec($ch);
            curl_close($ch);

            $decodedResult = json_decode($result, true);
            if (isset($decodedResult['albums']['items'])) {
                $albums = array_merge($albums, $decodedResult['albums']['items']);
            }
        }

        return $albums;
    }
}

if (!function_exists('fetchSpotifySomePlaylists')) {
    function fetchSpotifySomePlaylists($accessToken, $queries, $limit = 1)
    {
        $playlists = [];
        foreach ($queries as $query) {
            $url = 'https://api.spotify.com/v1/search?q=' . urlencode($query) . '&type=playlist&limit=' . $limit;

            $headers = [
                'Authorization: Bearer ' . $accessToken,
            ];

            $ch = curl_init();
            curl_setopt($ch, CURLOPT_URL, $url);
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
            curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
            $result = curl_exec($ch);
            curl_close($ch);

            $decodedResult = json_decode($result, true);
            if (isset($decodedResult['playlists']['items'])) {
                $playlists = array_merge($playlists, $decodedResult['playlists']['items']);
            }
        }

        return $playlists;
    }
}


if (!function_exists('fetchSpotifyAlbums')) {
    function fetchSpotifyAlbums($accessToken, $query, $limit = 6)
    {
        $url = 'https://api.spotify.com/v1/search?q=' . urlencode($query) . '&type=album&limit=' . $limit;

        $headers = [
            'Authorization: Bearer ' . $accessToken,
        ];

        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
        $result = curl_exec($ch);
        curl_close($ch);

        return json_decode($result, true);
    }
}


if (!function_exists('fetchSpotifyPlaylists')) {
    function fetchSpotifyPlaylists($accessToken, $query, $limit = 6)
    {
        $url = 'https://api.spotify.com/v1/search?q=' . urlencode($query) . '&type=playlist&limit=' . $limit;

        $headers = [
            'Authorization: Bearer ' . $accessToken,
        ];

        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
        $result = curl_exec($ch);
        curl_close($ch);

        return json_decode($result, true);
    }
}





?>
