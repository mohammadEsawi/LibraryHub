<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ActivityLog extends Model
{
    use HasFactory;

    protected $fillable = [
        'admin_user_id',
        'action',
        'entity_type',
        'entity_id',
        'title',
        'description',
        'meta',
    ];

    protected $casts = [
        'meta' => 'array',
    ];

    public function adminUser()
    {
        return $this->belongsTo(User::class, 'admin_user_id');
    }
}
