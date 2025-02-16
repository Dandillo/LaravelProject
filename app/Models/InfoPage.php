<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class InfoPage extends Model
{
    use HasFactory;

    protected $fillable = ['link', 'text', 'title', 'is_public'];
}
