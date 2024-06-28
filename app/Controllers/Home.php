<?php

namespace App\Controllers;

use App\Models\ArtisModel;
use App\Models\LaguModel;
use App\Libraries\CiAuth;
use App\Models\UserModel;
use App\Models\AlbumModel;
use CodeIgniter\Validation\Exceptions\ValidationException;
use App\Libraries\Hash;

class Home extends BaseController
{
    protected $helpers = ['url', 'form', 'CIMail', 'CIFunctions', 'spotify_helper'];

    public function index(): string
    {
        $laguModel = new LaguModel();
        $artisModel = new ArtisModel();
        $albumModel = new AlbumModel();

        $artis = $artisModel->findAll();
        $album = $albumModel->jointoArtis()->findAll();


        $accessToken = getSpotifyAccessToken();
        $spotifySomeArtists = fetchSpotifySomeArtists($accessToken, [
            'alan walker',
            'marshmello',
            'coldplay',
            'ariana grande',
            'bruno mars',
            'billie eilish'
        ]);
        $spotifySomeAlbums = fetchSpotifySomeAlbums($accessToken, [
            'monokrom',
            'hit me hard and soft',
            'sos',
            'lover',
            'manusia',
            'eternal sunshine'
        ]);
        $spotifySomePlaylists = fetchSpotifySomePlaylists($accessToken, [
            'top 50 indonesia',
            'top 50 global',
            'top 50 usa',
            'hot hits indonesia',
            'viral 50 indonesia',
            'viral 50 global'
        ]);

        $username = session()->get('username');
        session()->set('username', $username);
        $data = [
            'pageTitle' => 'Beranda',
            'username' => $username,
            'artis' => $artis,
            'album' => $album,
            'spotifySomeAlbums' => $spotifySomeAlbums,
            'spotifySomeArtists' => $spotifySomeArtists,
            'spotifySomePlaylists' => $spotifySomePlaylists,
            'accessToken' => $accessToken
        ];

        return view('home', $data);
    }
    public function spotifyAlbum($albumId)
    {
        $accessToken = getSpotifyAccessToken();
        $album = getSpotifyAlbumTracks($accessToken, $albumId);

        $jumlahLagu = count($album['tracks']['items']);
        $totalDurationMs = array_reduce($album['tracks']['items'], function ($carry, $track) {
            return $carry + $track['duration_ms'];
        }, 0);

        $totalSeconds = $totalDurationMs / 1000;
        $hours = floor($totalSeconds / 3600);
        $minute = floor(($totalSeconds % 3600) / 60);
        $seconds = $totalSeconds % 60;

        if ($hours > 0) {
            $totalDuration = sprintf('%02d jam %02d menit %02d detik', $hours, $minute, $seconds);
        } else if ($hours == 0 && $minute > 0) {
            $totalDuration = sprintf('%02d menit %02d detik', $minute, $seconds);
        } else {
            $totalDuration = sprintf('%02d detik', $seconds);
        }

        $artistName = $album['artists'][0]['name'];
        $albumName = $album['name'];
        $pageTitle = $albumName . ' - ' . $artistName;

        $data = [
            'album' => $album,
            'lagu' => $album['tracks']['items'],
            'jumlahLagu' => $jumlahLagu,
            'totalDuration' => $totalDuration,
            'pageTitle' => $pageTitle
        ];

        return view('listmusicalbumsp', $data);
    }


    public function spotifyTrack($trackId)
{
    $accessToken = getSpotifyAccessToken();
    $url = 'https://api.spotify.com/v1/tracks/' . $trackId;

    $headers = [
        'Authorization: Bearer ' . $accessToken,
    ];

    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, $url);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
    $result = curl_exec($ch);
    curl_close($ch);

    $track = json_decode($result, true);

    $referer = $this->request->getServer('HTTP_REFERER');
    $isArtistPage = strpos($referer, 'spotifyArtist') !== false;
    $isAlbumPage = strpos($referer, 'spotify/album') !== false;
    $isPlaylistPage = strpos($referer, 'spotify/playlist') !== false;

    $playlistId = null;
    $playlistName = null;

    if ($isPlaylistPage) {
        $urlComponents = explode('/', $referer);
        $playlistId = end($urlComponents);

        // Get playlist details to fetch the playlist name
        $playlistUrl = 'https://api.spotify.com/v1/playlists/' . $playlistId;
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $playlistUrl);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
        $playlistResult = curl_exec($ch);
        curl_close($ch);

        $playlist = json_decode($playlistResult, true);
        $playlistName = $playlist['name'];
    }

    if ($isArtistPage) {
        $artistName = $track['artists'][0]['name'];
        $pageTitle = $artistName . ' - ' . $track['name'];
    } elseif ($isAlbumPage) {
        $albumId = $track['album']['id'];

        $albumUrl = 'https://api.spotify.com/v1/albums/' . $albumId;
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $albumUrl);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
        $albumResult = curl_exec($ch);
        curl_close($ch);

        $album = json_decode($albumResult, true);
        $albumName = $album['name'];
        $pageTitle = $albumName . ' - ' . $track['name'];
    } elseif ($isPlaylistPage) {
        $pageTitle = $playlistName . ' - ' . $track['name'];
    } else {
        $pageTitle = $track['name'];
    }

    $data = [
        'track' => $track,
        'pageTitle' => $pageTitle,
        'isArtistPage' => $isArtistPage,
        'isAlbumPage' => $isAlbumPage,
        'isPlaylistPage' => $isPlaylistPage,
        'playlistId' => $playlistId
    ];

    return view('spotify_track', $data);
}



    public function spotifyArtist($artistId)
    {
        $accessToken = getSpotifyAccessToken();
        $artistUrl = 'https://api.spotify.com/v1/artists/' . $artistId;
        $tracksUrl = 'https://api.spotify.com/v1/artists/' . $artistId . '/top-tracks';


        $headers = ['Authorization: Bearer ' . $accessToken];

        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $artistUrl);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
        $artistResult = curl_exec($ch);
        curl_close($ch);

        $artist = json_decode($artistResult, true);


        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $tracksUrl);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
        $tracksResult = curl_exec($ch);
        curl_close($ch);

        $tracks = json_decode($tracksResult, true)['tracks'];

        $data = [
            'artist' => $artist,
            'tracks' => $tracks,
            'pageTitle' => $artist['name'],
        ];

        return view('listmusicartsp', $data);
    }

    public function spotifyPlaylist($playlistId)
    {
        $accessToken = getSpotifyAccessToken();
        $playlistUrl = 'https://api.spotify.com/v1/playlists/' . $playlistId;


        $headers = ['Authorization: Bearer ' . $accessToken];

        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $playlistUrl);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
        $playlistResult = curl_exec($ch);
        curl_close($ch);

        $playlist = json_decode($playlistResult, true);
        $tracks = $playlist['tracks']['items'];


        $totalDurationMs = 0;
        foreach ($tracks as $trackItem) {
            $totalDurationMs += $trackItem['track']['duration_ms'];
        }

        $totalSeconds = $totalDurationMs / 1000;
        $hours = floor($totalSeconds / 3600);
        $minutes = floor(($totalSeconds % 3600) / 60);
        $seconds = $totalSeconds % 60;

        $totalDuration = sprintf('%02d jam %02d menit %02d detik', $hours, $minutes, $seconds);

        $data = [
            'playlist' => $playlist,
            'tracks' => $tracks,
            'pageTitle' => $playlist['name'],
            'totalTracks' => count($tracks),
            'totalDuration' => $totalDuration,
        ];

        return view('listplaylistsp', $data);
    }


    public function laguById($id_lagu = null)
    {
        $laguModel = new LaguModel();
        
       
        $laguList = $laguModel->joinArtis()->findAll();
        
        if ($id_lagu !== null) {
            $currentLagu = $laguModel->joinArtis()->find($id_lagu);
        } else {        
            $currentLagu = !empty($laguList) ? $laguList[0] : null;
        }

        $data = [
            'currentLagu' => $currentLagu,
            'laguList' => $laguList,
            'pageTitle' => $currentLagu['nama_lagu'] ?? 'Lagu tidak ditemukan'
        ];

        return view('lagu2', $data);
    }


    public function lagu($id_artis = null, $id_lagu = null)
    {
        $laguModel = new LaguModel();
        $artisModel = new ArtisModel();
        $albumModel = new AlbumModel();

        if ($id_artis !== null) {
            $laguList = $laguModel->getLaguListByArtis($id_artis);
            $currentLagu = $laguModel->getLaguById($id_lagu);
            $artis = $artisModel->find($id_artis);
        } else {
            $laguList = [];
            $currentLagu = null;
            $artis = null;
        }

        if ($artis !== null && $currentLagu !== null) {
            $pageTitle = $artis['nama'] . " - " . $currentLagu['nama_lagu'];
        } elseif ($currentLagu !== null) {
            $pageTitle = $currentLagu['nama_lagu'];
        } else {
            $pageTitle = "Lagu";
        }

        $data = [
            'laguList' => $laguList,
            'currentLagu' => $currentLagu,
            'artis' => $artis,
            'album' => null,
            'pageTitle' => $pageTitle
        ];
        return view('lagu', $data);
    }


    public function laguByAlbum($id_album = null, $id_lagu = null)
    {
        $laguModel = new LaguModel();
        $albumModel = new AlbumModel();

        if ($id_album !== null) {
            $laguList = $laguModel->getLaguListByAlbum($id_album);
            $currentLagu = $laguModel->getLaguById($id_lagu);
            $album = $albumModel->jointoArtis()->find($id_album);
        } else {
            $laguList = [];
            $currentLagu = null;
            $album = null;
        }

        if ($album !== null && $currentLagu !== null) {
            $pageTitle = $album['nama_album'] . " - " . $currentLagu['nama_lagu'];
        } elseif ($currentLagu !== null) {
            $pageTitle = $currentLagu['nama_lagu'];
        } else {
            $pageTitle = "Lagu";
        }

        $data = [
            'laguList' => $laguList,
            'currentLagu' => $currentLagu,
            'album' => $album,
            'artis' => null,
            'pageTitle' => $pageTitle
        ];
        return view('lagu', $data);
    }


    public function getSongs()
    {
        $laguModel = new LaguModel();
        $lagu = $laguModel->joinArtis()->joinAlbum()->findAll();

        return $this->response->setJSON($lagu);
    }

    public function artis($id_artis)
    {
        $artisModel = new ArtisModel();
        $artis = $artisModel->find($id_artis);

        $laguModel = new LaguModel();
        $lagu = $laguModel->getLaguListByArtis($id_artis);

        $data = [
            'artis' => $artis,
            'lagu' => $lagu,
            'pageTitle' => isset($artis['nama']) ? $artis['nama'] : 'Artis'
        ];

        return view('listmusicart', $data);
    }
    public function album($id_album)
    {
        $albumModel = new AlbumModel();
        $artisModel = new ArtisModel();
        $album = $albumModel->jointoArtis()->where('album.id_album', $id_album)->first();

        $laguModel = new LaguModel();
        $lagu = $laguModel->getLaguListByAlbum($id_album);
        $jumlahLagu = $laguModel->countLaguByAlbum($id_album);
        $totalDuration = $laguModel->getTotalDurationByAlbum($id_album);

        $data = [
            'album' => $album,
            'lagu' => $lagu,
            'artis' => $artisModel,
            'jumlahLagu' => $jumlahLagu,
            'totalDuration' => $totalDuration,
            'pageTitle' => isset($album['nama_album']) ? $album['nama_album'] : 'Album'
        ];

        return view('listmusicalbum', $data);
    }


    public function logoutUserHandler()
    {
        CiAuth::forget();
        return redirect()->route('user.login.form')->with('fail', 'You Are Logged Out!');
    }

    public function profile()
    {
        $username = session()->get('username');
        $name = session()->get('name');
        $email = session()->get('email');
        $picture = session()->get('picture');
        $bio = session()->get('bio');

        $pageTitle = isset($name) ? 'Profile - ' . $name : $username;

        $data = [
            'pageTitle' => $pageTitle,
            'username' => $username,
            'name' => $name,
            'email' => $email,
            'picture' => $picture,
            'bio' => $bio,

        ];
        return view('profile', $data);
    }

    public function updateProfile()
    {
        $validation = \Config\Services::validation();

        $data = [
            'name' => $this->request->getPost('name'),
            'username' => $this->request->getPost('username'),
            'email' => $this->request->getPost('email'),
            'bio' => $this->request->getPost('bio'),
        ];

        $validation->setRules([
            'name' => 'required|min_length[3]|max_length[50]',
            'username' => 'required|min_length[4]|is_unique[user.username,id,{id}]|max_length[50]',
            'email' => 'required|min_length[4]|is_unique[user.email,id,{id}]',
            'bio' => 'max_length[255]',
        ]);

        if (!$validation->run($data)) {
            return redirect()->route('user.profile')->with('fail', $validation->listErrors());
        }

        $userModel = new UserModel();
        $userId = CiAuth::id();

        if ($userModel->update($userId, $data)) {
            return redirect()->route('user.profile')->with('success', 'Profile berhasil diperbarui.');
        } else {
            return redirect()->route('user.profile')->with('fail', 'Profile gagal diperbarui.');
        }
    }

    public function updateProfilePicture()
    {
        $request = \Config\Services::request();
        $user_id = CiAuth::id();
        $user = new UserModel();
        $user_info = $user->asObject()->where('id', $user_id)->first();

        $path = 'imagepro/user/';
        $file = $request->getFile('user_profile_file');
        $old_picture = $user_info->picture;
        $new_filename = 'UIMG' . $user_id . $file->getRandomName();


        $upload_image = \Config\Services::image()
            ->withFile($file)
            ->resize(450, 450, true, 'height')
            ->save($path . $new_filename);

        if ($upload_image) {
            if ($old_picture != null && file_exists($path . $new_filename)) {
                unlink($path . $old_picture);
            }

            $user->where('id', $user_info->id)
                ->set(['picture' => $new_filename])
                ->update();

            echo json_encode(['status' => 1, 'msg' => 'Selesai!, Foto Profilmu telah diganti']);
        } else {
            echo json_encode(['status' => 0, 'msg' => 'Gagal, Foto Profilmu gagal diganti']);
        }
    }

    public function changePassword()
    {
        $request = \Config\Services::request();

        if ($request->isAJAX()) {
            $validation = \Config\Services::validation();
            $user_id = CiAuth::id();
            $user = new UserModel();
            $user_info = $user->asObject()->where('id', $user_id)->first();

            $validation->setRules([
                'current_password' => [
                    'rules' => 'required|min_length[8]|check_current_password[current_password]',
                    'errors' => [
                        'required' => 'Password sebelumnya harap diisi',
                        'min_length' => 'Minimal 8 karakter',
                        'check_current_password' => 'Password sebelumnya salah!'
                    ]
                ],
                'new_password' => [
                    'rules' => 'required|min_length[8]|max_length[30]',
                    'errors' => [
                        'required' => 'Password baru harap diisi',
                        'min_length' => 'Minimal 8 karakter',
                        'max_length' => 'Maksimal 30 karakter',
                    ]
                ],
                'confirm_new_password' => [
                    'rules' => 'required|matches[new_password]',
                    'errors' => [
                        'required' => 'Konfirmasi password baru',
                        'matches' => 'Password tidak sama!'
                    ]
                ]
            ]);

            if (!$validation->withRequest($this->request)->run()) {
                $errors = $validation->getErrors();
                return $this->response->setJSON(['status' => 0, 'token' => csrf_hash(), 'error' => $errors]);
            } else {
                $user->where('id', $user_info->id)
                    ->set(['password' => Hash::make($request->getVar('new_password'))])
                    ->update();

                $mail_data = array(
                    'user' => $user_info,
                    'new_password' => $request->getVar('new_password')
                );

                $view = \Config\Services::renderer();
                $mail_body = $view->setVar('mail_data', $mail_data)->render('email-templates/password-changed-email-template');

                $mailConfig = array(
                    'mail_from_email' => env('EMAIL_FROM_ADDRESS'),
                    'mail_from_name' => env('EMAIL_FROM_NAME'),
                    'mail_recipient_email' => $user_info->email,
                    'mail_recipient_name' => $user_info->username,
                    'mail_subject' => 'Changed Password',
                    'mail_body' => $mail_body
                );

                sendEmail($mailConfig);
                return $this->response->setJSON(['status' => 1, 'token' => csrf_hash(), 'msg' => 'Passwordmu berhasil diganti']);
            }
        }
    }

    public function search()
    {
        $data = [
            'pageTitle' => 'Search',
        ];

        return view('search', $data);
    }

    public function searchSpotify()
{
    helper('spotify_helper');

    $query = $this->request->getPost('query');

    // Spotify data fetching
    $accessToken = getSpotifyAccessToken();
    $spotifyArtists = fetchSpotifyArtists($accessToken, $query);
    $spotifyAlbums = fetchSpotifyAlbums($accessToken, $query);
    $spotifyPlaylists = fetchSpotifyPlaylists($accessToken, $query);
    $spotifyTracks = fetchSpotifyTracks($accessToken, $query);

    // Local database searching
    $laguModel = new LaguModel();
    $artisModel = new ArtisModel();
    $albumModel = new AlbumModel();

    $localTracks = $laguModel->like('nama_lagu', $query)->findAll();
    $localArtists = $artisModel->like('nama', $query)->findAll();
    $localAlbums = $albumModel->like('nama_album', $query)->findAll();

    $result = [
        'spotify' => [
            'artists' => $spotifyArtists['artists']['items'] ?? [],
            'albums' => $spotifyAlbums['albums']['items'] ?? [],
            'playlists' => $spotifyPlaylists['playlists']['items'] ?? [],
            'tracks' => $spotifyTracks['tracks']['items'] ?? []
        ],
        'local' => [
            'tracks' => $localTracks,
            'artists' => $localArtists,
            'albums' => $localAlbums
        ]
    ];

    return $this->response->setJSON($result);
}


}


// if ($id_album !== null) {
//     $laguListt = $laguModel->getLaguListByAlbum($id_album);
//     $currenttLagu = $laguModel->getLaguByIdLagu($id_lagu);
//     $album = $albumModel->find($id_album);
// } else {
//     $laguListt = [];
//     $currenttLagu = null;
//     $album = null;
// }


 // if ($album !== null && $currenttLagu !== null) {
        //     $pageTitle = $album['nama_album'] . " - " . $currenttLagu['nama_lagu'];
        // } elseif ($currenttLagu !== null) {
        //     $pageTitle = $currenttLagu['nama_lagu'];
        // } else {
        //     $pageTitle = "Lagu";
        // }

// if( $file->move($path,$new_filename)) {
        //     if ( $old_picture != null && file_exists($path.$old_picture)){
        //         unlink($path.$old_picture);
        //     }
        //     $user->where('id', $user_info->id)
        //     ->set(['picture'=>$new_filename])
        //     ->update();

        //     echo json_encode(['status'=>1, 'msg'=>'Selesai!, Foto Profilmu berhasil diganti']);
        // } else {
        //     echo json_encode(['status'=>0, 'msg'=>'Gagal, Foto Profilmu gagal diganti']);
        // }


        


//     public function updateProfile()
// {
//     $validation = \Config\Services::validation();

//     // $rules = $this->validate([
//     //     'name' => [
//     //         'rules' => 'required',
//     //         'errors' => [
//     //             'required' => 'Nama diperlukan'
//     //         ]
//     //     ],
//     //     'username' => [
//     //         'rules' => 'required|min_length[4]|is_unique[user.username,id,{id}]',
//     //         'errors' => [
//     //             'required' => 'username diperlukan',
//     //             'min_length' => 'Terlalu sedikit, minimal 4 karakter',
//     //             'is_unique' => 'Ganti username dengan yang baru'
//     //         ]
//     //     ],
//     //     'bio' => [
//     //         'rules' => 'max_length[255]',
//     //         'errors' => [
//     //             'max_length' => 'Terlalu panjang!'
//     //         ]
//     //     ],
//     // ]);

//     // if (!$rules) {
//     //     $userModel = new UserModel();
//     //     $data = [
//     //         'pageTitle' => 'Edit Data Barang',
//     //         'validation' => $this->validator
//     //     ];

//     //     return view('pengolahan_lab/edit_data_barang', $data);

//     $data = [
//         'name' => $this->request->getPost('name'),
//         'username' => $this->request->getPost('username'),
//         'bio' => $this->request->getPost('bio'),
//     ];

//     $validation->setRules([
//         'name' => 'required',
//         'username' => 'required|min_length[3]|is_unique[user.username,id,{id}]',
//         'bio' => 'max_length[255]',
//     ]);

//     if (!$validation->run($data)) {
//         return redirect()->route('user.profile')->with('fail', $validation->listErrors());
//     }

//     $userModel = new UserModel();
//     $userId = CiAuth::id();

//     if ($userModel->update($userId, $data)) {
//         return redirect()->route('user.profile')->with('success', 'Profile berhasil diupdate.');
//     } else {
//         return redirect()->route('user.profile')->with('fail', 'Profile gagal diupdate.');
//     }
// }

//     public function updatePersonalDetails()
// {
//     $request =  \Config\Services::request();
//     $validation = \Config\Services::validation();
//     $user_id = CiAuth::id();

//     if( $request->isAJAX()) {
//         $this->validate([
//             'name' => [  
//                 'rules' => 'required',
//                 'errors' => [
//                     'required' => 'Name diperlukan'
//                 ]
//             ],
//             'username' => [
//                 'rules' => 'required|min_length[4]|is_unique[user.username,id,'.$user_id.']',
//                 'errors' => [
//                     'required' => 'Username diperlukan',
//                     'min_length' => 'Username minimal 4 karakter',
//                 ]
//             ]
//         ]);

//         if ($validation->run() == FALSE ) {
//             $errors = $validation->getErrors();
//             return $this->response->setJSON(['status' => 0, 'error' => $errors]);
//         } else {
//             $user = new UserModel();
//             $update = $user->where('id', $user_id)
//                 ->set([
//                     'name' => $request->getVar('name'),
//                     'username' => $request->getVar('username'),
//                     'bio' => $request->getVar('bio')
//                 ])->update();

//             if ($update) {
//                 $user_info = $user->find($user_id);
//                 return $this->response->setJSON(['status' => 1, 'user_info' => $user_info, 'msg' => 'Detail Pribadi berhasil diperbarui']);
//             } else {
//                 return $this->response->setJSON(['status' => 0, 'msg' => 'Ada yang salah']);
//             }
//         }
//     }
// }
