<?php

namespace App\Models;

use CodeIgniter\Model;

class ArtisModel extends Model
{
    protected $table = 'artis';
    protected $primaryKey = 'id_artis';
    protected $allowedFields = [
        'id_artis',
        'nama',
        'picture',
        'artimg'
    ];
}
