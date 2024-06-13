<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ProjLietotaji extends Model
{
    protected $table = 'ProjLietotaji';
    protected $primaryKey = false;
    public $timestamps = false;

    protected $fillable = [
        'ID_lietotajs',
        'ID_projekts',
        'regDatProj',
    ];

    protected $casts = [
        'regDatProj' => 'datetime',
    ];

    public function projNosaukums()
    {
        return $this->belongsToMany(ProjNosaukums::class, 'ID_projekts', 'ID_projekts');
    }

    public function lietotajs()
    {
        return $this->belongsToMany(Lietotajs::class, 'ID_lietotajs', 'ID_lietotajs');
    }
}
