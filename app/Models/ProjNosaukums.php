<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ProjNosaukums extends Model
{
    protected $table = 'ProjNosaukums';
    protected $primaryKey = 'ID_projekts';
    public $timestamps = false;

    protected $fillable = [
        'ID_vaditajs',
        'regDatProj',
        'red_datProj',
        'projNos'
    ];

    protected $casts = [
        'regDatProj' => 'datetime',
        'red_datProj' => 'datetime',
    ];

    public function projVaditajs()
    {
        return $this->belongsTo(ProjVaditajs::class, 'ID_vaditajs', 'ID_vaditajs');
    }

    public function uzdevumi()
    {
        return $this->hasMany(Uzdevumi::class, 'ID_projekts', 'ID_projekts');
    }

    public function laikauzsk()
    {
        return $this->hasManyThrough(
            LaikaUzskaite::class,
            Uzdevumi::class,
            'ID_projekts',
            'ID_uzdevums',
            'ID_projekts',
            'ID_uzdevums'
        );
    }
}
