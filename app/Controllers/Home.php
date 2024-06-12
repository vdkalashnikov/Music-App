<?php

namespace App\Controllers;

use App\Models\ArtisModel;
use App\Models\LaguModel;
use App\Libraries\CiAuth;
use App\Models\UserModel;
use CodeIgniter\Validation\Exceptions\ValidationException;

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

        $data = [
            'pageTitle' => 'Profile',
            'username' => $username,
            'name' => $name,
            'picture' => $picture,

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
}


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


