<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Report extends Model
{
    use HasFactory;

    protected $fillable = ['email', 'report_text', 'project_id', 'is_checked'];

    public function project(){
        return $this->belongsTo(Project::class, 'project_id');
    }
}
