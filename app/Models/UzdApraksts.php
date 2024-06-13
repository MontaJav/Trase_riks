<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class UzdApraksts extends Model
{
    protected $table = 'UzdApraksts';
    protected $primaryKey = 'ID_uzdapraksts';
    public $timestamps = false;

    protected $fillable = [
        'ID_uzdevums',
        'aprTeksts',
        'regDatApr',
        'red_datApr',
        'dzesDatApr'
    ];

    protected $casts = [
        'regDatApr' => 'datetime',
        'red_datApr' => 'datetime',
        'dzesDatApr' => 'datetime',
    ];

    public function uzdevums()
    {
        return $this->belongsTo(Uzdevumi::class, 'ID_uzdevums', 'ID_uzdevums');
    }
}
