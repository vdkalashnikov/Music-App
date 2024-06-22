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

    // Fetch data from the database
    $artis = $artisModel->findAll();
    $album = $albumModel->jointoArtis()->findAll();

    // Fetch Spotify data
    $accessToken = getSpotifyAccessToken();
    $spotifyTracksOne = fetchSpotifyTracks($accessToken, 'teratas');
    $spotifyTracksTwo = fetchSpotifyTracks($accessToken, '4aawyAB9vmqN3uQ7FjRGTy');
    $spotifyArtists = fetchSpotifyArtists($accessToken, '0TnOYISbd1XYRBk9myaseg'); // Change this query to whatever you want

    $username = session()->get('username');
    session()->set('username', $username);
    $data = [
        'pageTitle' => 'Dashboard',
        'username' => $username,
        'artis' => $artis,
        'album' => $album,
        'spotifyTracksOne' => $spotifyTracksOne['tracks']['items'] ?? [],
        'spotifyTracksTwo' => $spotifyTracksTwo['tracks']['items'] ?? [],
        'spotifyArtists' => $spotifyArtists['artists']['items'] ?? [],
        'accessToken' => $accessToken
    ];

    return view('home', $data);
}


    public function spotifyAlbum($albumId)
    {
        $accessToken = getSpotifyAccessToken();
        $album = getSpotifyAlbumTracks($accessToken, $albumId);

        $jumlahLagu = count($album['tracks']['items']);
        $totalDuration = array_reduce($album['tracks']['items'], function ($carry, $track) {
            return $carry + $track['duration_ms'];
        }, 0);

        $totalDuration = gmdate("H:i:s", $totalDuration / 1000);

        $data = [
            'album' => $album,
            'lagu' => $album['tracks']['items'],
            'jumlahLagu' => $jumlahLagu,
            'totalDuration' => $totalDuration,
            'pageTitle' => $album['name']
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

    $data = [
        'track' => $track,
        'pageTitle' => $track['name'],
        'accessToken' => $accessToken
    ];

    return view('spotify_track', $data);
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
            'album' => null, // tambahkan ini untuk memudahkan pengecekan di view
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
        // Fetching the album details along with the artist's name
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

        $data = [
            'pageTitle' => 'Profile',
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
            return redirect()->route('user.profile')->with('success', 'Profile berhasil diupdate.');
        } else {
            return redirect()->route('user.profile')->with('fail', 'Failed to update profile.');
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
