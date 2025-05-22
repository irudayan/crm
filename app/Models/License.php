<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class License extends Model
{
    use HasFactory;

    protected $fillable = [
        'license_key',
        'email',
        'plan',
        'start_date',
        'end_date',
        'is_active',
        'notes'
    ];

    protected $casts = [
        'start_date' => 'date',
        'end_date' => 'date',
        'is_active' => 'boolean'
    ];

    public function scopeActive($query)
    {
        return $query->where('is_active', true);
    }

    // public function isValid()
    // {
    //     return $this->is_active && now()->lessThanOrEqualTo($this->end_date);
    // }

    public function getStatusAttribute()
    {
        if (!$this->is_active) {
            return 'Inactive';
        }

        return $this->isValid() ? 'Active' : 'Expired';
    }

    public function isValid()
{
    return $this->is_active && now()->lessThanOrEqualTo($this->end_date);
}
}
