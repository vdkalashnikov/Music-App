<?php

namespace App\Models;

use CodeIgniter\Model;

class ArtisModel extends Model
{
    protected $table = 'artis';
    protected $primaryKey = 'id';
    protected $allowedFields = [
        'id',
        'name',
        'image',
        'artimg'
    ];
}
