<?php

namespace App\Http\Livewire\Project;

use App\Models\News;
use App\Models\Project;
use App\Models\ProjectNews;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;

class NewsBlock extends Component
{
    public $project;
    public $news_count;
    private $news_on_page = 2;
    private $step = 2;

    public function loadMoreNews()
    {
        if (($this->news_on_page + $this->step) >= $this->news_count) {
            $this->news_on_page = $this->news_count;
        } else {
            $this->news_on_page += $this->step;
        }
    }

    public function mount(Project $project)
    {
        $this->project = $project;
        $this->news_count = $project->news()->count();
    }

    public function render()
    {
        $project_news = $this->project->public_news->sortByDesc('is_pinned');
        $project_news = $project_news->forPage(1, $this->news_on_page);
        return view('livewire.project.news-block', ['project_news' => $project_news,]);
    }
}
