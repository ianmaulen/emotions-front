<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class clustersTexts extends Model
{
    protected $table = 'cluster_texts';
    public $incrementing = false;
    public $timestamps = false;
    
    protected $fillable = [
        'cluster_name',
        'level',
        'text',
    ];
}
