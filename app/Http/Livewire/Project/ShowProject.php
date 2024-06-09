<?php

namespace App\Http\Livewire\Project;

use App\Models\Comment;
use App\Models\Faq;
use App\Models\Project;
use App\Models\ProjectNews;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;
use Livewire\WithPagination;

class ShowProject extends Component
{
    use WithPagination;

    public $project, $awards;
    public $comment_text;

    public function saveComment()
    {
        if (!Auth::user() || !isset($this->project->id)) {
            abort(500);
        }
        $this->validate([
            'comment_text' => ['required', 'max:150'],
        ]);

        Comment::create([
            'text' => $this->comment_text,
            'project_id' => $this->project->id,
            'user_id' => Auth::id(),
            'is_active' => true,
        ]);

        session()->flash('com_msg', 'Комментарий сохранен');
        $this->comment_text = '';
    }

    public function mount(Project $project)
    {
        $this->project = $project;
//       Проверка доступа к проекту по статусу
        if (in_array($project->status_id, [null, 1, 6])) {
            if (!(Auth::user() && Auth::user()->hasRole('admin'))) {
                abort(404);
            }
        }

        $this->awards = $project->awards;
        foreach ($this->awards as $award) {
            $paid_awards = $award->not_canc_payments->count();
            $award->quantity = $award->quantity - $paid_awards;
        }
    }

    public function render()
    {
        //Получение списка поддержавших проект
        $shareholders = $this->project->shareholders()->distinct()->paginate(15);

        $sum = $this->project->suc_payments->pluck('amount')->sum();
        $percent = round(($sum * 100) / $this->project->amount, 1);
        $project_comments = $this->project->public_comments()->orderByDesc('created_at')->paginate(20);

        return view('livewire.project.show-project', ['project_comments' => $project_comments, 'shareholders' =>
            $shareholders, 'sum' => $sum, 'percent' => $percent])->extends('layouts.app');
    }

}
