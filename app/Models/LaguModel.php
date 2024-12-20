<?php

namespace App\Models;

use CodeIgniter\Model;

class LaguModel extends Model
{
    protected $table = 'lagu';
    protected $primaryKey = 'id';
    protected $allowedFields = [
        'id',
        'name',
        'image',
        'file',
        'artis_id',
        'album_id',
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

    public function getLagu() {
        return $this->select('lagu.*, artis.name as name_artis')->join('artis', 'artis.id = lagu.artis_id', 'left');
    }

    public function getLaguListByArtis($id_artis)
    {
        return $this->select('lagu.*, artis.name as name_artis')
            ->join('artis', 'artis.id = lagu.artis_id', 'left')
            ->where('lagu.artis_id', $id_artis)
            ->findAll();
    }

    public function getLaguListByAlbum($id_album)
    {
        return $this->select('lagu.*, artis.name as name_artis')
            ->join('artis', 'artis.id = lagu.artis_id', 'left')
            ->where('lagu.album_id', $id_album)
            ->findAll();
    }

    public function getLaguById($id_lagu)
    {
        return $this->select('lagu.*, artis.name as name_artis')
            ->join('artis', 'artis.id = lagu.artis_id', 'left')
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

    public function countLaguByAlbum($id_album)
    {
        return $this->where('album_id', $id_album)->countAllResults();
    }

    public function getTotalDurationByAlbum($id_album)
{
    $lagu = $this->where('album_id', $id_album)->findAll();
    $totalDuration = 0;

    foreach ($lagu as $l) {
        list($minutes, $seconds) = explode(':', $l['durasi']);
        $totalDuration += $minutes * 60 + $seconds;
    }

    $hours = floor($totalDuration / 3600);
    $remainingSeconds = $totalDuration % 3600;
    $minutes = floor($remainingSeconds / 60);
    $seconds = $remainingSeconds % 60;

    if ($hours > 0) {
        return sprintf('%d jam %02d menit %02d detik', $hours, $minutes, $seconds);
    } else if ($hours == 0 && $minutes > 0) {
        return sprintf('%02d menit %02d detik', $minutes, $seconds);
    } else {
        return sprintf('%02d detik', $seconds);
    }
}

}
