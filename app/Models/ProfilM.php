<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProfilM extends Model
{
    use HasFactory;
    protected $table = 'lokasi';
    protected $guarded = ['id'];
}
