<?php

namespace App\Http\Livewire\Admin\Project;

use App\Models\Project;
use Livewire\Component;

class ProjectPayments extends Component
{
    public $project;

    public function mount(Project $project)
    {
        $this->project = $project;
    }

    public function render()
    {
        $payments = $this->project->all_payments()->orderByDesc('created_at')->paginate(20);

        return view('livewire.admin.project.project-payments', ['payments' => $payments])->extends('layouts.admin');
    }
}
