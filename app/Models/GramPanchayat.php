<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class GramPanchayat extends Model
{
    use HasFactory;

    protected $fillable = [
        'state_name',
        'business_area',
        'district_name',
        'block_name',
        'gp_name',
        'gp_code',
        'gp_type',
        'status',
        'created_by',
        'updated_by',
    ];

    public function creator()
    {
        return $this->belongsTo(User::class, 'created_by');
    }

    public function updater()
    {
        return $this->belongsTo(User::class, 'updated_by');
    }
}
