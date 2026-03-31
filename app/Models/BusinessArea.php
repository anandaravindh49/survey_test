<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BusinessArea extends Model
{
    use HasFactory;

    protected $table = 'business_areas';

    protected $fillable = [
        'package_name',
        'state_name',
        'business_name',
        'code',
        'status',
        'created_by',
        'updated_by',
    ];

    protected $casts = [
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
    ];
}
