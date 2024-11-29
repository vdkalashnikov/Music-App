<?php

namespace App\Controllers;

use App\Models\ArtisModel;
use App\Models\LaguModel;

class Artis extends BaseController {
    public function index($id_artis)
    {
        $artisModel = new ArtisModel();
        $artis = $artisModel->find($id_artis);

        $laguModel = new LaguModel();
        $lagu = $laguModel->where('artis_id', $id_artis)->findAll();

        $data = [
            'artis' => $artis,
            'lagu' => $lagu,
            'pageTitle' => isset($artis['name']) ? $artis['name'] : 'Artis'
        ];

        return view('listmusicart', $data);
    }
}