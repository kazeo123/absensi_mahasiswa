<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class IzinM extends Model
{
    use HasFactory;
    protected $table = 'izin';
    protected $guarded = ['id'];
}
