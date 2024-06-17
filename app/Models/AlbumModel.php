<?php

namespace App\Models;

use CodeIgniter\Model;

class AlbumModel extends Model
{
    protected $table = 'album';
    protected $primaryKey = 'id_album';
    protected $allowedFields = [
        'id_album',
        'nama_album',
        'gambar_album',
        'id_artis',
    ];

    public function jointoArtis()
    {
        return $this->select('album.*, artis.nama as nama, artis.picture')
            ->join('artis', 'artis.id_artis = album.id_artis', 'left');
    }

}
