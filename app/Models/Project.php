<?php

namespace App\Models;

use App\Models\Dictionaries\ProjectCategory;
use App\Models\Dictionaries\ProjectStatus;
use App\Models\Dictionaries\ProjectTag;
use App\Models\Dictionaries\Region;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use function Symfony\Component\Translation\t;

class Project extends Model
{
    use HasFactory;

    protected $fillable = ['title', 'user_id', 'short_desc', 'description', 'amount', 'end_date',
        'files', 'image_card', 'image_header', 'video',
        'category_id', 'region_id', 'status_id', 'is_public'];

//    protected $dates =[
//        'end_date', 'created_at'
//    ];

    public function region()
    {
        return $this->belongsTo(Region::class, 'region_id');
    }

    public function author()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function category()
    {
        return $this->belongsTo(ProjectCategory::class, 'category_id');
    }

    public function tags()
    {
        return $this->belongsToMany(ProjectTag::class, 'projects_project_tags');
    }

    public function status()
    {
        return $this->belongsTo(ProjectStatus::class, 'status_id');
    }

    public function news()
    {
        return $this->hasMany(ProjectNews::class, 'project_id');
    }

    public function public_news()
    {
        return $this->hasMany(ProjectNews::class, 'project_id')->whereNull('is_banned')
            ->orWhere('is_banned', '<>', true);
    }

    public function comments()
    {
        return $this->hasMany(Comment::class, 'project_id');
    }

    public function public_comments()
    {
        return $this->hasMany(Comment::class, 'project_id')->whereNull('is_banned')
            ->orWhere('is_banned', '<>', true);
    }

    public function public_faqs()
    {
        return $this->hasMany(Faq::class, 'project_id')->where('is_public', true)
            ->whereNull('is_banned')
            ->orWhere('is_banned', '<>', true);
    }

    public function new_faqs()
    {
        return $this->hasMany(Faq::class, 'project_id')->where('is_public', false);
    }

    public function awards()
    {
        return $this->hasMany(Award::class, 'project_id');
    }

    public function suc_payments()
    {
        return $this->hasMany(Payment::class, 'project_id')->where('status', 'succeeded');
    }

    public function all_payments()
    {
        return $this->hasMany(Payment::class, 'project_id');
    }

//    Users who sent money
    public function shareholders()
    {
        return $this->belongsToMany(User::class, 'payments');
    }

}
