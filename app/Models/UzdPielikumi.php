<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class UzdPielikumi extends Model
{
    protected $table = 'UzdPielikumi';
    protected $primaryKey = 'ID_pielikums';
    public $timestamps = false;

    protected $fillable = [
        'ID_uzdevums',
        'ID_aut',
        'pielPievDat',
        'pielRedDat',
        'pielDzesDat',
        'pielNos'
    ];

    protected $casts = [
        'pielPievDat' => 'datetime',
        'pielRedDat' => 'datetime',
        'pielDzesDat' => 'datetime',
    ];

    public function uzdevums()
    {
        return $this->belongsTo(Uzdevumi::class, 'ID_uzdevums', 'ID_uzdevums');
    }
}
