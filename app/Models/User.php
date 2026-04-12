<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Database\Factories\UserFactory;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    /** @use HasFactory<UserFactory> */
    use HasFactory, Notifiable;

    protected $fillable = [
        'name',
        'email',
        'phone',
        'password',
        'role',
    ];

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

    public function purchases()
    {
        return $this->hasMany(Purchase::class);
    }

    public function readingListEntries()
    {
        return $this->hasMany(ReadingList::class);
    }

    public function authorSubmissions()
    {
        return $this->hasMany(AuthorSubmission::class);
    }

    public function activityLogs()
    {
        return $this->hasMany(ActivityLog::class, 'admin_user_id');
    }

    public function isAdmin(): bool
    {
        return $this->role === 'admin';
    }
}
