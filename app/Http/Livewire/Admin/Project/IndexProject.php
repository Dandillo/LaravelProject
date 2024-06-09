<?php

namespace App\Http\Livewire\Admin\Project;

use App\Models\Dictionaries\ProjectCategory;
use App\Models\Dictionaries\ProjectStatus;
use App\Models\Dictionaries\Region;
use App\Models\Project;
use Illuminate\Support\Facades\Config;
use Livewire\Component;
use Livewire\WithPagination;

class IndexProject extends Component
{
    use WithPagination;

    public $categories, $statuses, $regions;
    public $category_id, $region_id, $status_id;

    public $search = '';



    public function mount()
    {
        if(isset($_GET['status_id'])){
            $this->status_id = $_GET['status_id'];
        }
        $this->categories = ProjectCategory::all();
        $this->statuses = ProjectStatus::all();
        $this->regions = Region::all();
    }

    public function render()
    {
        $projects = Project::where('title', 'like', '%' . $this->search . '%');
        if ($this->category_id) {
            $projects = $projects->where('category_id', $this->category_id);
        }
        if($this->region_id){
            $projects = $projects->where('region_id', $this->region_id);
        }
        if($this->status_id){
            $projects = $projects->where('status_id', $this->status_id);
        }

        return view('livewire.admin.project.index-project', [
            'projects' => $projects->paginate(Config::get('paginate_count'))
        ])->extends('layouts.admin');
    }
}
