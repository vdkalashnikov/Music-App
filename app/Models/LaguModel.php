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
        $artis = new ArtisModel();
        return $this->join('artis', 'artis.id_artis = lagu.id_artis', 'left');
    }
}
