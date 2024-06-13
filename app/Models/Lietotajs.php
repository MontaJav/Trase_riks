<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Lietotajs extends Model
{
    protected $table = 'Lietotajs';
    protected $primaryKey = 'ID_lietotajs';
    public $timestamps = false;
    protected $with = ['projekti', 'autentifikacija'];
    protected $appends = ['vardsUzvards'];

    protected $fillable = [
        'ID_aut',
        'vards',
        'uzvards',
        'regDatLiet',
        'tiesibas',
    ];

    protected $casts = [
        'regDatLiet' => 'datetime',
    ];

    public function autentifikacija()
    {
        return $this->belongsTo(Autentifikacija::class, 'ID_aut', 'ID_aut');
    }

    public function uzdevumi()
    {
        return $this->hasManyThrough(Uzdevumi::class, Autentifikacija::class, 'ID_lietotajs', 'ID_aut', 'ID_lietotajs', 'ID_aut');
    }

    public function projekti()
    {
        return $this->belongsToMany(ProjNosaukums::class, 'ProjLietotaji', 'ID_lietotajs', 'ID_projekts');
    }

    public function getVardsUzvardsAttribute()
    {
        return $this->vards . ' ' . $this->uzvards;
    }
}
