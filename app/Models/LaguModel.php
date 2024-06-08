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

    public function getLaguListByArtis($id_artis)
    {
        return $this->select('lagu.*, artis.nama as nama')
                    ->join('artis', 'artis.id_artis = lagu.id_artis', 'left')
                    ->where('lagu.id_artis', $id_artis)
                    ->findAll();
    }

    public function getLaguById($id_lagu)
    {
        return $this->select('lagu.*, artis.nama as nama')
                    ->join('artis', 'artis.id_artis = lagu.id_artis', 'left')
                    ->where('lagu.id', $id_lagu)
                    ->first();
    }
}
