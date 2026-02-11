<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Mission extends Model
{
    use HasFactory;

    protected $fillable = [
        'title',
        'description',
        'points_reward',
        'requires_evidence',
        'frequency',
        'icon',
        'is_active',
    ];

    // 🔥 TAMBAHAN BARU: RELASI KE USER 🔥
    // Misi ini diambil oleh siapa saja?
    public function users(): BelongsToMany
    {
        return $this->belongsToMany(User::class)
                    ->withPivot('status', 'evidence', 'created_at', 'updated_at')
                    ->withTimestamps();
    }
}