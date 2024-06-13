<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class UzdKomentari extends Model
{
    protected $table = 'UzdKomentari';
    protected $primaryKey = 'ID_komentars';
    public $timestamps = false;
    protected $with = ['lietotajs'];

    protected $fillable = [
        'ID_aut',
        'ID_uzdevums',
        'komTeksts',
        'regDatKom',
        'red_datKom',
        'dzesDatKom'
    ];

    protected $casts = [
        'regDatKom' => 'datetime',
        'red_datKom' => 'datetime',
        'dzesDatKom' => 'datetime',
    ];

    public function lietotajs()
    {
        return $this->belongsTo(Autentifikacija::class, 'ID_aut', 'ID_aut');
    }

    public function uzdevums()
    {
        return $this->belongsTo(Uzdevumi::class, 'ID_uzdevums', 'ID_uzdevums');
    }
}
