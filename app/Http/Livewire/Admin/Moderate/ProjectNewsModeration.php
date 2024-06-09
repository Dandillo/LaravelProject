<?php

namespace App\Http\Livewire\Admin\Moderate;

use App\Models\Comment;
use App\Models\ProjectNews;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Config;
use Livewire\Component;

class ProjectNewsModeration extends Component
{
    public $status = null;

    //  Подтверждение проверки контента
    public function checked_project_part(ProjectNews $project_news)
    {
        $project_news->update([
            'is_banned' => false,
        ]);

        session()->flash('scs_msg', 'Данная новость проверена');
    }

    //  Блокировка контента
    public function block_project_part(ProjectNews $project_news)
    {
        if ($project_news->is_banned) {
            session()->flash('scs_msg', 'Данная новость уже заблокирована');
            return;
        }

        $project_news->update([
            'is_banned' => true,
            'ban_date' => now(),
            'banned_admin' => Auth::id(),
        ]);
        session()->flash('scs_msg', 'Данная новость успешно заблокирована');
    }

    public function render()
    {
        $project_news = ProjectNews::where('is_banned', ($this->status == '') ? null : $this->status)
            ->paginate(Config::get('paginate_count', 20));
        return view('livewire.admin.moderate.project-news-moderation', compact(['project_news']))->extends('layouts.admin');
    }
}
