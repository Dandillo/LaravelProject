<?php

namespace App\Http\Livewire\User;

use App\Models\Award;
use App\Models\PaymentAward;
use App\Models\Project;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;

class Profile extends Component
{
    public $projects, $supported_projects, $awards;

    public function mount()
    {
        $user = Auth::user();
        $this->projects = $user->projects;

        $payments = $user->payments();
        $this->supported_projects = Project::find($payments->pluck('project_id'));

        //      Загрузка вознаграждений пользователя, через платежи
        $this->awards = collect();
        foreach ($payments->get() as $item) {
            foreach ($item->awards as $award) {
                $award->payment_status = $item->status;
                $this->awards->push($award);
            }
        }
    }

//   Завершение сбора перевод в статус 3
    public function end_collect($project_id)
    {
        $project = Project::find($project_id);
        if (!isset($project)) {
            abort(404);
        }

        if ($project->status_id == 2 || $project->status_id == 3) {
            $project->status_id = 3;
            $project->save();

            session()->flash('project_msg', 'Заявка на завершиние сбора отправлена');
            return redirect()->intended(route('user.profile'));
        } else {
            session()->flash('err_msg', 'Сбор не может быть завершен');
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
            session()->flash('project_msg', 'Статус проекта изменен, проект отменен');
        }
    }


    public function render()
    {
        return view('livewire.user.profile')->extends('layouts.app');
    }
}
