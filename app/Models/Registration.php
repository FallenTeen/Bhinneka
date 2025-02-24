<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Registration extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'document1_path',
        'document1_name',
        'document2_path',
        'document2_name',
        'document3_path',
        'document3_name',
        'registration_type',
        'status',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}