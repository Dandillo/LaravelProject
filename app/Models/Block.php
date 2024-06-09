<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Block extends Model
{
    use HasFactory;


    public function projects()
    {
        return $this->belongsToMany(Project::class, BlockProject::class)->withPivot('weight');
    }
}
