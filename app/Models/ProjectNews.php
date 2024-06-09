<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProjectNews extends Model
{
    use HasFactory;

    protected $fillable = ['title', 'description', 'project_id', 'is_pinned',
        'is_banned', 'ban_date', 'banned_admin'];

    public function project(): \Illuminate\Database\Eloquent\Relations\BelongsTo
    {
        return $this->belongsTo(Project::class, 'project_id');
    }
}
