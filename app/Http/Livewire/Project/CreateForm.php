<?php

namespace App\Http\Livewire\Project;

use App\Models\Award;
use App\Models\Dictionaries\ProjectCategory;
use App\Models\Dictionaries\ProjectTag;
use App\Models\Dictionaries\Region;
use App\Models\Project;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;

class CreateForm extends Component
{
    /** @var string */
    public $project, $description, $end_date, $title, $short_desc, $region_id, $category_id;

    public $award_title, $award_desc, $award_quantity, $award_cost, $is_unlim = false;
    public $awards = [];

    /** @var integer */
    public $amount = 0;

    protected $rules = [
        'title' => ['required', 'max:250'],
        'short_desc' => ['required', 'max:500'],
        'amount' => ['required', 'integer'],
        'description' => ['required'],
        'end_date' => ['required', 'date'],
    ];

    public function save()
    {
        $this->validate();
        $user_id = Auth::id();

        $project = Project::create([
            'title' => $this->title,
            'short_desc' => $this->short_desc,
            'amount' => $this->amount,
            'description' => $this->description,
            'end_date' => $this->end_date,
            'user_id' => $user_id,
            'is_public' => false,
            'category_id' => $this->category_id,
            'region_id' => $this->region_id,
        ]);
        $this->project = $project;
        session()->flash('project_msg', 'Проект сохранен');

    }

    public function saveAward()
    {
        if (!isset($this->project)) {
            session()->flash('award_err', 'Заполните данные в раздели Основные и сохраните их');
            return;
        }

        $this->validate([
            'award_title' => ['required', 'max:250'],
            'award_desc' => ['required', 'max:2000'],
            'award_quantity' => ['nullable', 'integer'],
            'award_cost' => ['required']
        ]);

        Award::create([
            'title' => $this->award_title,
            'description' => $this->award_desc,
            'quantity' => $this->is_unlim ? null : ($this->award_quantity ?? null),
            'min_cost' => $this->award_cost,
            'project_id' => $this->project->id,
        ]);

        $this->clearAwardForm();
        $this->update_awards();

        session()->flash('award_msg', 'Вознаграждение сохранено');
    }

    public function update_awards()
    {
        $this->awards = $this->project->awards;
    }

    public function clearAwardForm()
    {
        $this->award_cost = 0;
        $this->award_quantity = 0;
        $this->award_desc = '';
        $this->award_title = '';
        $this->is_unlim = false;
    }

    public function render()
    {
        return view('livewire.project.create-form', [
            'regions' => Region::all(), 'categories' => ProjectCategory::all(), 'tags' => ProjectTag::all(),
        ])->extends('layouts.app');
    }
}
