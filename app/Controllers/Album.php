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

class Album extends BaseController
{
    public function index($id_album)
    {
        $albumModel = new AlbumModel();
        $artisModel = new ArtisModel();
        $album = $albumModel->find($id_album);
        $artis = $artisModel->where('id', $album['artis_id'])->first();

        $laguModel = new LaguModel();
        $lagu = $laguModel->getLaguListByAlbum($id_album);
        $jumlahLagu = $laguModel->countLaguByAlbum($id_album);
        $totalDuration = $laguModel->getTotalDurationByAlbum($id_album);

        $data = [
            'album' => $album,
            'lagu' => $lagu,
            'artis' => $artis,
            'jumlahLagu' => $jumlahLagu,
            'totalDuration' => $totalDuration,
            'pageTitle' => isset($album['name']) ? $album['name'] : 'Album'
        ];

        return view('listmusicalbum', $data);
    }
}
