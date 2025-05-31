<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Carbon\Carbon;
use App\Enums\UserRole;
use Spatie\Permission\Traits\HasRoles;
use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable
{
    protected static function booted(): void
    {
        static::created(function (User $user) {
            if ($user->roles->isEmpty()) {
                $user->assignRole('مهمان');
            }
        });
    }
    /** @use HasFactory<\Database\Factories\UserFactory> */
    use HasFactory, Notifiable, HasRoles;

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'name',
        'email',
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
            'last_seen' => 'datetime',
        ];
    }

    public function isOnline($minutes = 5)
    {
        return $this->last_seen && $this->last_seen->gt(Carbon::now()->subMinutes($minutes));
    }
    public function latestActivity()
    {
        return $this->last_seen ? $this->last_seen->diffForHumans() : 'فعالیتی نداشته است   ';
    }
}
