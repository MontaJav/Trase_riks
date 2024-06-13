<?php

namespace App\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;

class Autentifikacija extends Authenticatable
{
    protected $table = 'Autentifikacija';
    protected $primaryKey = 'ID_aut';
    public $timestamps = false;

    protected $appends = [
        'vardsUzvards',
    ];

    protected $fillable = [
        'lietotajvards',
        'parole',
    ];

    protected $hidden = [
        'parole',
    ];

    public function getAuthPassword()
    {
        return $this->parole;
    }

    public function projVaditajs()
    {
        return $this->hasOne(ProjVaditajs::class, 'ID_aut', 'ID_aut');
    }

    public function lietotajs()
    {
        return $this->hasOne(Lietotajs::class, 'ID_aut', 'ID_aut');
    }

    public function uzdevumi()
    {
        return $this->hasMany(Uzdevumi::class, 'uzdIp', 'ID_aut');
    }

    public function getVardsUzvardsAttribute()
    {
        $lietotajs = $this->lietotajs ?? $this->projVaditajs;

        return $lietotajs->vards . ' ' . $lietotajs->uzvards;
    }
}
