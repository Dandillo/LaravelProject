<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Faq extends Model
{
    use HasFactory;

    protected $fillable = ['question', 'answer', 'user_id', 'project_id', 'is_public',
        'is_banned', 'ban_date', 'banned_admin'];

    public function project()
    {
        return $this->belongsTo(Project::class, 'project_id');
    }
}
