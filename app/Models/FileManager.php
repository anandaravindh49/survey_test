<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class FileManager extends Model
{
    protected $fillable = [
        'name',
        'path',
        'thumbnail_path',
        'disk',
        'size',
        'mime',
        'user_id',
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
}
