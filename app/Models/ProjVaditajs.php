<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ProjVaditajs extends Model
{
    protected $table = 'ProjVaditajs';
    protected $primaryKey = 'ID_vaditajs';
    public $timestamps = false;

    protected $appends = [
        'vardsUzvards'
    ];

    protected $fillable = [
        'ID_aut',
        'regDatVad',
        'vards',
        'uzvards',
    ];

    protected $casts = [
        'regDatVad' => 'datetime'
    ];

    public function projNosaukums()
    {
        return $this->hasMany(ProjNosaukums::class, 'ID_vaditajs', 'ID_vaditajs');
    }

    public function autentifikacija()
    {
        return $this->belongsTo(Autentifikacija::class, 'ID_aut', 'ID_aut');
    }

    public function getVardsUzvardsAttribute()
    {
        return $this->vards . ' ' . $this->uzvards;
    }
}
