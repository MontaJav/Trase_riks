<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class UzdStatusi extends Model
{
    protected $table = 'UzdStatusi';
    protected $primaryKey = false;
    public $timestamps = false;

    protected $fillable = [
        'uzdStatuss',
    ];
}
