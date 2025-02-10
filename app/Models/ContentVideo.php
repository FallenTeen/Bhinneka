<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ContentVideo extends Model
{
    use HasFactory;

    protected $fillable = [
        'channel_id',
        'judul',
        'slug',
        'deskripsi',
        'url',
        'is_exclusive',
    ];

    protected $casts = [
        'is_exclusive' => 'boolean',
    ];

    public function channel()
    {
        return $this->belongsTo(Channel::class);
    }
}
