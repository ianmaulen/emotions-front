<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Operations extends Model
{
    protected $table = 'cluster_operations';
    public $incrementing = false;
    public $timestamps = false;
    
    protected $fillable = [
        'nombre',
        'operacion',
        'alto',
        'bajo'
    ];
}
