<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use CodeIgniter\HTTP\ResponseInterface;
use App\Models\ArtisModel;
use App\Models\LaguModel;
use App\Models\AlbumModel;

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
            $laguList = $laguModel->getLagu()->where('artis_id', $id_artis)->findAll();
            $currentLagu = $laguModel->getLagu()->find($id_lagu);
            $artis = $artisModel->find($id_artis);
        } else {
            $laguList = [];
            $currentLagu = null;
            $artis = null;
        }

        if ($artis !== null && $currentLagu !== null) {
            $pageTitle = $artis['name'] . " - " . $currentLagu['name'];
        } elseif ($currentLagu !== null) {
            $pageTitle = $currentLagu['name'];
        } else {
            $pageTitle = "Lagu";
        }

        $data = [
            'laguList' => $laguList,
            'currentLagu' => $currentLagu,
            'subject' => $artis,
            'pageTitle' => $pageTitle,
            'type' => 'artis'
        ];
        return view('lagu', $data);
    }

    public function laguByAlbum($id_album = null, $id_lagu = null)
    {
        $laguModel = new LaguModel();
        $albumModel = new AlbumModel();

        if ($id_album !== null) {
            // $laguList = $laguModel->getLaguListByAlbum($id_album);
            // $currentLagu = $laguModel->getLaguById($id_lagu);
            $laguList = $laguModel->getLagu()->where('album_id', $id_album)->findAll();
            $currentLagu = $laguModel->getLagu()->find($id_lagu);
            $album = $albumModel->find($id_album);
        } else {
            $laguList = [];
            $currentLagu = null;
            $album = null;
        }

        if ($album !== null && $currentLagu !== null) {
            $pageTitle = $album['name'] . " - " . $currentLagu['name'];
        } elseif ($currentLagu !== null) {
            $pageTitle = $currentLagu['name'];
        } else {
            $pageTitle = "Lagu";
        }

        $data = [
            'laguList' => $laguList,
            'currentLagu' => $currentLagu,
            'subject' => $album,
            'pageTitle' => $pageTitle,
            'type' => 'album'
        ];
        return view('lagu', $data);
    }
}
