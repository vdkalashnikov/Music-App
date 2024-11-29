<?php

namespace App\Models;

use CodeIgniter\Model;

class AlbumModel extends Model
{
    protected $table = 'album';
    protected $primaryKey = 'id';
    protected $allowedFields = [
        'id',
        'name',
        'image',
        'artis_id',
    ];

    public function jointoArtis()
    {
        return $this->select('album.*, artis.name as name_artis, artis.image as img')
            ->join('artis', 'artis.id = album.artis_id', 'left');
    }

    public function getArtis() {
        return $this->db->table('artis')->where('id', $this->artis_id)->get()->getRowArray();
    }

}
