<?php

namespace App\Http\Livewire\Project;

use App\Models\Faq;
use App\Models\Project;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;

class FaqsBlock extends Component
{
    public $project, $faq_text;

    public function saveFaq()
    {
        if (!Auth::user() || !isset($this->project->id)) {
            abort(500);
        }

        $this->validate([
            'faq_text' => ['required', 'max:2000'],
        ]);

        Faq::create([
            'question' => $this->faq_text,
            'project_id' => $this->project->id,
            'user_id' => Auth::id(),
        ]);

        session()->flash('faq_msg', 'Вопрос отправлен');
        $this->faq_text = '';
    }

    public function mount(Project $project)
    {
        $this->project = $project;
    }

    public function render()
    {
        $project_faq = $this->project->public_faqs;

        return view('livewire.project.faqs-block', ['project_faq' => $project_faq]);
    }
}
