<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;

class KaryawanM extends Authenticatable
{
    use HasFactory;
    protected $table = 'karyawan';
    protected $guarded = ['id_karyawan'];
    protected $primaryKey = 'id_karyawan';
}
