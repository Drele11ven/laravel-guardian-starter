<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class ActivityLog extends Model
{
    protected $fillable = ['user_id', 'method', 'url', 'referer_url', 'ip_address', 'user_agent', 'action'];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
