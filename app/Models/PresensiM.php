<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PresensiM extends Model
{
    use HasFactory;
    protected $table = 'presensi';
    protected $guarded = ['id'];
}
