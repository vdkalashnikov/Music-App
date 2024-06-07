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

    if ($id_artis !== null && $id_lagu !== null) {
        $lagu = $laguModel->joinArtis()
                          ->where('artis.id_artis', $id_artis)
                          ->where('lagu.id', $id_lagu)
                          ->first();
        $artisModel = new ArtisModel();
        $artis = $artisModel->find($id_artis);
    } else {
        $lagu = null;
        $artis = null;
    }

    $data = [
        'lagu' => $lagu,
        'artis' => $artis,
        'pageTitle' => isset($lagu['nama_lagu']) ? $lagu['nama_lagu'] : "Lagu"
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
        $lagu = $laguModel->where('id_artis', $id_artis)->findAll();

        $data = [
            'artis' => $artis,
            'lagu' => $lagu,
            'pageTitle' => isset($artis['nama']) ? $artis['nama'] : 'Artis'
        ];

        return view('listmusicart', $data);
    }
}
