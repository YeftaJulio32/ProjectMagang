<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    use HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'role',
        'joined_at',
        'avatar_url',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
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
        ];
    }

    /**
     * Get the user's avatar URL with fallback
     */
    public function getAvatarUrlAttribute($value)
    {
        if ($value) {
            return $value;
        }

        // Use default avatar SVG as fallback
        return '/storage/avatars/default-avatar.png';
    }

    /**
     * Check if the user is an admin
     */
    public function getIsAdminAttribute()
    {
        return $this->role === 'admin';
    }

    public function komentar()
    {
        return $this->hasMany(Comment::class);
    }
}
