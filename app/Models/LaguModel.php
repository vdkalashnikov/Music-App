<?php

namespace App\Models;

use CodeIgniter\Model;

class LaguModel extends Model
{
    protected $table = 'lagu';
    protected $primaryKey = 'id';
    protected $allowedFields = [
        'id',
        'nama_lagu',
        'gambar',
        'file_lagu',
        'id_artis',
        'durasi'
    ];

    public function joinArtis()
    {
        return $this->select('lagu.*, artis.nama as nama')
                    ->join('artis', 'artis.id_artis = lagu.id_artis', 'left');
    }

    public function joinAlbum()
    {
        return $this->select('lagu.*, album.nama_album as nama_album')
                    ->join('album', 'album.id_album = lagu.id_album', 'left');
    }

    public function getLaguListByArtis($id_artis)
    {
        return $this->select('lagu.*, artis.nama as nama')
                    ->join('artis', 'artis.id_artis = lagu.id_artis', 'left')
                    ->where('lagu.id_artis', $id_artis)
                    ->findAll();
    }

    public function getLaguListByAlbum($id_album)
    {
        return $this->select('lagu.*, album.nama_album as nama_album')
                    ->join('album', 'album.id_album = lagu.id_album', 'left')
                    ->where('lagu.id_album', $id_album)
                    ->findAll();
    }

    public function getLaguById($id_lagu)
    {
        return $this->select('lagu.*, artis.nama as nama')
                    ->join('artis', 'artis.id_artis = lagu.id_artis', 'left')
                    ->where('lagu.id', $id_lagu)
                    ->first();
    }
    public function getLaguByIdLagu($id_lagu)
    {
        return $this->select('lagu.*, album.nama_album as nama_album')
                    ->join('album', 'album.id_album = lagu.id_artis', 'left')
                    ->where('lagu.id', $id_lagu)
                    ->first();
    }
}
