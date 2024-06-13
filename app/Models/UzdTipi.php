<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class UzdTipi extends Model
{
    protected $table = 'UzdTipi';
    protected $primaryKey = false;
    public $timestamps = false;

    protected $fillable = [
        'uzdTips',
    ];
}
