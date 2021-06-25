<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class pegawai extends Model
{
    protected $table = 'tbl_pegawai';

    protected $fillable = [
        'nip',
        'nama',
        'alamat'
    ];
}
