<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class User extends Authenticatable
{
    /** @use HasFactory<\Database\Factories\UserFactory> */
    use HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'name',
        'email',
        'avatar',
        'active_profile_frame_id',
        'xp',
        'password',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var list<string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
            'last_streak_date' => 'date',
        ];
    }

    // 🔥 JANGAN LUPA BAGIAN INI 🔥
    public function missions(): BelongsToMany
    {
        return $this->belongsToMany(Mission::class)
                    ->withPivot('status', 'evidence', 'created_at', 'updated_at')
                    ->withTimestamps();
    }
    
    // Alias untuk pivot table
    public function missionUsers()
    {
        return $this->belongsToMany(Mission::class, 'mission_user')
                    ->withPivot('status', 'evidence', 'created_at', 'updated_at')
                    ->withTimestamps();
    }
    
    // Active profile frame (cosmetic)
    public function activeFrame()
    {
        return $this->belongsTo(Reward::class, 'active_profile_frame_id');
    }
    
    // Unlocked frames (approved redemptions)
    public function unlockedFrames()
    {
        return $this->hasMany(Redemption::class)
                    ->where('status', 'approved')
                    ->with('reward');
    }
    
    // 🔥 FITUR BARU: LOGIKA LEVEL & BADGE 🔥
    
    // Akses dengan cara: {{ Auth::user()->level_name }}
    public function getLevelNameAttribute()
    {
        $xp = $this->xp;

        if ($xp >= 1000) return '👑 Legends';
        if ($xp >= 500)  return '🌳 Earth Guardian';
        if ($xp >= 200)  return '🌿 Nature Hero';
        if ($xp >= 100)  return '🌱 Green Warrior';
        
        return '👶 Newbie'; // Default kalau XP masih dikit
    }

    // Akses dengan cara: {{ Auth::user()->level_color }} (Untuk warna badge)
    public function getLevelColorAttribute()
    {
        $xp = $this->xp;

        if ($xp >= 1000) return 'bg-purple-600'; // Ungu Keren
        if ($xp >= 500)  return 'bg-red-500';    // Merah Menyala
        if ($xp >= 200)  return 'bg-blue-500';   // Biru
        if ($xp >= 100)  return 'bg-green-500';  // Hijau
        
        return 'bg-gray-400'; // Abu-abu (Newbie)
    }
}