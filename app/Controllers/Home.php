<?php

namespace App\Controllers;

use App\Models\ArtisModel;
use App\Models\LaguModel;
use App\Libraries\CiAuth;
use App\Models\UserModel;
use CodeIgniter\Validation\Exceptions\ValidationException;
use App\Libraries\Hash;

class Home extends BaseController
{
    protected $helpers = ['url', 'form', 'CIMail', 'CIFunctions'];
    public function index(): string
    {
        $laguModel = new LaguModel();
        $artisModel = new ArtisModel();

        $artis = $artisModel->findAll();

        $username = session()->get('username');
        session()->set('username', $username);
        $data = [
            'pageTitle' => 'Dashboard',
            'username' => $username,
            'artis' => $artis,

        ];


        return view('home', $data);
    }

    public function lagu($id_artis = null, $id_lagu = null)
    {
        $laguModel = new LaguModel();
        $artisModel = new ArtisModel();

        if ($id_artis !== null) {
            $laguList = $laguModel->getLaguListByArtis($id_artis);
            $currentLagu = $laguModel->getLaguById($id_lagu);
            $artis = $artisModel->find($id_artis);
        } else {
            $laguList = [];
            $currentLagu = null;
            $artis = null;
        }

        // Membuat pageTitle dengan nama artis dan nama lagu
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
            'pageTitle' => $pageTitle
        ];
        return view('lagu', $data);
    }


    public function getSongs()
    {
        $laguModel = new LaguModel();
        $lagu = $laguModel->joinArtis()->findAll();

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

    public function logoutUserHandler()
    {
        CiAuth::forget();
        return redirect()->route('user.login.form')->with('fail', 'You Are Logged Out!');
    }

    public function profile()
    {
        $username = session()->get('username');
        $name = session()->get('name');
        $picture = session()->get('picture');
        $bio = session()->get('bio');

        $data = [
            'pageTitle' => 'Profile',
            'username' => $username,
            'name' => $name,
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
            'bio' => $this->request->getPost('bio'),
        ];

        $validation->setRules([
            'name' => 'required|min_length[3]',
            'username' => 'required|min_length[4]|is_unique[user.username,id,{id}]',
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
