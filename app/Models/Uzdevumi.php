<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Uzdevumi extends Model
{
    protected $table = 'Uzdevumi';
    protected $primaryKey = 'ID_uzdevums';
    public $timestamps = false;
    protected $with = [
        'projNosaukums',
        'uzdApraksts',
        'uzdPielikumi',
        'uzdKomentari',
        'izpilditajs',
        'ipasnieks',
        'laikauzsk'
    ];
    protected $appends = ['laiks'];

    protected $fillable = [
        'ID_projekts',
        'uzdTips',
        'veidDat',
        'uzdNos',
        'uzdStat',
        'uzdIp',
        'uzdReg',
        'termins'
    ];

    protected $casts = [
        'veidDat' => 'datetime',
        'termins' => 'datetime',
    ];

    public function projNosaukums()
    {
        return $this->belongsTo(ProjNosaukums::class, 'ID_projekts', 'ID_projekts');
    }

    public function uzdApraksts()
    {
        return $this->hasOne(UzdApraksts::class, 'ID_uzdevums', 'ID_uzdevums');
    }

    public function uzdPielikumi()
    {
        return $this->hasMany(UzdPielikumi::class, 'ID_uzdevums', 'ID_uzdevums');
    }

    public function uzdKomentari()
    {
        return $this->hasMany(UzdKomentari::class, 'ID_uzdevums', 'ID_uzdevums');
    }

    public function laikauzsk()
    {
        return $this->hasMany(LaikaUzskaite::class, 'ID_uzdevums', 'ID_uzdevums');
    }

    public function izpilditajs()
    {
        return $this->belongsTo(Autentifikacija::class, 'uzdIp', 'ID_aut');
    }

    public function ipasnieks()
    {
        return $this->belongsTo(Autentifikacija::class, 'uzdReg', 'ID_aut');
    }

    public function getLaiksAttribute()
    {
        $laiks = $this->laikauzsk->sum(function ($uzskaite) {
            return $uzskaite->sakDatLaiks->diffInMinutes($uzskaite->beigDatLaiks);
        });
        $hours = floor($laiks / 60);
        $minutes = $laiks % 60;
        return $hours . 'h ' . ($minutes > 0 ? $minutes . 'm' : '');
    }
}
