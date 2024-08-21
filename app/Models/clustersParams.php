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
        'emotion_id',
        'cluster_id',
        'peak_limits',
        'value_limit',
        'level'
    ];
}
