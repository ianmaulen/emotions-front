<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class clustersParams extends Model
{
    protected $table = 'cluster_params';
    public $incrementing = false;
    public $timestamps = false;
    
    protected $fillable = [
        'emotion',
        'cluster',
        'limit',
        'peaks',
    ];
}
