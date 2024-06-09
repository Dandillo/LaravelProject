<?php

namespace App\Http\Livewire\User;

use App\Models\Project;
use App\Models\User;
use Livewire\Component;

class UserPage extends Component
{
    public $user, $created_projects, $supported_projects;

    public function mount(User $user)
    {
        $this->user = $user;
        $this->created_projects = $user->projects->whereNotIn('status_id', [null, 1]);
        $payments = $user->payments()->pluck('project_id');
        $this->supported_projects = Project::find($payments);
    }

    public function render()
    {
        return view('livewire.user.user-page');
    }
}
