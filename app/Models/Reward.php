<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Reward extends Model
{
    protected $fillable = [
        'name',
        'description',
        'cost',
        'rarity',
        'border_color',
        'glow_style',
        'stock',
        'icon',
        'is_active',
    ];

    public function redemptions()
    {
        return $this->hasMany(Redemption::class);
    }

    public function users()
    {
        return $this->hasMany(User::class, 'active_profile_frame_id');
    }

    /**
     * Get frame border CSS classes based on rarity
     */
    public function getFrameBorderClassAttribute()
    {
        if ($this->border_color) {
            // Custom border color (e.g., "from-blue-500 to-purple-600" for gradient)
            if (str_contains($this->border_color, 'from-')) {
                return "border-4 bg-gradient-to-r {$this->border_color}";
            }
            // Solid color
            return "border-4 border-{$this->border_color}";
        }

        // Default based on rarity
        return match($this->rarity) {
            'legendary' => 'border-4 border-transparent bg-gradient-to-br from-yellow-400 via-yellow-500 to-orange-600',
            'epic' => 'border-4 border-transparent bg-gradient-to-br from-purple-500 via-purple-600 to-pink-600',
            'rare' => 'border-4 border-transparent bg-gradient-to-br from-blue-400 via-blue-500 to-cyan-500',
            'common' => 'border-4 border-transparent bg-gradient-to-br from-green-400 via-green-500 to-emerald-600',
            default => 'border-4 border-transparent bg-gradient-to-br from-green-400 via-green-500 to-emerald-600',
        };
    }

    /**
     * Get frame glow CSS classes
     */
    public function getFrameGlowClassAttribute()
    {
        if ($this->glow_style) {
            return $this->glow_style;
        }

        return match($this->rarity) {
            'legendary' => 'shadow-2xl shadow-yellow-500/50',
            'epic' => 'shadow-xl shadow-purple-500/40',
            'rare' => 'shadow-lg shadow-blue-500/30',
            'common' => 'shadow-md shadow-green-500/20',
            default => 'shadow-md shadow-green-500/20',
        };
    }

    /**
     * Get Batik Megamendung pattern class based on rarity
     */
    public function getMegamendungPatternAttribute()
    {
        return match($this->rarity) {
            'legendary' => 'megamendung-legendary',
            'epic' => 'megamendung-epic',
            'rare' => 'megamendung-rare',
            'common' => 'megamendung-common',
            default => 'megamendung-common',
        };
    }
}
