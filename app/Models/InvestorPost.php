<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class InvestorPost extends Model
{
    use HasFactory;

    protected $fillable = [
        'investor_profile_id',
        'title',
        'description',
        'position',
        'location',
        'employment_type',
        'required_skills',
        'salary_range_start',
        'salary_range_end',
        'deadline',
        'contact_email',
        'status'
    ];

    protected $casts = [
        'required_skills' => 'array',
        'deadline' => 'date',
        'salary_range_start' => 'decimal:2',
        'salary_range_end' => 'decimal:2'
    ];

    public function investor()
    {
        return $this->belongsTo(InvestorProfile::class, 'investor_profile_id');
    }

    public function getFormattedSalaryRangeAttribute()
    {
        if (!$this->salary_range_start && !$this->salary_range_end) {
            return 'Negotiable';
        }

        if (!$this->salary_range_end) {
            return 'From Rp ' . number_format($this->salary_range_start, 0, ',', '.');
        }

        return 'Rp ' . number_format($this->salary_range_start, 0, ',', '.') .
            ' - Rp ' . number_format($this->salary_range_end, 0, ',', '.');
    }

    public function scopeActive($query)
    {
        return $query->where('status', 'active');
    }
}