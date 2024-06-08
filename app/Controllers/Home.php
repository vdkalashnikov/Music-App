<?php

namespace App\Controllers;

use App\Models\ArtisModel;
use App\Models\LaguModel;

class Home extends BaseController
{
    public function index(): string
    {
        $artisModel = new ArtisModel();
        $artis = $artisModel->findAll();

        $data = [
            'artis' => $artis,
            'pageTitle' => "Beranda"
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

        $data = [
            'laguList' => $laguList,
            'currentLagu' => $currentLagu,
            'artis' => $artis,
            'pageTitle' => isset($currentLagu['nama_lagu']) ? $currentLagu['nama_lagu'] : "Lagu"
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
}
