<?php

namespace App\Http\Livewire\Admin\Project;

use App\Models\Dictionaries\ProjectCategory;
use App\Models\Dictionaries\ProjectStatus;
use App\Models\Dictionaries\Region;
use App\Models\Project;
use Illuminate\Support\Facades\Config;
use Livewire\Component;
use Livewire\WithPagination;

class ProjectApplies extends Component
{
    use WithPagination;

    public $categories, $statuses, $regions;
    public $category_id, $region_id, $status_id;

    public $search = '';

    public function mount()
    {
        if (isset($_GET['status_id'])) {
            $this->status_id = $_GET['status_id'];
        }
        $this->categories = ProjectCategory::all();
        $this->statuses = ProjectStatus::all();
        $this->regions = Region::all();
    }

//  Открывает сбор на проект
//  null - создается юзером, 1 - отправлен на проверку, 2 - идет сбор
    public function start_collect($project_id)
    {
        $project = Project::find($project_id);
        if (!isset($project)) {
            abort(404);
        }

        if ($project->status_id == null || $project->status_id == 1) {
            $project->status_id = 2;
            $project->save();

            session()->flash('scs_msg', 'Статус проекта изменен');

        } else {
            session()->flash('err_msg', 'Проект уже переведен в данный статус');
        }

    }


//  Отменяет сбор на проект
    public function cancel_collect($project_id)
    {
        $project = Project::find($project_id);
        if (!isset($project)) {
            abort(404);
        }
        if ($project->status_id == 5 || $project->status_id == 6) {
            session()->flash('err_msg', 'Проект уже переведен в данный статус');

        } elseif ($project->status_id != null && $project->status_id != 1) {
            $project->status_id = 5;
            $project->save();
            session()->flash('scs_msg', 'Статус проекта изменен, проект отменен');
        }
    }

//    Смена статуса на деньги переведены, если проект завершен
    public function money_sent($project_id)
    {
        $project = Project::find($project_id);
        if (!isset($project)) {
            abort(404);
        }
        if ($project->status_id == 3) {
            $project->status_id = 4;
            $project->save();
            session()->flash('scs_msg', 'Статус проекта изменен');
        } else {
            session()->flash('err_msg', 'Нельзя сменить статус на "деньги переведены"');
        }
    }

    //    Смена статуса на деньги не переведены.
    //    Статус деньги не переведены = сбор завершен (3)
    public function money_not_sent($project_id)
    {
        $project = Project::find($project_id);
        if (!isset($project)) {
            abort(404);
        }
        if ($project->status_id == 4) {
            $project->status_id = 3;
            $project->save();
            session()->flash('scs_msg', 'Статус проекта изменен');
        } else {
            session()->flash('err_msg', 'Нельзя сменить статус на "деньги не переведены"');
        }
    }

    public function money_refund($project_id)
    {
        $project = Project::find($project_id);
        if (!isset($project)) {
            abort(404);
        }
        if ($project->status_id == 5) {
            $project->status_id = 6;
            $project->save();
            session()->flash('scs_msg', 'Статус проекта изменен');
        } else {
            session()->flash('err_msg', 'Нельзя сменить статус на "деньги возвращены"');
        }
    }

    public function render()
    {
        $projects = Project::where('title', 'like', '%' . $this->search . '%');
        if ($this->category_id) {
            $projects = $projects->where('category_id', $this->category_id);
        }
        if ($this->region_id) {
            $projects = $projects->where('region_id', $this->region_id);
        }
        if ($this->status_id) {
            $projects = $projects->where('status_id', $this->status_id);
        }

        return view('livewire.admin.project.project-applies', [
            'projects' => $projects->paginate(Config::get('paginate_count'))
        ])->extends('layouts.admin');
    }
}
