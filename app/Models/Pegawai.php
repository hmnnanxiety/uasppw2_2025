<?php

namespace App\Models;
use Illuminate\Database\Eloquent\Model;

class Pegawai extends Model
{
    protected $table = 'pegawai';
    protected $fillable = ['nama', 'email', 'gender', 'pekerjaan_id', 'is_active'];

    public function pekerjaan()
    {
    return $this->belongsTo(Pekerjaan::class, 'pekerjaan_id');
    }
}