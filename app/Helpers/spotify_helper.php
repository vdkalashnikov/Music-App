<?php

if (!function_exists('getSpotifyAccessToken')) {
    function getSpotifyAccessToken()
    {
        $clientId = 'ea0026f18ed44bd4aea8652c78d428d9';
        $clientSecret = '8f706e81a34146e499eb68ff48c7cb91';
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
    function fetchSpotifyTracks($accessToken, $query, $type = 'track', $limit = 10)
    {
        $url = 'https://api.spotify.com/v1/search?q=' . urlencode($query) . '&type=' . $type . '&limit=' . $limit;

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

function fetchSpotifyPlaylists($accessToken, $query, $type = 'playlist', $limit = 8) {
    $url = 'https://api.spotify.com/v1/search?q=' . urlencode($query) . '&type=' . $type . '&limit=' . $limit;
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




?>
