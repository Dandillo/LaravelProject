<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Award extends Model
{
    use HasFactory;

    protected $fillable = ['title', 'description', 'quantity', 'min_cost', 'photo', 'project_id'];

    public function project()
    {
        return $this->belongsTo(Project::class, 'project_id');
    }

    public function not_canc_payments()
    {
        return $this->belongsToMany(Payment::class, 'payment_awards')
            ->where('status', '<>', 'cancelled');
    }
}

