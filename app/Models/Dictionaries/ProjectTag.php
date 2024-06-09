<?php

namespace App\Models\Dictionaries;

use App\Models\Project;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProjectTag extends Model
{
    use HasFactory;

    protected $fillable = ['name'];

    function projects()
    {
        return $this->belongsToMany(Project::class, 'projects_project_tags');
    }
}
