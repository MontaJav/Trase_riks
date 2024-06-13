<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class LaikaUzskaite extends Model
{
    protected $table = 'LaikaUzskaite';
    protected $primaryKey = 'ID_laikauzsk';
    public $timestamps = false;
    protected $appends = ['laiks'];

    protected $fillable = [
        'ID_uzdevums',
        'ID_aut',
        'sakDatLaiks',
        'beigDatLaiks'
    ];

    protected $casts = [
        'sakDatLaiks' => 'datetime',
        'beigDatLaiks' => 'datetime'
    ];

    public function uzdevums()
    {
        return $this->belongsTo(Uzdevumi::class, 'ID_uzdevums');
    }

    public function autentifikacija()
    {
        return $this->belongsTo(Autentifikacija::class, 'ID_aut');
    }

    public function getLaiksAttribute()
    {
        $min = $this->sakDatLaiks->diffInMinutes($this->beigDatLaiks);
        $hours = floor($min / 60);
        $minutes = $min % 60;
        return $hours . 'h ' . ($minutes > 0 ? $minutes . 'm' : '');
    }
}
