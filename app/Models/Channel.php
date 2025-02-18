<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Channel extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'channel_name',
        'avatar',
        'slug',
        'exlink',
        'verified',
        'deskripsi',
    ];
    public function cast()
    {
        return [
            'verified' => 'boolean',
            'exlink' => 'array',
        ];
    }
    public function user()
    {
        return $this->belongsTo(User::class);
    }
    public function contentVideos()
    {
        return $this->hasMany(ContentVideo::class);
    }
    public function messages()
    {
        return $this->hasMany(Message::class);
    }
}
