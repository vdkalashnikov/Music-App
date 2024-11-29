<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use CodeIgniter\HTTP\ResponseInterface;
use App\Models\ArtisModel;
use App\Models\LaguModel;
use App\Libraries\CiAuth;
use App\Models\UserModel;
use App\Models\AlbumModel;
use CodeIgniter\Validation\Exceptions\ValidationException;
use App\Libraries\Hash;

class Lagu extends BaseController
{
    public function index()
    {
        //
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

        if ($artis !== null && $currentLagu !== null) {
            $pageTitle = $artis['name'] . " - " . $currentLagu['nama_lagu'];
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
}
