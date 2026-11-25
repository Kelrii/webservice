<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Biodata extends Model
{
    protected $table = 'biodatas';

    protected $fillable = [
        'nama',
        'deskripsi',
        'foto',
    ];
}
