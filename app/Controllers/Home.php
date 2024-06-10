<?php

namespace App\Controllers;

use App\Models\ArtisModel;
use App\Models\LaguModel;
use App\Libraries\CiAuth;

class Home extends BaseController
{
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
}
