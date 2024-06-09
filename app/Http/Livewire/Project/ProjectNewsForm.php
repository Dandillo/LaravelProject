<?php

namespace App\Http\Livewire\Project;

use App\Models\News;
use App\Models\Project;
use App\Models\ProjectNews;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;

class ProjectNewsForm extends Component
{
    public $project, $project_news, $is_update = false;
    public $news_title, $news_desc, $is_pinned;

    protected $rules = [
        'news_title' => ['required', 'max:250'],
        'news_desc' => ['required'],
    ];

    public function store()
    {
        if (Auth::id() != $this->project->user_id) {
            abort(404);
        }
        $this->validate();

        $project_news = ProjectNews::create([
            'title' => $this->news_title,
            'description' => $this->news_desc,
            'project_id' => $this->project->id,
            'is_pinned' => $this->is_pinned ?? false,
        ]);
        $project_news->save();

        return $this->redirect(route('project.show', ['project' => $this->project->id]));
    }

    public function update()
    {
        if (Auth::id() != $this->project->user_id) {
            abort(404);
        }
        if (!isset($this->project_news)) {
            abort(404);
        }
        if ($this->project_news->is_banned) {
            abort(403);
        }
        $this->validate();

        $this->project_news->update([
            'title' => $this->news_title,
            'description' => $this->news_desc,
            'is_pinned' => $this->is_pinned ?? false,
        ]);

        return $this->redirect(route('project.show', ['project' => $this->project->id]));
    }

    public function mount(Project $project, $news = null)
    {
        $this->project = $project;
        if ($project->user_id != Auth::id()) {
            abort(404);
        }

        if (isset($news)) {
            $this->project_news = ProjectNews::find($news);
            if (!isset($this->project_news)) {
                abort(404);
            }
            $this->is_update = true;
            $this->news_title = $this->project_news->title;
            $this->news_desc = $this->project_news->description;
            $this->is_pinned = $this->project_news->is_pinned;
        }
    }

    public function render()
    {
        return view('livewire.project.project-news-form');
    }
}
