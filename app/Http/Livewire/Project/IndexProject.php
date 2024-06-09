<?php

namespace App\Http\Livewire\Project;

use App\Models\Block;
use App\Models\Dictionaries\ProjectCategory;
use App\Models\Dictionaries\ProjectStatus;
use App\Models\Dictionaries\ProjectTag;
use App\Models\Dictionaries\Region;
use App\Models\Project;
use Livewire\Component;
use Livewire\WithPagination;

class IndexProject extends Component
{
    use WithPagination;

    public $category_id, $tag_id, $status_id, $region_id, $query = '';
    public $categories, $tags, $regions;

    protected $listeners = ['search' => '$refresh'];
    public $carousel_projects;

    public function mount()
    {
        if (isset($_GET['status_id'])) {
            $this->status_id = $_GET['status_id'];
        }
        if (isset($_GET['region_id'])) {
            $this->region_id = $_GET['region_id'];
        }
        if (isset($_GET['category_id'])) {
            $this->category_id = $_GET['category_id'];
        }
        if (isset($_GET['tag_id'])) {
            $this->tag_id = $_GET['tag_id'];
        }
        $this->categories = ProjectCategory::all(['id','name']);
        $this->tags = ProjectTag::all(['id','name']);
        $this->regions = Region::all(['id','name']);

//       Проекты закрепленные в блоке projects_carousel
        $this->carousel_projects = Block::where('type', 'projects_carousel')->first()
            ->projects()->orderByDesc('pivot_weight')->get();
    }

    public function render()
    {
//        Составление запроса по подбору проекта
//        проекты,которые отменены или еще создаются, не выводятся
        $projects = Project::whereNotIn('status_id', [1, 5, 6])
            ->where('title', 'like', '%' . $this->query . '%')->orderByDesc('projects.created_at');
        if ($this->category_id) {
            $projects = $projects->where('category_id', $this->category_id);
        }
        if ($this->region_id) {
            $projects = $projects->where('region_id', $this->region_id);
        }
        if ($this->tag_id) {
            $projects = $projects->leftJoin('projects_project_tags', 'projects_project_tags.project_id', '=', 'projects.id')
                ->where('project_tag_id', $this->tag_id);
        }
        if ($this->status_id) {
            switch ($this->status_id) {
                case 2:
                    $projects = $projects->where('status_id', 2);
                    break;
                case 3:
                    $projects = $projects->whereIn('status_id', [3, 4]);
                    break;
                default:
                    break;
            }
        }

        return view('livewire.project.index-project',
            ['projects' => $projects->paginate(12)])->extends('layouts.app');
    }
}
